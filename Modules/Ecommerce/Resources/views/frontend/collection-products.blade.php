@extends('ecommerce::frontend.layout.main')

@section('title') {{ $ecommerce_setting->site_title ?? '' }} @endsection

@section('description')  @endsection

@section('content')
	<!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="page-title">{{$collection->name}}</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">{{$collection->name}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->
    <!--Shop cart starts-->
    <section class="shop-cart-section">
        <div class="container-fluid">
        	<div class="product-grid">
            	@foreach($products as $product)
                @include('ecommerce::frontend.includes.product-template')
                @endforeach
            </div>
        </div>
    </section>
    <!--Shop cart ends-->
@endsection

@section('script')
<script type="text/javascript">
    "use strict";

    $(document).on('click', '.add-to-cart', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var parent = '#add_to_cart_'+id;

        var qty = $(parent+" input[name=qty]").val();

        var route = "{{ route('addToCart') }}";

        $.ajax({
            url: route,
            type:"POST",
            data:{
                product_id: id,
                qty: qty,
            },
            success:function(response){
                console.log(response);
                if(response) {
                    $('.alert').addClass('alert-custom show');
                    $('.alert-custom .message').html(response.success);
                    $('.cart__menu .cart_qty').html(response.total_qty);
                    $('.cart__menu .total').html('{{$currency->symbol ?? $currency->code}}'+response.subTotal.toFixed(2));

                    setTimeout(function() {
                        $('.alert').removeClass('show');
                    }, 4000);
                }
            },
        });
    })
</script>
@endsection