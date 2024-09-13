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

@if (session()->has('error'))
    <div class="d-flex justify-content-center">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('error')}}!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif


<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="container-fluid" id="errorMessage"></div>

                <form action="{{route('payment.pay.confirm','paydunya')}}" method="post">
                    @csrf
                    <input type="hidden" name="requestData" value="{{ $requestData }}">
                    <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">

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
</div>
@endsection

@push('payment_scripts')
    <script type="text/javascript">
        
    </script>
@endpush
