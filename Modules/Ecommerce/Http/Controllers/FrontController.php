<?php

namespace Modules\Ecommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\Ecommerce\Entities\Sliders;
use App\Models\Product;
use App\Models\Category;
use Modules\Ecommerce\Entities\Page;
use Modules\Ecommerce\Mail\ContactUs;
use App\Models\MailSetting;
use DB;
use Mail;
use Auth;
use Cache;
use Intervention\Image\Facades\Image;
use File;

class FrontController extends Controller
{
    use \App\Traits\MailInfo;

    public function index()
    {
        $sliders = DB::table('sliders')->orderBy('order', 'asc')->get();

        $ecommerce_setting = Cache::get('ecommerce_setting');

        if(isset($ecommerce_setting->home_page)) {
            $home = $ecommerce_setting->home_page;
        }            
        
        if(isset($home)){
            $page = DB::table('pages')->where('id',$home)->first();

            if(isset($page)){
                if($page->template == 'home'){
                    $widgets = DB::table('page_widgets')->where('page_id',$home)->orderBy('order','ASC')->get();
                }

                $recently_viewed = [];
                if(session()->has('recently_viewed')){
                    $recently_viewed = session()->get('recently_viewed');
                }
                
                return view('ecommerce::frontend/home', compact('sliders', 'widgets', 'recently_viewed'));
            }
        }

        return view('ecommerce::frontend/home', compact('sliders'));
    }

    public function page($slug)
    {
        $page = DB::table('pages')->where('slug', $slug)->where('status', 1)->first();
        
        if(isset($page)){
            if($page->template == 'faq'){
                $categories = DB::table('faq_categories')->orderBy('order','ASC')->get();
                $faqs = DB::table('faqs')->orderBy('order','ASC')->get();
                return view('ecommerce::frontend.faq', compact('page','faqs','categories'));
            }

            if($page->template == 'contact'){
                return view('ecommerce::frontend.contact', compact('page'));
            }
        }

        return view('ecommerce::frontend.page-show', compact('page'));
    }

    public function blog()
    {
        $blogs = DB::table('blogs')->get();

        return view('ecommerce::frontend.blog', compact('blogs'));
    }

    public function blogPost($slug)
    {
        $post = DB::table('blogs')->where('slug', $slug)->first();

        return view('ecommerce::frontend.blog-details', compact('post'));
    }

    public function trackOrder($order_id='',$email='')
    {
        if(($order_id != '') && ($email != '')){
            $customer = DB::table('customers')->where('email',$email)->first();
            $sale = DB::table('sales')->where('customer_id',$customer->id)->where('reference_no',$order_id)->first();
            $delivery = DB::table('deliveries')->where('sale_id',$sale->id)->first();
            $product_sales = DB::table('product_sales')
                             ->join('products','product_sales.product_id','=','products.id')
                             ->select('products.name','products.image','products.is_variant','products.variant_option','product_sales.*')
                             ->where('sale_id',$sale->id)
                             ->get();
            if(!isset($delivery)){
                $delivery = 0;
            }
            return view('ecommerce::frontend.track-order', compact('sale','customer','delivery','product_sales'));
        } else {
            return view('ecommerce::frontend.track-order');
        }
    }

    public function search($product)
    {
        $search = $product;
        $data = DB::table('products')->select('id', 'image', 'name', 'slug')
            ->where('is_active', 1)
            ->where('is_online', 1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tags', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return response()->json($data);
    }

    public function searchProduct(Request $request)
    {
        $search = htmlspecialchars($request->input('search'));
        $products = DB::table('products')->where('is_active', 1)->where('is_online', 1)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tags', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return view('ecommerce::frontend/products-search', compact('products', 'search'));
    }

    public function productDetails($product_name, $product_id)
    {
        $recently_viewed = session()->has('recently_viewed') ? session()->get('recently_viewed') : [];
        if(!array_key_exists($product_id, $recently_viewed)) {
            array_push($recently_viewed,$product_id);
            session(['recently_viewed' => $recently_viewed]);
    	}

        $product = DB::table('products')
                   ->where('id', $product_id)
                   ->where('is_active', 1)
                   ->where('is_online', 1)
                   ->first();

        if($product->variant_option) {
            $product->variant_option = json_decode($product->variant_option);
            $product->variant_value = json_decode($product->variant_value);
        }
        
        $brand = DB::table('brands')->where('id',$product->brand_id)->first();
        
        $categories = Cache::get('category_list');
        $category = $categories->where('id',$product->category_id)->first();

        $product_arr = explode(',',$product->related_products);
        $related_products = DB::table('products')->whereIn('id',$product_arr)->get(); 

        $recently_viewed = [];
        if(session()->has('recently_viewed')){
            $recently_viewed = session()->get('recently_viewed');
        }

        return view('ecommerce::frontend/product-details', compact('product','brand','category','related_products','recently_viewed'));
    }

    public function allProducts()
    {
        $data = Product::select('id', 'image', 'name', 'price', 'promotion_price')->where('is_active', 1)->where('is_online', 1)->take(10)->get();

        return response()->json($data);
    }

    public function category($category, Request $request)
    {
        $category = DB::table('categories')
                    ->select('id','name','slug','page_title','short_description')
                    ->where('slug', $category)
                    ->where('is_active', 1)->first();

        $sub_categories = DB::table('categories')
                          ->select('id','name','slug','page_title','short_description')
                          ->where('parent_id', $category->id)
                          ->where('is_active', 1)->get();
        
        if (count($sub_categories) > 0) {

            $sub_cats = [];
            foreach($sub_categories as $cat){
                array_push($sub_cats, $cat->id);
            }

            $products = DB::table('products')
                        ->where('is_active', 1)
                        ->where('is_online', 1)
                        ->where(function($query) use ($category,$sub_cats){
                            $query->where('category_id', $category->id);
                            $query->orWhereIn('category_id',$sub_cats);
                        })
                        ->paginate(10);

            if ($request->ajax()) {
                $view = view('ecommerce::frontend/products-load-more', compact('products'))->render();
                return response()->json(['html' => $view]);
            }

            return view('ecommerce::frontend/products', compact('products', 'category'));
        } else {

            $products = DB::table('products')->where('category_id', $category->id)->where('is_active', 1)->where('is_online', 1)->paginate(10);

            if ($request->ajax()) {
                $view = view('ecommerce::frontend/products-load-more', compact('products'))->render();
                return response()->json(['html' => $view]);
            }

            return view('ecommerce::frontend/products', compact('products', 'category'));
        }
    }

    public function shop()
    {
        $categories = cache('category_list')->where('parent_id', Null);

        return view('ecommerce::frontend.shop', compact('categories'));
    }

    public function brandProducts($brand, Request $request)
    {
        $brand = DB::table('brands')->where('slug', $brand)->where('is_active', 1)->first();

        $products = DB::table('products')->where('brand_id', $brand->id)->where('is_active', 1)->where('is_online', 1)->paginate(5);

        if ($request->ajax()) {
            $view = view('ecommerce::frontend/brand-products-load-more', compact('products'))->render();
            return response()->json(['html' => $view]);
        }

        return view('ecommerce::frontend/brand-products', compact('products', 'brand'));
    }

    public function collectionProducts($collection, Request $request)
    {
        $collection = DB::table('collections')->where('slug', $collection)->where('status', 1)->first();

        $product_arr = explode(',',$collection->products);

        $products = DB::table('products')->whereIn('id', $product_arr)->where('is_active', 1)->where('is_online', 1)->get();

        return view('ecommerce::frontend/collection-products', compact('products', 'collection'));
    }

    public function contactMail(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'message' => $request->input('message'),
        ];

        $email_to = Cache::get('ecommerce_setting')->contact_form_email;

        $mail_setting = MailSetting::latest()->first();
        $this->setMailInfo($mail_setting);
        Mail::to($email_to)->send(new ContactUs($data));

        return response()->json('success');
    }

    public function newsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'  => 'required|unique:newsletter,email',
        ]);

        if($validator->fails()) {
            $messages = $validator->messages();
            return $validator->errors();
        } else {

            $data = $request->except('_token');
            DB::table('newsletter')->insert($data);

            return response()->json('success');
        }
    }

    public function sessionRenew(Request $request)
    {
        return response()->json('success'); 
    }

}
