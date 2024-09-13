@extends('payment.master')
@section('payment')

<div class="row">
    <div class="col-12">
        <h1 class="page-title h2 text-center uppercase mt-1 mb-5">{{ $paymentMethodName }}
            <small>
                ({{ number_format((float)$totalAmount, 2, '.', '') }})
            </small>
        </h1>
    </div>
</div>


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">

                @if($message = Session::get('error'))
                    <div class="d-flex justify-content-center">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <form action="{{route('payment.pay.confirm','razorpay')}}" method="post" id="razorpayPaymentForm">
                    @csrf
                    <input type="hidden" name="requestData" value="{{$requestData}}">
                    <input type="hidden" name="totalAmount" value="{{$totalAmount}}">
                    <input type="hidden" name="central_domain" value="{{env('CENTRAL_DOMAIN')}}">
                    <input type="hidden" name="redirectUrl" value="muri">

                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{$razorpay_key}}"
                        data-amount="{{ $totalAmount * 100 }}"
                        {{-- data-buttontext="Pay Now {{ $totalAmount }} INR" --}}
                        data-name=""
                        data-description="Razorpay"
                        data-image=""
                        data-prefill.name="name"
                        data-prefill.email="email"
                        data-theme.color="#ff7529">
                    </script>

                    <div class="mt-4 d-grid gap-2 mx-auto">
                        <button type="submit" id="payNowBtn" class="btn btn-outline-success">
                            Pay Now
                            <small>
                                {{ number_format((float)$totalAmount, 2, '.', '') }}
                            </small>
                        </button>
                    </div>
                    <div class="mt-3 d-grid gap-2 mx-auto">
                        <button type="button" id="payCancelBtn" class="btn btn-outline-danger">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>

@endsection

@push('payment_scripts')
    <script type="text/javascript">
        var requestData = JSON.parse($('input[name=requestData]').val());
        if(requestData.tenant) {
            centralDomain = $('input[name=central_domain]').val();
            successUrl = 'https://'+requestData.tenant+'.'+centralDomain;
        }
        else {
            successUrl = 'https://'+JSON.parse(requestData.allDomains)+'/change-permission?key=0&length=1&package_id='+requestData.package_id+'&expiry_date='+requestData.expiry_date+'&subscription_type='+requestData.subscription_type+'&allDomains='+requestData.allDomains+'&abandoned_permission_ids='+requestData.abandoned_permission_ids+'&permission_ids='+requestData.permission_ids+'&modules='+requestData.modules+'&routeName='+JSON.parse(requestData.allDomains);
        }
        $("input[name=redirectUrl]").val(successUrl);

        let targetURL = "{{ url('/payment/razorpay/pay/confirm')}}";
        let cancelURL = "{{ url('payment/razorpay/pay/cancel')}}";
        let redirectURL = successUrl;
        let redirectURLAfterCancel = "{{ url('/')}}";
    </script>
    <script type="text/javascript" src="{{ asset('js/payment/razorpay.js') }}"></script>
@endpush
