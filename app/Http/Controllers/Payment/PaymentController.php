<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\landlord\Tenant;
use App\Models\landlord\Page;
use DB;
use Cache;
use App\Models\landlord\Package;
use App\Models\landlord\TenantPayment;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    use \App\Traits\TenantInfo;

    public function tenantCheckout(Request $request) {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $package = Package::select('is_free_trial')->find($request->package_id);
        $general_setting = GeneralSetting::select('active_payment_gateway')->latest()->first();
        $active_payment_gateway = explode(",", $general_setting->active_payment_gateway);
        $search = 'Terms';
        $terms_and_condition_page = Page::select('slug')->where('title', 'LIKE', "%{$search}%")->first();
        if($package->is_free_trial) {
            
            $this->createTenant($request);
            if(env('SERVER_TYPE') == 'plesk') {
                $url = 'https://'.$request->tenant.'.'.env('CENTRAL_DOMAIN');
                return redirect('create-subdomain?subdomain='.$request->tenant.'&url='.$url);
            }
            return \Redirect::to('https://'.$request->tenant.'.'.env('CENTRAL_DOMAIN'));
        }
        else
            return view('payment.tenant_checkout', compact('request', 'active_payment_gateway', 'terms_and_condition_page'));
    }

    public function paymentProcees(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Check your all request validation, filter or apply other condition what you need
        |--------------------------------------------------------------------------
        */
        return redirect(route("payment.pay.page",$request->payment_type), 307);
    }

    public function paymentPayPage($paymentMethod, Request $request)
    {
        if(gettype($request->requestData) === 'string') {
            //during bkash, when it redirects back the bkash page after getting any error. Because this time request was empty
            $requestData = $request->requestData;
            $request = json_decode($request->requestData);
        } else {
            $requestData = json_encode($request->all());
        }


        $package = Package::select('features')->find($request->package_id);
        $features = json_decode($package->features);
        $modules = [];
        if(in_array("ecommerce", $features))
            $modules[] = "ecommerce";
        if(in_array("woocommerce", $features))
            $modules[] = "woocommerce";
        if(count($modules))
            $modules = implode(",", $modules);
        else
            $modules = '';

        // $requestData = json_encode($request->all());
        $totalAmount = $request->price;
        switch ($paymentMethod) {
            case 'stripe':
                $paymentMethodName = "Stripe";
                $stripe_public_key = GeneralSetting::select('stripe_public_key')->latest()->first()->stripe_public_key;
                return view('payment.payment_page.stripe',compact('paymentMethodName','paymentMethod','requestData','totalAmount', 'stripe_public_key', 'modules'));
            case 'paypal':
                $paymentMethodName = "Paypal";
                $general_setting = GeneralSetting::select('paypal_client_id', 'currency')->latest()->first();
                $paypal_client_id = $general_setting->paypal_client_id;
                $currency = $general_setting->currency;
                return view('payment.payment_page.paypal',compact('paymentMethodName','paymentMethod','requestData','totalAmount', 'paypal_client_id', 'currency'));
            case 'razorpay':
                $paymentMethodName = "Razorpay";
                $razorpay_key = GeneralSetting::select('razorpay_key')->latest()->first()->razorpay_key;
                return view('payment.payment_page.razorpay',compact('paymentMethodName','paymentMethod','requestData','totalAmount', 'razorpay_key'));
            case 'paystack':
                $paymentMethodName = "Paystack";
                $paystack_secret_key = GeneralSetting::select('paystack_secret_key')->latest()->first()->paystack_secret_key;
                return view('payment.payment_page.paystack',compact('paymentMethodName','paymentMethod','requestData','totalAmount', 'paystack_secret_key'));
            case 'paydunya':
                $paymentMethodName = "Paydunya";
                return view('payment.payment_page.paydunya',compact('paymentMethodName','paymentMethod','requestData','totalAmount'));
            case 'bkash':
                $paymentMethodName = "bKash";
                return view('payment.payment_page.bkash',compact('paymentMethodName','paymentMethod','requestData','totalAmount'));
            case 'ssl_commerz':
                $paymentMethodName = "SSL Commerz";
                return view('payment.payment_page.ssl_commerz',compact('paymentMethodName','paymentMethod','requestData','totalAmount'));
            default:
                break;
        }
        return;
    }

    public function paymentPayConfirm($paymentMethod, Request $request, PaymentService $paymentService) {

        $requestData = json_decode(str_replace('&quot;', '"', $request->requestData));

        if($paymentMethod == 'stripe' || $paymentMethod == 'paypal' || $paymentMethod == 'razorpay') {
            $data = json_decode($request->requestData);
            $total_amount = json_decode($request->total_amount);
            if($data->tenant) {
                $data->payment_method = $paymentMethod;
                $this->createTenant($data);
            }
            else if($data->renewal) {
                $tenant = Tenant::find($data->id);
                $tenant->update(['expiry_date' => $data->expiry_date, 'package_id' => $data->package_id, 'subscription_type' => $data->subscription_type]);
                TenantPayment::create(['tenant_id' => $data->id, 'amount' => $data->price, 'paid_by' => $paymentMethod]);
            }
            $payment = $paymentService->initialize($paymentMethod);
            return $payment->pay($requestData, $request->all());
        }
        else {
            //inseting request data to the session

            session(['tenant_id' => $requestData->id, 'subscription_type' => $requestData->subscription_type, 'package_id' => $requestData->package_id, 'company_name' => $requestData->company_name, 'phone_number' => $requestData->phone_number, 'email' => $requestData->email, 'name' => $requestData->name, 'password' => $requestData->password, 'tenant' => $requestData->tenant, 'renewal' => $requestData->renewal, 'expiry_date' => $requestData->expiry_date, 'allDomains' => $requestData->allDomains, 'permission_ids' => $requestData->permission_ids, 'abandoned_permission_ids' => $requestData->abandoned_permission_ids, 'price' => $requestData->price, 'payment_type' => $requestData->payment_type]);
            $payment = $paymentService->initialize($paymentMethod);

            if($paymentMethod == 'paystack')
                $requestData->paystack_secret_key = $request->paystack_secret_key;

            return $payment->pay($requestData, $request->all());
        }
    }


    public function paymentPayCancel($paymentMethod, PaymentService $paymentService){
        $payment = $paymentService->initialize($paymentMethod);
        return $payment->cancel();
    }

    public function success()
    {
        if(session()->get('tenant')) {
            $requestData = new Request();
            $requestData->subscription_type = session()->get('subscription_type');
            $requestData->package_id = session()->get('package_id');
            $requestData->company_name = session()->get('company_name');
            $requestData->phone_number = session()->get('phone_number');
            $requestData->email = session()->get('email');
            $requestData->name = session()->get('name');
            $requestData->password = session()->get('password');
            $requestData->tenant = session()->get('tenant');
            $requestData->expiry_date = session()->get('expiry_date');
            $this->createTenant($requestData);
            session(['tenant' => 0]);
            return \Redirect::to('https://'.$requestData->tenant.'.'.env('CENTRAL_DOMAIN'));
        }
        elseif(session()->get('renewal')) {
            $allDomains = json_decode(session()->get('allDomains'));
            $tenant = Tenant::find(session()->get('tenant_id'));
            $tenant->update(['expiry_date' => session()->get('expiry_date'), 'package_id' => session()->get('package_id'), 'subscription_type' => session()->get('subscription_type')]);
            TenantPayment::create(['tenant_id' => session()->get('tenant_id'), 'amount' => session()->get('price'), 'paid_by' => session()->get('payment_type')]);
            $url = 'https://'.$allDomains[0].'/change-permission?key=0&length=1&package_id='.session()->get('package_id').'&expiry_date='.session()->get('expiry_date').'&subscription_type='.session()->get('subscription_type').'&allDomains='.session()->get('allDomains').'&abandoned_permission_ids='.session()->get('abandoned_permission_ids').'&permission_ids='.session()->get('permission_ids').'&routeName='.$allDomains[0].'/login';
            //return $url;
            return \Redirect::to($url);
        }
    }

    public function BkashSuccess(Request $request)
    {
        if($request->status == 'success')
            return $this->success();
        else
            return redirect('/');
    }

    public function SslSuccess(Request $request)
    {
        // return $request;
        if(isset($request->value_a)) {
            $user_data = explode(',',  $request->value_a);
            //return $user_data;
            if($user_data[9] == 'tenant') {
                $requestData = new Request();
                $requestData->subscription_type = $user_data[0];
                $requestData->package_id = $user_data[1];
                $requestData->company_name = $user_data[2];
                $requestData->phone_number = $user_data[3];
                $requestData->email = $user_data[4];
                $requestData->name = $user_data[5];
                $requestData->password = $user_data[6];
                $requestData->expiry_date = $user_data[7];
                $requestData->tenant = $user_data[8];
                $this->createTenant($requestData);
                session(['tenant' => 0]);
                return \Redirect::to('https://'.$requestData->tenant.'.'.env('CENTRAL_DOMAIN'));
            }
            else {
                $allDomains = explode(',', $request->value_b);
                $permission_ids = explode(',', $request->value_c);
                $tenant = Tenant::find($user_data[8]);
                $tenant->update(['expiry_date' => $user_data[7], 'package_id' => $user_data[1], 'subscription_type' => $user_data[0]]);
                TenantPayment::create(['tenant_id' => $user_data[8], 'amount' => $request->amount, 'paid_by' => 'SSL_Commerz']);
                $url = 'https://'.$allDomains[0].'/change-permission?key=0&length=1&package_id='.$user_data[1].'&expiry_date='.$user_data[7].'&subscription_type='.$user_data[0].'&allDomains='.json_encode($allDomains).'&abandoned_permission_ids='.session()->get('abandoned_permission_ids').'&permission_ids='.json_encode($permission_ids).'&routeName='.$allDomains[0].'/login';
                //return $url;
                return \Redirect::to($url);
            }
        }
    }

    /*
    |-----------
    |Paystack
    |-----------
    */
    public function handleGatewayCallback(PaymentService $paymentService){
        $payment = $paymentService->initialize('paystack');
        return $payment->paymentCallback();
    }


}
