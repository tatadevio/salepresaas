@extends('ecommerce::frontend.layout.main')

@section('title') {{ $ecommerce_setting->site_title ?? '' }} @endsection

@section('description')  @endsection

@section('content')
	<!--Breadcrumb Area start-->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="page-title">{{trans('file.My Account')}}</h1>
                    <ul>
                        <li><a href="{{url('customer/profile')}}">{{trans('file.dashboard')}}</a></li>
                        <li class="active">{{trans('file.My Account')}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb Area ends-->
    <!--My account Dashboard starts-->
    <section class="my-account-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="user-sidebar-menu">
                        @include('ecommerce::frontend.customer-menu')
                    </div>
                </div>
                <div class="col-md-9 tabs style1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-dashboard-tab__content tab-content">
                                <div class="tab-pane fade show active" id="account_details" role="tabpanel">
                                    <form class="mar-top-40 row" action="{{route('updateAccountDetails')}}" method="post">
                                        @csrf
                                        <div class="form-group col-12">
                                            <label>{{trans('file.Name')}} *</label>
                                            <input class="form-control" type="text" name="name" value="{{ $customer->name ?? auth()->user()->name }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{trans('file.email')}} *</label>
                                            <input class="form-control" type="email" name="email" value="{{ $customer->email ?? auth()->user()->email }}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{trans('file.Phone')}}</label>
                                            <input class="form-control" type="text" name="phone" value="{{ $customer->phone_number ?? ' ' }}" required>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="button style1 mt-3">{{trans('file.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--My account Dashboard ends-->
@endsection

@section('script')

@endsection