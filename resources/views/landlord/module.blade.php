@extends('landlord.layout.main') @section('content')

@push('custom-css')
    <style>
        #icons {
            opacity: 0;
            visibility: hidden;
        }
        .icon_collapse {
            height: 50vh;
            margin-top: 15px;
            overflow-y: scroll;
        }
        .icon_collapse section {
            padding: 30px 0 0;
        }
        .icon_collapse .card {
            background: #e5e6e7;
            margin: 0 15px;
        }
        .page-header {
            border-bottom: 1px solid #555;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .fa-hover {
            text-align: center;
            margin-bottom: 15px
        }
        .fa-hover a {
            cursor: pointer;
            font-size: 0px;
        }
        .fa-hover i:hover {
            opacity: 0.8;
        }
        .fa-hover i {
            color: #7c5cc4;
            display: block;
            font-size: 20px;
        }
    </style>
@endpush

@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            {!! Form::open(['route' => 'module.store', 'files' => true, 'method' => 'post']) !!}
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Module Section')}}</h4>
                    </div>
                    <div class="card-body collapse show" id="gs_collapse">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <div id="custom-field">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{trans('file.language')}} *</label>
                                        <select name="language_id" class="form-control">
                                            @foreach($language_all as $language)
                                            <option value="{{$language->id}}">{{$language->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>{{trans('file.Heading')}} *</label>
                                        <input type="text" name="heading" class="form-control" value="@if($module_description){{$module_description->heading}}@endif" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{trans('file.Sub Heading')}} *</label>
                                        <input type="text" name="sub_heading" class="form-control" value="@if($module_description){{$module_description->sub_heading}}@endif" required />
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group">
                                        <label>{{trans('file.Module Image')}}</label>
                                        <input type="file" name="image" class="form-control" />
                                    </div>
                                    @if($errors->has('image'))
                                    <span>
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <h4>{{trans('file.Modules')}}</h4>
                                </div>
                                <!-- <div class="col-sm-3 mt-2">
                                    <input type="text" name="icon[]" class="form-control icon" value="" data-toggle="collapse" href="#icon_collapse" aria-expanded="false" aria-controls="icon_collapse" placeholder="{{trans('file.Click to choose icon')}}"/>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="name[]" class="form-control" placeholder="{{trans('file.name')}}"/>
                                </div>
                                <div class="col-sm-5">
                                    <textarea name="description[]" class="form-control" placeholder="{{trans('file.description')}}"></textarea>
                                </div> -->
                                <div class="collapse icon_collapse" id="icon_collapse">
                                    <div class="card">
                                        <div class="card-body">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="btn btn-info mar-bot-30" id="custom-btn" type="button">+ {{trans('file.Add Module')}}</button>
                                <button type="submit" class="btn btn-primary mar-bot-30">{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="module-table" class="table table-striped">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Icon')}}</th>
                    <th>{{trans('file.name')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody id="tablecontents">
                @if($modules)
                @foreach($modules as $key=>$module)
                <tr class="row1" data-id="{{$module->id}}">
                    <td>{{$key}}</td>
                    <td><i class="{{ $module->icon }}"></i> {{ $module->icon }}</td>
                    <td>{{ $module->name }}</td>
                    <td>
                        <button type="button" data-font="{{$module->icon}}" data-id="{{$module->id}}" data-name="{{$module->name}}" data-description="{{$module->description}}" class="edit-btn btn btn-link" data-toggle="modal" data-target="#editModal" ><i class="dripicons-document-edit"></i></button>
                        <form class="d-inline" method="post" action="{{ route('module.delete', $module->id) }}">
                        @csrf
                            <button type="submit" class="btn btn-link" onclick="return confirm('{{trans('file.Are you sure you want to delete?')}}')"><i class="dripicons-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- edit Modal -->
    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('module.update')}}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
            <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update Module')}}</h5>
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}</small></p>
                    <form>
                        <div class="form-group">
                            <label><strong>{{trans('file.Icon')}} *</strong></label>
                            <input type="text" name="icon" class="form-control icon" value="" data-toggle="collapse" href="#icon_collapse_edit" aria-expanded="false" aria-controls="icon_collapse_edit"/>
                        </div>
                        <div class="collapse icon_collapse" id="icon_collapse_edit">
                            <div class="card">
                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.name')}} *</strong></label>
                            <input type="text" class="form-control" name="name" required />
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.Description')}} *</strong></label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="module_id">
                            <input type="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div id="icons" class="container-fluid">
        <section id="web-application">
            <h2 class="page-header">Web Application Icons</h2>
            <div class="row fontawesome-icon-list">
                
                <div class="fa-hover col-sm-1"><a data-font-icon="address-book"><i class="fa fa-address-book" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-book</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="address-book-o"><i class="fa fa-address-book-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-book-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="address-card"><i class="fa fa-address-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-card</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="address-card-o"><i class="fa fa-address-card-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-card-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="adjust"><i class="fa fa-adjust" aria-hidden="true"></i> <span class="sr-only">Example of </span>adjust</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="american-sign-language-interpreting"><i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i> <span class="sr-only">Example of </span>american-sign-language-interpreting</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="anchor"><i class="fa fa-anchor" aria-hidden="true"></i> <span class="sr-only">Example of </span>anchor</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="archive"><i class="fa fa-archive" aria-hidden="true"></i> <span class="sr-only">Example of </span>archive</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="area-chart"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>area-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows"><i class="fa fa-arrows" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows-h"><i class="fa fa-arrows-h" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-h</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows-v"><i class="fa fa-arrows-v" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-v</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="american-sign-language-interpreting"><i class="fa fa-asl-interpreting" aria-hidden="true"></i> <span class="sr-only">Example of </span>asl-interpreting <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="assistive-listening-systems"><i class="fa fa-assistive-listening-systems" aria-hidden="true"></i> <span class="sr-only">Example of </span>assistive-listening-systems</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="asterisk"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="sr-only">Example of </span>asterisk</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="at"><i class="fa fa-at" aria-hidden="true"></i> <span class="sr-only">Example of </span>at</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="audio-description"><i class="fa fa-audio-description" aria-hidden="true"></i> <span class="sr-only">Example of </span>audio-description</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="car"><i class="fa fa-automobile" aria-hidden="true"></i> <span class="sr-only">Example of </span>automobile <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="balance-scale"><i class="fa fa-balance-scale" aria-hidden="true"></i> <span class="sr-only">Example of </span>balance-scale</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ban"><i class="fa fa-ban" aria-hidden="true"></i> <span class="sr-only">Example of </span>ban</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="university"><i class="fa fa-bank" aria-hidden="true"></i> <span class="sr-only">Example of </span>bank <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bar-chart"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>bar-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bar-chart"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bar-chart-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="barcode"><i class="fa fa-barcode" aria-hidden="true"></i> <span class="sr-only">Example of </span>barcode</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bars"><i class="fa fa-bars" aria-hidden="true"></i> <span class="sr-only">Example of </span>bars</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bath"><i class="fa fa-bath" aria-hidden="true"></i> <span class="sr-only">Example of </span>bath</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bath"><i class="fa fa-bathtub" aria-hidden="true"></i> <span class="sr-only">Example of </span>bathtub <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-full"><i class="fa fa-battery" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-empty"><i class="fa fa-battery-0" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-0 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-quarter"><i class="fa fa-battery-1" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-1 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-half"><i class="fa fa-battery-2" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-2 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-three-quarters"><i class="fa fa-battery-3" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-3 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-full"><i class="fa fa-battery-4" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-4 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-empty"><i class="fa fa-battery-empty" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-empty</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-full"><i class="fa fa-battery-full" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-full</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-half"><i class="fa fa-battery-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-half</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-quarter"><i class="fa fa-battery-quarter" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-quarter</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="battery-three-quarters"><i class="fa fa-battery-three-quarters" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-three-quarters</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bed"><i class="fa fa-bed" aria-hidden="true"></i> <span class="sr-only">Example of </span>bed</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="beer"><i class="fa fa-beer" aria-hidden="true"></i> <span class="sr-only">Example of </span>beer</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bell"><i class="fa fa-bell" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bell-o"><i class="fa fa-bell-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bell-slash"><i class="fa fa-bell-slash" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell-slash</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bell-slash-o"><i class="fa fa-bell-slash-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell-slash-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bicycle"><i class="fa fa-bicycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>bicycle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="binoculars"><i class="fa fa-binoculars" aria-hidden="true"></i> <span class="sr-only">Example of </span>binoculars</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="birthday-cake"><i class="fa fa-birthday-cake" aria-hidden="true"></i> <span class="sr-only">Example of </span>birthday-cake</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="blind"><i class="fa fa-blind" aria-hidden="true"></i> <span class="sr-only">Example of </span>blind</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bluetooth"><i class="fa fa-bluetooth" aria-hidden="true"></i> <span class="sr-only">Example of </span>bluetooth</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bluetooth-b"><i class="fa fa-bluetooth-b" aria-hidden="true"></i> <span class="sr-only">Example of </span>bluetooth-b</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bolt"><i class="fa fa-bolt" aria-hidden="true"></i> <span class="sr-only">Example of </span>bolt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bomb"><i class="fa fa-bomb" aria-hidden="true"></i> <span class="sr-only">Example of </span>bomb</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="book"><i class="fa fa-book" aria-hidden="true"></i> <span class="sr-only">Example of </span>book</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bookmark"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="sr-only">Example of </span>bookmark</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bookmark-o"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bookmark-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="braille"><i class="fa fa-braille" aria-hidden="true"></i> <span class="sr-only">Example of </span>braille</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="briefcase"><i class="fa fa-briefcase" aria-hidden="true"></i> <span class="sr-only">Example of </span>briefcase</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bug"><i class="fa fa-bug" aria-hidden="true"></i> <span class="sr-only">Example of </span>bug</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="building"><i class="fa fa-building" aria-hidden="true"></i> <span class="sr-only">Example of </span>building</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="building-o"><i class="fa fa-building-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>building-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bullhorn"><i class="fa fa-bullhorn" aria-hidden="true"></i> <span class="sr-only">Example of </span>bullhorn</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bullseye"><i class="fa fa-bullseye" aria-hidden="true"></i> <span class="sr-only">Example of </span>bullseye</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bus"><i class="fa fa-bus" aria-hidden="true"></i> <span class="sr-only">Example of </span>bus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="taxi"><i class="fa fa-cab" aria-hidden="true"></i> <span class="sr-only">Example of </span>cab <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calculator"><i class="fa fa-calculator" aria-hidden="true"></i> <span class="sr-only">Example of </span>calculator</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calendar"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calendar-check-o"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-check-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calendar-minus-o"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-minus-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calendar-o"><i class="fa fa-calendar-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calendar-plus-o"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-plus-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="calendar-times-o"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-times-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="camera"><i class="fa fa-camera" aria-hidden="true"></i> <span class="sr-only">Example of </span>camera</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="camera-retro"><i class="fa fa-camera-retro" aria-hidden="true"></i> <span class="sr-only">Example of </span>camera-retro</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="car"><i class="fa fa-car" aria-hidden="true"></i> <span class="sr-only">Example of </span>car</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-down"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-left"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-right"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-up"><i class="fa fa-caret-square-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cart-arrow-down"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>cart-arrow-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cart-plus"><i class="fa fa-cart-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>cart-plus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc"><i class="fa fa-cc" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="certificate"><i class="fa fa-certificate" aria-hidden="true"></i> <span class="sr-only">Example of </span>certificate</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="check"><i class="fa fa-check" aria-hidden="true"></i> <span class="sr-only">Example of </span>check</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="check-circle"><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="check-circle-o"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="check-square"><i class="fa fa-check-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="check-square-o"><i class="fa fa-check-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="child"><i class="fa fa-child" aria-hidden="true"></i> <span class="sr-only">Example of </span>child</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="circle"><i class="fa fa-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="circle-o"><i class="fa fa-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="circle-o-notch"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-o-notch</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="circle-thin"><i class="fa fa-circle-thin" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-thin</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="clock-o"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>clock-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="clone"><i class="fa fa-clone" aria-hidden="true"></i> <span class="sr-only">Example of </span>clone</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="times"><i class="fa fa-close" aria-hidden="true"></i> <span class="sr-only">Example of </span>close <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cloud"><i class="fa fa-cloud" aria-hidden="true"></i> <span class="sr-only">Example of </span>cloud</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cloud-download"><i class="fa fa-cloud-download" aria-hidden="true"></i> <span class="sr-only">Example of </span>cloud-download</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cloud-upload"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span class="sr-only">Example of </span>cloud-upload</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="code"><i class="fa fa-code" aria-hidden="true"></i> <span class="sr-only">Example of </span>code</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="code-fork"><i class="fa fa-code-fork" aria-hidden="true"></i> <span class="sr-only">Example of </span>code-fork</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="coffee"><i class="fa fa-coffee" aria-hidden="true"></i> <span class="sr-only">Example of </span>coffee</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cog"><i class="fa fa-cog" aria-hidden="true"></i> <span class="sr-only">Example of </span>cog</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cogs"><i class="fa fa-cogs" aria-hidden="true"></i> <span class="sr-only">Example of </span>cogs</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="comment"><i class="fa fa-comment" aria-hidden="true"></i> <span class="sr-only">Example of </span>comment</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="comment-o"><i class="fa fa-comment-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>comment-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="commenting"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="sr-only">Example of </span>commenting</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="commenting-o"><i class="fa fa-commenting-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>commenting-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="comments"><i class="fa fa-comments" aria-hidden="true"></i> <span class="sr-only">Example of </span>comments</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="comments-o"><i class="fa fa-comments-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>comments-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="compass"><i class="fa fa-compass" aria-hidden="true"></i> <span class="sr-only">Example of </span>compass</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="copyright"><i class="fa fa-copyright" aria-hidden="true"></i> <span class="sr-only">Example of </span>copyright</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="creative-commons"><i class="fa fa-creative-commons" aria-hidden="true"></i> <span class="sr-only">Example of </span>creative-commons</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="credit-card"><i class="fa fa-credit-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>credit-card</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="credit-card-alt"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>credit-card-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="crop"><i class="fa fa-crop" aria-hidden="true"></i> <span class="sr-only">Example of </span>crop</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="crosshairs"><i class="fa fa-crosshairs" aria-hidden="true"></i> <span class="sr-only">Example of </span>crosshairs</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cube"><i class="fa fa-cube" aria-hidden="true"></i> <span class="sr-only">Example of </span>cube</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cubes"><i class="fa fa-cubes" aria-hidden="true"></i> <span class="sr-only">Example of </span>cubes</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cutlery"><i class="fa fa-cutlery" aria-hidden="true"></i> <span class="sr-only">Example of </span>cutlery</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tachometer"><i class="fa fa-dashboard" aria-hidden="true"></i> <span class="sr-only">Example of </span>dashboard <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="database"><i class="fa fa-database" aria-hidden="true"></i> <span class="sr-only">Example of </span>database</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deaf"><i class="fa fa-deaf" aria-hidden="true"></i> <span class="sr-only">Example of </span>deaf</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deaf"><i class="fa fa-deafness" aria-hidden="true"></i> <span class="sr-only">Example of </span>deafness <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="desktop"><i class="fa fa-desktop" aria-hidden="true"></i> <span class="sr-only">Example of </span>desktop</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="diamond"><i class="fa fa-diamond" aria-hidden="true"></i> <span class="sr-only">Example of </span>diamond</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="dot-circle-o"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>dot-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="download"><i class="fa fa-download" aria-hidden="true"></i> <span class="sr-only">Example of </span>download</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="id-card"><i class="fa fa-drivers-license" aria-hidden="true"></i> <span class="sr-only">Example of </span>drivers-license <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="id-card-o"><i class="fa fa-drivers-license-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>drivers-license-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pencil-square-o"><i class="fa fa-edit" aria-hidden="true"></i> <span class="sr-only">Example of </span>edit <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ellipsis-h"><i class="fa fa-ellipsis-h" aria-hidden="true"></i> <span class="sr-only">Example of </span>ellipsis-h</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ellipsis-v"><i class="fa fa-ellipsis-v" aria-hidden="true"></i> <span class="sr-only">Example of </span>ellipsis-v</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="envelope"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="envelope-o"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="envelope-open"><i class="fa fa-envelope-open" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-open</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="envelope-open-o"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-open-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="envelope-square"><i class="fa fa-envelope-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eraser"><i class="fa fa-eraser" aria-hidden="true"></i> <span class="sr-only">Example of </span>eraser</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="exchange"><i class="fa fa-exchange" aria-hidden="true"></i> <span class="sr-only">Example of </span>exchange</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="exclamation"><i class="fa fa-exclamation" aria-hidden="true"></i> <span class="sr-only">Example of </span>exclamation</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="exclamation-circle"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>exclamation-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="exclamation-triangle"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="sr-only">Example of </span>exclamation-triangle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="external-link"><i class="fa fa-external-link" aria-hidden="true"></i> <span class="sr-only">Example of </span>external-link</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="external-link-square"><i class="fa fa-external-link-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>external-link-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eye"><i class="fa fa-eye" aria-hidden="true"></i> <span class="sr-only">Example of </span>eye</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eye-slash"><i class="fa fa-eye-slash" aria-hidden="true"></i> <span class="sr-only">Example of </span>eye-slash</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eyedropper"><i class="fa fa-eyedropper" aria-hidden="true"></i> <span class="sr-only">Example of </span>eyedropper</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fax"><i class="fa fa-fax" aria-hidden="true"></i> <span class="sr-only">Example of </span>fax</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rss"><i class="fa fa-feed" aria-hidden="true"></i> <span class="sr-only">Example of </span>feed <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="female"><i class="fa fa-female" aria-hidden="true"></i> <span class="sr-only">Example of </span>female</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fighter-jet"><i class="fa fa-fighter-jet" aria-hidden="true"></i> <span class="sr-only">Example of </span>fighter-jet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-archive-o"><i class="fa fa-file-archive-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-archive-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-audio-o"><i class="fa fa-file-audio-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-audio-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-code-o"><i class="fa fa-file-code-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-code-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-excel-o"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-excel-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-image-o"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-image-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-video-o"><i class="fa fa-file-movie-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-movie-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-pdf-o"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-pdf-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-image-o"><i class="fa fa-file-photo-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-photo-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-image-o"><i class="fa fa-file-picture-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-picture-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-powerpoint-o"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-powerpoint-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-audio-o"><i class="fa fa-file-sound-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-sound-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-video-o"><i class="fa fa-file-video-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-video-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-word-o"><i class="fa fa-file-word-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-word-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-archive-o"><i class="fa fa-file-zip-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-zip-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="film"><i class="fa fa-film" aria-hidden="true"></i> <span class="sr-only">Example of </span>film</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="filter"><i class="fa fa-filter" aria-hidden="true"></i> <span class="sr-only">Example of </span>filter</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fire"><i class="fa fa-fire" aria-hidden="true"></i> <span class="sr-only">Example of </span>fire</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fire-extinguisher"><i class="fa fa-fire-extinguisher" aria-hidden="true"></i> <span class="sr-only">Example of </span>fire-extinguisher</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="flag"><i class="fa fa-flag" aria-hidden="true"></i> <span class="sr-only">Example of </span>flag</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="flag-checkered"><i class="fa fa-flag-checkered" aria-hidden="true"></i> <span class="sr-only">Example of </span>flag-checkered</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="flag-o"><i class="fa fa-flag-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>flag-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bolt"><i class="fa fa-flash" aria-hidden="true"></i> <span class="sr-only">Example of </span>flash <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="flask"><i class="fa fa-flask" aria-hidden="true"></i> <span class="sr-only">Example of </span>flask</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="folder"><i class="fa fa-folder" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="folder-o"><i class="fa fa-folder-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="folder-open"><i class="fa fa-folder-open" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder-open</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="folder-open-o"><i class="fa fa-folder-open-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder-open-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="frown-o"><i class="fa fa-frown-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>frown-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="futbol-o"><i class="fa fa-futbol-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>futbol-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gamepad"><i class="fa fa-gamepad" aria-hidden="true"></i> <span class="sr-only">Example of </span>gamepad</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gavel"><i class="fa fa-gavel" aria-hidden="true"></i> <span class="sr-only">Example of </span>gavel</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cog"><i class="fa fa-gear" aria-hidden="true"></i> <span class="sr-only">Example of </span>gear <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cogs"><i class="fa fa-gears" aria-hidden="true"></i> <span class="sr-only">Example of </span>gears <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gift"><i class="fa fa-gift" aria-hidden="true"></i> <span class="sr-only">Example of </span>gift</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="glass"><i class="fa fa-glass" aria-hidden="true"></i> <span class="sr-only">Example of </span>glass</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="globe"><i class="fa fa-globe" aria-hidden="true"></i> <span class="sr-only">Example of </span>globe</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="graduation-cap"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="sr-only">Example of </span>graduation-cap</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="users"><i class="fa fa-group" aria-hidden="true"></i> <span class="sr-only">Example of </span>group <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-rock-o"><i class="fa fa-hand-grab-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-grab-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-lizard-o"><i class="fa fa-hand-lizard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-lizard-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-paper-o"><i class="fa fa-hand-paper-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-paper-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-peace-o"><i class="fa fa-hand-peace-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-peace-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-pointer-o"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-pointer-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-rock-o"><i class="fa fa-hand-rock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-rock-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-scissors-o"><i class="fa fa-hand-scissors-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-scissors-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-spock-o"><i class="fa fa-hand-spock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-spock-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-paper-o"><i class="fa fa-hand-stop-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-stop-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="handshake-o"><i class="fa fa-handshake-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>handshake-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deaf"><i class="fa fa-hard-of-hearing" aria-hidden="true"></i> <span class="sr-only">Example of </span>hard-of-hearing <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hashtag"><i class="fa fa-hashtag" aria-hidden="true"></i> <span class="sr-only">Example of </span>hashtag</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hdd-o"><i class="fa fa-hdd-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hdd-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="headphones"><i class="fa fa-headphones" aria-hidden="true"></i> <span class="sr-only">Example of </span>headphones</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="heart"><i class="fa fa-heart" aria-hidden="true"></i> <span class="sr-only">Example of </span>heart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="heart-o"><i class="fa fa-heart-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>heart-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="heartbeat"><i class="fa fa-heartbeat" aria-hidden="true"></i> <span class="sr-only">Example of </span>heartbeat</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="history"><i class="fa fa-history" aria-hidden="true"></i> <span class="sr-only">Example of </span>history</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="home"><i class="fa fa-home" aria-hidden="true"></i> <span class="sr-only">Example of </span>home</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bed"><i class="fa fa-hotel" aria-hidden="true"></i> <span class="sr-only">Example of </span>hotel <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass"><i class="fa fa-hourglass" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-start"><i class="fa fa-hourglass-1" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-1 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-half"><i class="fa fa-hourglass-2" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-2 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-end"><i class="fa fa-hourglass-3" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-3 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-end"><i class="fa fa-hourglass-end" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-end</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-half"><i class="fa fa-hourglass-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-half</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-o"><i class="fa fa-hourglass-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hourglass-start"><i class="fa fa-hourglass-start" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-start</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="i-cursor"><i class="fa fa-i-cursor" aria-hidden="true"></i> <span class="sr-only">Example of </span>i-cursor</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="id-badge"><i class="fa fa-id-badge" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-badge</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="id-card"><i class="fa fa-id-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-card</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="id-card-o"><i class="fa fa-id-card-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-card-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="picture-o"><i class="fa fa-image" aria-hidden="true"></i> <span class="sr-only">Example of </span>image <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="inbox"><i class="fa fa-inbox" aria-hidden="true"></i> <span class="sr-only">Example of </span>inbox</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="industry"><i class="fa fa-industry" aria-hidden="true"></i> <span class="sr-only">Example of </span>industry</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="info"><i class="fa fa-info" aria-hidden="true"></i> <span class="sr-only">Example of </span>info</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="info-circle"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>info-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="university"><i class="fa fa-institution" aria-hidden="true"></i> <span class="sr-only">Example of </span>institution <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="key"><i class="fa fa-key" aria-hidden="true"></i> <span class="sr-only">Example of </span>key</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="keyboard-o"><i class="fa fa-keyboard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>keyboard-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="language"><i class="fa fa-language" aria-hidden="true"></i> <span class="sr-only">Example of </span>language</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="laptop"><i class="fa fa-laptop" aria-hidden="true"></i> <span class="sr-only">Example of </span>laptop</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="leaf"><i class="fa fa-leaf" aria-hidden="true"></i> <span class="sr-only">Example of </span>leaf</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gavel"><i class="fa fa-legal" aria-hidden="true"></i> <span class="sr-only">Example of </span>legal <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="lemon-o"><i class="fa fa-lemon-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>lemon-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="level-down"><i class="fa fa-level-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>level-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="level-up"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>level-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="life-ring"><i class="fa fa-life-bouy" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-bouy <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="life-ring"><i class="fa fa-life-buoy" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-buoy <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="life-ring"><i class="fa fa-life-ring" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-ring</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="life-ring"><i class="fa fa-life-saver" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-saver <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="lightbulb-o"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>lightbulb-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="line-chart"><i class="fa fa-line-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>line-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="location-arrow"><i class="fa fa-location-arrow" aria-hidden="true"></i> <span class="sr-only">Example of </span>location-arrow</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="lock"><i class="fa fa-lock" aria-hidden="true"></i> <span class="sr-only">Example of </span>lock</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="low-vision"><i class="fa fa-low-vision" aria-hidden="true"></i> <span class="sr-only">Example of </span>low-vision</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="magic"><i class="fa fa-magic" aria-hidden="true"></i> <span class="sr-only">Example of </span>magic</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="magnet"><i class="fa fa-magnet" aria-hidden="true"></i> <span class="sr-only">Example of </span>magnet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share"><i class="fa fa-mail-forward" aria-hidden="true"></i> <span class="sr-only">Example of </span>mail-forward <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reply"><i class="fa fa-mail-reply" aria-hidden="true"></i> <span class="sr-only">Example of </span>mail-reply <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reply-all"><i class="fa fa-mail-reply-all" aria-hidden="true"></i> <span class="sr-only">Example of </span>mail-reply-all <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="male"><i class="fa fa-male" aria-hidden="true"></i> <span class="sr-only">Example of </span>male</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="map"><i class="fa fa-map" aria-hidden="true"></i> <span class="sr-only">Example of </span>map</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="map-marker"><i class="fa fa-map-marker" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-marker</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="map-o"><i class="fa fa-map-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="map-pin"><i class="fa fa-map-pin" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-pin</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="map-signs"><i class="fa fa-map-signs" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-signs</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="meh-o"><i class="fa fa-meh-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>meh-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="microchip"><i class="fa fa-microchip" aria-hidden="true"></i> <span class="sr-only">Example of </span>microchip</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="microphone"><i class="fa fa-microphone" aria-hidden="true"></i> <span class="sr-only">Example of </span>microphone</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="microphone-slash"><i class="fa fa-microphone-slash" aria-hidden="true"></i> <span class="sr-only">Example of </span>microphone-slash</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="minus"><i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="minus-circle"><i class="fa fa-minus-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="minus-square"><i class="fa fa-minus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="minus-square-o"><i class="fa fa-minus-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mobile"><i class="fa fa-mobile" aria-hidden="true"></i> <span class="sr-only">Example of </span>mobile</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mobile"><i class="fa fa-mobile-phone" aria-hidden="true"></i> <span class="sr-only">Example of </span>mobile-phone <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="money"><i class="fa fa-money" aria-hidden="true"></i> <span class="sr-only">Example of </span>money</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="moon-o"><i class="fa fa-moon-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>moon-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="graduation-cap"><i class="fa fa-mortar-board" aria-hidden="true"></i> <span class="sr-only">Example of </span>mortar-board <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="motorcycle"><i class="fa fa-motorcycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>motorcycle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mouse-pointer"><i class="fa fa-mouse-pointer" aria-hidden="true"></i> <span class="sr-only">Example of </span>mouse-pointer</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="music"><i class="fa fa-music" aria-hidden="true"></i> <span class="sr-only">Example of </span>music</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bars"><i class="fa fa-navicon" aria-hidden="true"></i> <span class="sr-only">Example of </span>navicon <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="newspaper-o"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>newspaper-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="object-group"><i class="fa fa-object-group" aria-hidden="true"></i> <span class="sr-only">Example of </span>object-group</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="object-ungroup"><i class="fa fa-object-ungroup" aria-hidden="true"></i> <span class="sr-only">Example of </span>object-ungroup</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paint-brush"><i class="fa fa-paint-brush" aria-hidden="true"></i> <span class="sr-only">Example of </span>paint-brush</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paper-plane"><i class="fa fa-paper-plane" aria-hidden="true"></i> <span class="sr-only">Example of </span>paper-plane</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paper-plane-o"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>paper-plane-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paw"><i class="fa fa-paw" aria-hidden="true"></i> <span class="sr-only">Example of </span>paw</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pencil"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="sr-only">Example of </span>pencil</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pencil-square"><i class="fa fa-pencil-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>pencil-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pencil-square-o"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>pencil-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="percent"><i class="fa fa-percent" aria-hidden="true"></i> <span class="sr-only">Example of </span>percent</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="phone"><i class="fa fa-phone" aria-hidden="true"></i> <span class="sr-only">Example of </span>phone</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="phone-square"><i class="fa fa-phone-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>phone-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="picture-o"><i class="fa fa-photo" aria-hidden="true"></i> <span class="sr-only">Example of </span>photo <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="picture-o"><i class="fa fa-picture-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>picture-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pie-chart"><i class="fa fa-pie-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>pie-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plane"><i class="fa fa-plane" aria-hidden="true"></i> <span class="sr-only">Example of </span>plane</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plug"><i class="fa fa-plug" aria-hidden="true"></i> <span class="sr-only">Example of </span>plug</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus"><i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus-circle"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus-square"><i class="fa fa-plus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus-square-o"><i class="fa fa-plus-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="podcast"><i class="fa fa-podcast" aria-hidden="true"></i> <span class="sr-only">Example of </span>podcast</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="power-off"><i class="fa fa-power-off" aria-hidden="true"></i> <span class="sr-only">Example of </span>power-off</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="print"><i class="fa fa-print" aria-hidden="true"></i> <span class="sr-only">Example of </span>print</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="puzzle-piece"><i class="fa fa-puzzle-piece" aria-hidden="true"></i> <span class="sr-only">Example of </span>puzzle-piece</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="qrcode"><i class="fa fa-qrcode" aria-hidden="true"></i> <span class="sr-only">Example of </span>qrcode</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="question"><i class="fa fa-question" aria-hidden="true"></i> <span class="sr-only">Example of </span>question</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="question-circle"><i class="fa fa-question-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>question-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="question-circle-o"><i class="fa fa-question-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>question-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="quote-left"><i class="fa fa-quote-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>quote-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="quote-right"><i class="fa fa-quote-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>quote-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="random"><i class="fa fa-random" aria-hidden="true"></i> <span class="sr-only">Example of </span>random</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="recycle"><i class="fa fa-recycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>recycle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="refresh"><i class="fa fa-refresh" aria-hidden="true"></i> <span class="sr-only">Example of </span>refresh</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="registered"><i class="fa fa-registered" aria-hidden="true"></i> <span class="sr-only">Example of </span>registered</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="times"><i class="fa fa-remove" aria-hidden="true"></i> <span class="sr-only">Example of </span>remove <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bars"><i class="fa fa-reorder" aria-hidden="true"></i> <span class="sr-only">Example of </span>reorder <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reply"><i class="fa fa-reply" aria-hidden="true"></i> <span class="sr-only">Example of </span>reply</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reply-all"><i class="fa fa-reply-all" aria-hidden="true"></i> <span class="sr-only">Example of </span>reply-all</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="retweet"><i class="fa fa-retweet" aria-hidden="true"></i> <span class="sr-only">Example of </span>retweet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="road"><i class="fa fa-road" aria-hidden="true"></i> <span class="sr-only">Example of </span>road</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rocket"><i class="fa fa-rocket" aria-hidden="true"></i> <span class="sr-only">Example of </span>rocket</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rss"><i class="fa fa-rss" aria-hidden="true"></i> <span class="sr-only">Example of </span>rss</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rss-square"><i class="fa fa-rss-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>rss-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bath"><i class="fa fa-s15" aria-hidden="true"></i> <span class="sr-only">Example of </span>s15 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="search"><i class="fa fa-search" aria-hidden="true"></i> <span class="sr-only">Example of </span>search</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="search-minus"><i class="fa fa-search-minus" aria-hidden="true"></i> <span class="sr-only">Example of </span>search-minus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="search-plus"><i class="fa fa-search-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>search-plus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paper-plane"><i class="fa fa-send" aria-hidden="true"></i> <span class="sr-only">Example of </span>send <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paper-plane-o"><i class="fa fa-send-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>send-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="server"><i class="fa fa-server" aria-hidden="true"></i> <span class="sr-only">Example of </span>server</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share"><i class="fa fa-share" aria-hidden="true"></i> <span class="sr-only">Example of </span>share</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share-alt"><i class="fa fa-share-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>share-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share-alt-square"><i class="fa fa-share-alt-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>share-alt-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share-square"><i class="fa fa-share-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>share-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share-square-o"><i class="fa fa-share-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>share-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="shield"><i class="fa fa-shield" aria-hidden="true"></i> <span class="sr-only">Example of </span>shield</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ship"><i class="fa fa-ship" aria-hidden="true"></i> <span class="sr-only">Example of </span>ship</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="shopping-bag"><i class="fa fa-shopping-bag" aria-hidden="true"></i> <span class="sr-only">Example of </span>shopping-bag</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="shopping-basket"><i class="fa fa-shopping-basket" aria-hidden="true"></i> <span class="sr-only">Example of </span>shopping-basket</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="shopping-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="sr-only">Example of </span>shopping-cart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="shower"><i class="fa fa-shower" aria-hidden="true"></i> <span class="sr-only">Example of </span>shower</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sign-in"><i class="fa fa-sign-in" aria-hidden="true"></i> <span class="sr-only">Example of </span>sign-in</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sign-language"><i class="fa fa-sign-language" aria-hidden="true"></i> <span class="sr-only">Example of </span>sign-language</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sign-out"><i class="fa fa-sign-out" aria-hidden="true"></i> <span class="sr-only">Example of </span>sign-out</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="signal"><i class="fa fa-signal" aria-hidden="true"></i> <span class="sr-only">Example of </span>signal</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sign-language"><i class="fa fa-signing" aria-hidden="true"></i> <span class="sr-only">Example of </span>signing <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sitemap"><i class="fa fa-sitemap" aria-hidden="true"></i> <span class="sr-only">Example of </span>sitemap</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sliders"><i class="fa fa-sliders" aria-hidden="true"></i> <span class="sr-only">Example of </span>sliders</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="smile-o"><i class="fa fa-smile-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>smile-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="snowflake-o"><i class="fa fa-snowflake-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>snowflake-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="futbol-o"><i class="fa fa-soccer-ball-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>soccer-ball-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort"><i class="fa fa-sort" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-alpha-asc"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-alpha-asc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-alpha-desc"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-alpha-desc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-amount-asc"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-amount-asc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-amount-desc"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-amount-desc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-asc"><i class="fa fa-sort-asc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-asc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-desc"><i class="fa fa-sort-desc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-desc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-desc"><i class="fa fa-sort-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-down <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-numeric-asc"><i class="fa fa-sort-numeric-asc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-numeric-asc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-numeric-desc"><i class="fa fa-sort-numeric-desc" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-numeric-desc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort-asc"><i class="fa fa-sort-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>sort-up <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="space-shuttle"><i class="fa fa-space-shuttle" aria-hidden="true"></i> <span class="sr-only">Example of </span>space-shuttle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="spinner"><i class="fa fa-spinner" aria-hidden="true"></i> <span class="sr-only">Example of </span>spinner</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="spoon"><i class="fa fa-spoon" aria-hidden="true"></i> <span class="sr-only">Example of </span>spoon</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="square"><i class="fa fa-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="square-o"><i class="fa fa-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="star"><i class="fa fa-star" aria-hidden="true"></i> <span class="sr-only">Example of </span>star</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="star-half"><i class="fa fa-star-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>star-half</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="star-half-o"><i class="fa fa-star-half-empty" aria-hidden="true"></i> <span class="sr-only">Example of </span>star-half-empty <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="star-half-o"><i class="fa fa-star-half-full" aria-hidden="true"></i> <span class="sr-only">Example of </span>star-half-full <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="star-half-o"><i class="fa fa-star-half-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>star-half-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="star-o"><i class="fa fa-star-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>star-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sticky-note"><i class="fa fa-sticky-note" aria-hidden="true"></i> <span class="sr-only">Example of </span>sticky-note</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sticky-note-o"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>sticky-note-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="street-view"><i class="fa fa-street-view" aria-hidden="true"></i> <span class="sr-only">Example of </span>street-view</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="suitcase"><i class="fa fa-suitcase" aria-hidden="true"></i> <span class="sr-only">Example of </span>suitcase</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sun-o"><i class="fa fa-sun-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>sun-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="life-ring"><i class="fa fa-support" aria-hidden="true"></i> <span class="sr-only">Example of </span>support <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tablet"><i class="fa fa-tablet" aria-hidden="true"></i> <span class="sr-only">Example of </span>tablet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tachometer"><i class="fa fa-tachometer" aria-hidden="true"></i> <span class="sr-only">Example of </span>tachometer</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tag"><i class="fa fa-tag" aria-hidden="true"></i> <span class="sr-only">Example of </span>tag</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tags"><i class="fa fa-tags" aria-hidden="true"></i> <span class="sr-only">Example of </span>tags</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tasks"><i class="fa fa-tasks" aria-hidden="true"></i> <span class="sr-only">Example of </span>tasks</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="taxi"><i class="fa fa-taxi" aria-hidden="true"></i> <span class="sr-only">Example of </span>taxi</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="television"><i class="fa fa-television" aria-hidden="true"></i> <span class="sr-only">Example of </span>television</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="terminal"><i class="fa fa-terminal" aria-hidden="true"></i> <span class="sr-only">Example of </span>terminal</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-full"><i class="fa fa-thermometer" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-empty"><i class="fa fa-thermometer-0" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-0 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-quarter"><i class="fa fa-thermometer-1" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-1 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-half"><i class="fa fa-thermometer-2" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-2 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-three-quarters"><i class="fa fa-thermometer-3" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-3 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-full"><i class="fa fa-thermometer-4" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-4 <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-empty"><i class="fa fa-thermometer-empty" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-empty</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-full"><i class="fa fa-thermometer-full" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-full</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-half"><i class="fa fa-thermometer-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-half</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-quarter"><i class="fa fa-thermometer-quarter" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-quarter</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thermometer-three-quarters"><i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-three-quarters</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumb-tack"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumb-tack</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-down"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-o-down"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-o-up"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-up"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ticket"><i class="fa fa-ticket" aria-hidden="true"></i> <span class="sr-only">Example of </span>ticket</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="times"><i class="fa fa-times" aria-hidden="true"></i> <span class="sr-only">Example of </span>times</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="times-circle"><i class="fa fa-times-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>times-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="times-circle-o"><i class="fa fa-times-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>times-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-close"><i class="fa fa-times-rectangle" aria-hidden="true"></i> <span class="sr-only">Example of </span>times-rectangle <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-close-o"><i class="fa fa-times-rectangle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>times-rectangle-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tint"><i class="fa fa-tint" aria-hidden="true"></i> <span class="sr-only">Example of </span>tint</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-down"><i class="fa fa-toggle-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-down <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-left"><i class="fa fa-toggle-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-left <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="toggle-off"><i class="fa fa-toggle-off" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-off</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="toggle-on"><i class="fa fa-toggle-on" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-on</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-right"><i class="fa fa-toggle-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-right <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-up"><i class="fa fa-toggle-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-up <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="trademark"><i class="fa fa-trademark" aria-hidden="true"></i> <span class="sr-only">Example of </span>trademark</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="trash"><i class="fa fa-trash" aria-hidden="true"></i> <span class="sr-only">Example of </span>trash</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="trash-o"><i class="fa fa-trash-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>trash-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tree"><i class="fa fa-tree" aria-hidden="true"></i> <span class="sr-only">Example of </span>tree</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="trophy"><i class="fa fa-trophy" aria-hidden="true"></i> <span class="sr-only">Example of </span>trophy</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="truck"><i class="fa fa-truck" aria-hidden="true"></i> <span class="sr-only">Example of </span>truck</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tty"><i class="fa fa-tty" aria-hidden="true"></i> <span class="sr-only">Example of </span>tty</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="television"><i class="fa fa-tv" aria-hidden="true"></i> <span class="sr-only">Example of </span>tv <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="umbrella"><i class="fa fa-umbrella" aria-hidden="true"></i> <span class="sr-only">Example of </span>umbrella</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="universal-access"><i class="fa fa-universal-access" aria-hidden="true"></i> <span class="sr-only">Example of </span>universal-access</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="university"><i class="fa fa-university" aria-hidden="true"></i> <span class="sr-only">Example of </span>university</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="unlock"><i class="fa fa-unlock" aria-hidden="true"></i> <span class="sr-only">Example of </span>unlock</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="unlock-alt"><i class="fa fa-unlock-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>unlock-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sort"><i class="fa fa-unsorted" aria-hidden="true"></i> <span class="sr-only">Example of </span>unsorted <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="upload"><i class="fa fa-upload" aria-hidden="true"></i> <span class="sr-only">Example of </span>upload</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user"><i class="fa fa-user" aria-hidden="true"></i> <span class="sr-only">Example of </span>user</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-circle"><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-circle-o"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-o"><i class="fa fa-user-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-plus"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-plus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-secret"><i class="fa fa-user-secret" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-secret</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-times"><i class="fa fa-user-times" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-times</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="users"><i class="fa fa-users" aria-hidden="true"></i> <span class="sr-only">Example of </span>users</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="address-card"><i class="fa fa-vcard" aria-hidden="true"></i> <span class="sr-only">Example of </span>vcard <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="address-card-o"><i class="fa fa-vcard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>vcard-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="video-camera"><i class="fa fa-video-camera" aria-hidden="true"></i> <span class="sr-only">Example of </span>video-camera</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="volume-control-phone"><i class="fa fa-volume-control-phone" aria-hidden="true"></i> <span class="sr-only">Example of </span>volume-control-phone</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="volume-down"><i class="fa fa-volume-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>volume-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="volume-off"><i class="fa fa-volume-off" aria-hidden="true"></i> <span class="sr-only">Example of </span>volume-off</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="volume-up"><i class="fa fa-volume-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>volume-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="exclamation-triangle"><i class="fa fa-warning" aria-hidden="true"></i> <span class="sr-only">Example of </span>warning <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair"><i class="fa fa-wheelchair" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair-alt"><i class="fa fa-wheelchair-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wifi"><i class="fa fa-wifi" aria-hidden="true"></i> <span class="sr-only">Example of </span>wifi</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-close"><i class="fa fa-window-close" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-close</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-close-o"><i class="fa fa-window-close-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-close-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-maximize"><i class="fa fa-window-maximize" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-maximize</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-minimize"><i class="fa fa-window-minimize" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-minimize</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="window-restore"><i class="fa fa-window-restore" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-restore</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wrench"><i class="fa fa-wrench" aria-hidden="true"></i> <span class="sr-only">Example of </span>wrench</a></div>
                
            </div>
        </section>
        <section id="accessibility">
            <h2 class="page-header">Accessibility Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="american-sign-language-interpreting"><i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i> <span class="sr-only">Example of </span>american-sign-language-interpreting</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="american-sign-language-interpreting"><i class="fa fa-asl-interpreting" aria-hidden="true"></i> <span class="sr-only">Example of </span>asl-interpreting <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="assistive-listening-systems"><i class="fa fa-assistive-listening-systems" aria-hidden="true"></i> <span class="sr-only">Example of </span>assistive-listening-systems</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="audio-description"><i class="fa fa-audio-description" aria-hidden="true"></i> <span class="sr-only">Example of </span>audio-description</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="blind"><i class="fa fa-blind" aria-hidden="true"></i> <span class="sr-only">Example of </span>blind</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="braille"><i class="fa fa-braille" aria-hidden="true"></i> <span class="sr-only">Example of </span>braille</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc"><i class="fa fa-cc" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deaf"><i class="fa fa-deaf" aria-hidden="true"></i> <span class="sr-only">Example of </span>deaf</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deaf"><i class="fa fa-deafness" aria-hidden="true"></i> <span class="sr-only">Example of </span>deafness <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deaf"><i class="fa fa-hard-of-hearing" aria-hidden="true"></i> <span class="sr-only">Example of </span>hard-of-hearing <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="low-vision"><i class="fa fa-low-vision" aria-hidden="true"></i> <span class="sr-only">Example of </span>low-vision</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="question-circle-o"><i class="fa fa-question-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>question-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sign-language"><i class="fa fa-sign-language" aria-hidden="true"></i> <span class="sr-only">Example of </span>sign-language</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sign-language"><i class="fa fa-signing" aria-hidden="true"></i> <span class="sr-only">Example of </span>signing <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tty"><i class="fa fa-tty" aria-hidden="true"></i> <span class="sr-only">Example of </span>tty</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="universal-access"><i class="fa fa-universal-access" aria-hidden="true"></i> <span class="sr-only">Example of </span>universal-access</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="volume-control-phone"><i class="fa fa-volume-control-phone" aria-hidden="true"></i> <span class="sr-only">Example of </span>volume-control-phone</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair"><i class="fa fa-wheelchair" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair-alt"><i class="fa fa-wheelchair-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair-alt</a></div>
                
            </div>
        </section>
        <section id="hand">
            <h2 class="page-header">Hand Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-rock-o"><i class="fa fa-hand-grab-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-grab-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-lizard-o"><i class="fa fa-hand-lizard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-lizard-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-down"><i class="fa fa-hand-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-left"><i class="fa fa-hand-o-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-right"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-up"><i class="fa fa-hand-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-paper-o"><i class="fa fa-hand-paper-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-paper-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-peace-o"><i class="fa fa-hand-peace-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-peace-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-pointer-o"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-pointer-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-rock-o"><i class="fa fa-hand-rock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-rock-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-scissors-o"><i class="fa fa-hand-scissors-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-scissors-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-spock-o"><i class="fa fa-hand-spock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-spock-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-paper-o"><i class="fa fa-hand-stop-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-stop-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-down"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-o-down"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-o-up"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="thumbs-up"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>thumbs-up</a></div>
                
            </div>
        </section>
        <section id="transportation">
            <h2 class="page-header">Transportation Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="ambulance"><i class="fa fa-ambulance" aria-hidden="true"></i> <span class="sr-only">Example of </span>ambulance</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="car"><i class="fa fa-automobile" aria-hidden="true"></i> <span class="sr-only">Example of </span>automobile <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bicycle"><i class="fa fa-bicycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>bicycle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bus"><i class="fa fa-bus" aria-hidden="true"></i> <span class="sr-only">Example of </span>bus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="taxi"><i class="fa fa-cab" aria-hidden="true"></i> <span class="sr-only">Example of </span>cab <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="car"><i class="fa fa-car" aria-hidden="true"></i> <span class="sr-only">Example of </span>car</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fighter-jet"><i class="fa fa-fighter-jet" aria-hidden="true"></i> <span class="sr-only">Example of </span>fighter-jet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="motorcycle"><i class="fa fa-motorcycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>motorcycle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plane"><i class="fa fa-plane" aria-hidden="true"></i> <span class="sr-only">Example of </span>plane</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rocket"><i class="fa fa-rocket" aria-hidden="true"></i> <span class="sr-only">Example of </span>rocket</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ship"><i class="fa fa-ship" aria-hidden="true"></i> <span class="sr-only">Example of </span>ship</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="space-shuttle"><i class="fa fa-space-shuttle" aria-hidden="true"></i> <span class="sr-only">Example of </span>space-shuttle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="subway"><i class="fa fa-subway" aria-hidden="true"></i> <span class="sr-only">Example of </span>subway</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="taxi"><i class="fa fa-taxi" aria-hidden="true"></i> <span class="sr-only">Example of </span>taxi</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="train"><i class="fa fa-train" aria-hidden="true"></i> <span class="sr-only">Example of </span>train</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="truck"><i class="fa fa-truck" aria-hidden="true"></i> <span class="sr-only">Example of </span>truck</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair"><i class="fa fa-wheelchair" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair-alt"><i class="fa fa-wheelchair-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair-alt</a></div>
                
            </div>
        </section>
        <section id="gender">
            <h2 class="page-header">Gender Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="genderless"><i class="fa fa-genderless" aria-hidden="true"></i> <span class="sr-only">Example of </span>genderless</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="transgender"><i class="fa fa-intersex" aria-hidden="true"></i> <span class="sr-only">Example of </span>intersex <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mars"><i class="fa fa-mars" aria-hidden="true"></i> <span class="sr-only">Example of </span>mars</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mars-double"><i class="fa fa-mars-double" aria-hidden="true"></i> <span class="sr-only">Example of </span>mars-double</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mars-stroke"><i class="fa fa-mars-stroke" aria-hidden="true"></i> <span class="sr-only">Example of </span>mars-stroke</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mars-stroke-h"><i class="fa fa-mars-stroke-h" aria-hidden="true"></i> <span class="sr-only">Example of </span>mars-stroke-h</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mars-stroke-v"><i class="fa fa-mars-stroke-v" aria-hidden="true"></i> <span class="sr-only">Example of </span>mars-stroke-v</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mercury"><i class="fa fa-mercury" aria-hidden="true"></i> <span class="sr-only">Example of </span>mercury</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="neuter"><i class="fa fa-neuter" aria-hidden="true"></i> <span class="sr-only">Example of </span>neuter</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="transgender"><i class="fa fa-transgender" aria-hidden="true"></i> <span class="sr-only">Example of </span>transgender</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="transgender-alt"><i class="fa fa-transgender-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>transgender-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="venus"><i class="fa fa-venus" aria-hidden="true"></i> <span class="sr-only">Example of </span>venus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="venus-double"><i class="fa fa-venus-double" aria-hidden="true"></i> <span class="sr-only">Example of </span>venus-double</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="venus-mars"><i class="fa fa-venus-mars" aria-hidden="true"></i> <span class="sr-only">Example of </span>venus-mars</a></div>
                
            </div>
        </section>
        <section id="file-type">
            <h2 class="page-header">File Type Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="file"><i class="fa fa-file" aria-hidden="true"></i> <span class="sr-only">Example of </span>file</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-archive-o"><i class="fa fa-file-archive-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-archive-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-audio-o"><i class="fa fa-file-audio-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-audio-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-code-o"><i class="fa fa-file-code-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-code-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-excel-o"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-excel-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-image-o"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-image-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-video-o"><i class="fa fa-file-movie-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-movie-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-o"><i class="fa fa-file-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-pdf-o"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-pdf-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-image-o"><i class="fa fa-file-photo-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-photo-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-image-o"><i class="fa fa-file-picture-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-picture-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-powerpoint-o"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-powerpoint-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-audio-o"><i class="fa fa-file-sound-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-sound-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-text"><i class="fa fa-file-text" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-text</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-text-o"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-text-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-video-o"><i class="fa fa-file-video-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-video-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-word-o"><i class="fa fa-file-word-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-word-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-archive-o"><i class="fa fa-file-zip-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-zip-o <span class="text-muted">(alias)</span></a></div>
                
            </div>
        </section>
        <section id="form-control">
            <h2 class="page-header">Form Control Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="check-square"><i class="fa fa-check-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="check-square-o"><i class="fa fa-check-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="circle"><i class="fa fa-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="circle-o"><i class="fa fa-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="dot-circle-o"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>dot-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="minus-square"><i class="fa fa-minus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="minus-square-o"><i class="fa fa-minus-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus-square"><i class="fa fa-plus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus-square-o"><i class="fa fa-plus-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-square-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="square"><i class="fa fa-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="square-o"><i class="fa fa-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>square-o</a></div>
                
            </div>
        </section>
        <section id="payment">
            <h2 class="page-header">Payment Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-amex"><i class="fa fa-cc-amex" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-amex</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-diners-club"><i class="fa fa-cc-diners-club" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-diners-club</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-discover"><i class="fa fa-cc-discover" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-discover</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-jcb"><i class="fa fa-cc-jcb" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-jcb</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-mastercard"><i class="fa fa-cc-mastercard" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-mastercard</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-paypal"><i class="fa fa-cc-paypal" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-paypal</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-stripe"><i class="fa fa-cc-stripe" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-stripe</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-visa"><i class="fa fa-cc-visa" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-visa</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="credit-card"><i class="fa fa-credit-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>credit-card</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="credit-card-alt"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>credit-card-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google-wallet"><i class="fa fa-google-wallet" aria-hidden="true"></i> <span class="sr-only">Example of </span>google-wallet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paypal"><i class="fa fa-paypal" aria-hidden="true"></i> <span class="sr-only">Example of </span>paypal</a></div>
                
            </div>
        </section>
        <section id="chart">
            <h2 class="page-header">Chart Icons</h2>
            <div class="row fontawesome-icon-list">

                <div class="fa-hover col-sm-1"><a data-font-icon="area-chart"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>area-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bar-chart"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>bar-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bar-chart"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bar-chart-o <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="line-chart"><i class="fa fa-line-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>line-chart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pie-chart"><i class="fa fa-pie-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>pie-chart</a></div>
                
            </div>
        </section>
        <section id="currency">
            <h2 class="page-header">Currency Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="btc"><i class="fa fa-bitcoin" aria-hidden="true"></i> <span class="sr-only">Example of </span>bitcoin <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="btc"><i class="fa fa-btc" aria-hidden="true"></i> <span class="sr-only">Example of </span>btc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="jpy"><i class="fa fa-cny" aria-hidden="true"></i> <span class="sr-only">Example of </span>cny <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="usd"><i class="fa fa-dollar" aria-hidden="true"></i> <span class="sr-only">Example of </span>dollar <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eur"><i class="fa fa-eur" aria-hidden="true"></i> <span class="sr-only">Example of </span>eur</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eur"><i class="fa fa-euro" aria-hidden="true"></i> <span class="sr-only">Example of </span>euro <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gbp"><i class="fa fa-gbp" aria-hidden="true"></i> <span class="sr-only">Example of </span>gbp</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gg"><i class="fa fa-gg" aria-hidden="true"></i> <span class="sr-only">Example of </span>gg</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gg-circle"><i class="fa fa-gg-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>gg-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ils"><i class="fa fa-ils" aria-hidden="true"></i> <span class="sr-only">Example of </span>ils</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="inr"><i class="fa fa-inr" aria-hidden="true"></i> <span class="sr-only">Example of </span>inr</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="jpy"><i class="fa fa-jpy" aria-hidden="true"></i> <span class="sr-only">Example of </span>jpy</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="krw"><i class="fa fa-krw" aria-hidden="true"></i> <span class="sr-only">Example of </span>krw</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="money"><i class="fa fa-money" aria-hidden="true"></i> <span class="sr-only">Example of </span>money</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="jpy"><i class="fa fa-rmb" aria-hidden="true"></i> <span class="sr-only">Example of </span>rmb <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rub"><i class="fa fa-rouble" aria-hidden="true"></i> <span class="sr-only">Example of </span>rouble <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rub"><i class="fa fa-rub" aria-hidden="true"></i> <span class="sr-only">Example of </span>rub</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rub"><i class="fa fa-ruble" aria-hidden="true"></i> <span class="sr-only">Example of </span>ruble <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="inr"><i class="fa fa-rupee" aria-hidden="true"></i> <span class="sr-only">Example of </span>rupee <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ils"><i class="fa fa-shekel" aria-hidden="true"></i> <span class="sr-only">Example of </span>shekel <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ils"><i class="fa fa-sheqel" aria-hidden="true"></i> <span class="sr-only">Example of </span>sheqel <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="try"><i class="fa fa-try" aria-hidden="true"></i> <span class="sr-only">Example of </span>try</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="try"><i class="fa fa-turkish-lira" aria-hidden="true"></i> <span class="sr-only">Example of </span>turkish-lira <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="usd"><i class="fa fa-usd" aria-hidden="true"></i> <span class="sr-only">Example of </span>usd</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="viacoin"><i class="fa fa-viacoin" aria-hidden="true"></i> <span class="sr-only">Example of </span>viacoin</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="krw"><i class="fa fa-won" aria-hidden="true"></i> <span class="sr-only">Example of </span>won <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="jpy"><i class="fa fa-yen" aria-hidden="true"></i> <span class="sr-only">Example of </span>yen <span class="text-muted">(alias)</span></a></div>
                
            </div>
        </section>
        <section id="text-editor">
            <h2 class="page-header">Text Editor Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="align-center"><i class="fa fa-align-center" aria-hidden="true"></i> <span class="sr-only">Example of </span>align-center</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="align-justify"><i class="fa fa-align-justify" aria-hidden="true"></i> <span class="sr-only">Example of </span>align-justify</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="align-left"><i class="fa fa-align-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>align-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="align-right"><i class="fa fa-align-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>align-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bold"><i class="fa fa-bold" aria-hidden="true"></i> <span class="sr-only">Example of </span>bold</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="link"><i class="fa fa-chain" aria-hidden="true"></i> <span class="sr-only">Example of </span>chain <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chain-broken"><i class="fa fa-chain-broken" aria-hidden="true"></i> <span class="sr-only">Example of </span>chain-broken</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="clipboard"><i class="fa fa-clipboard" aria-hidden="true"></i> <span class="sr-only">Example of </span>clipboard</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="columns"><i class="fa fa-columns" aria-hidden="true"></i> <span class="sr-only">Example of </span>columns</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="files-o"><i class="fa fa-copy" aria-hidden="true"></i> <span class="sr-only">Example of </span>copy <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="scissors"><i class="fa fa-cut" aria-hidden="true"></i> <span class="sr-only">Example of </span>cut <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="outdent"><i class="fa fa-dedent" aria-hidden="true"></i> <span class="sr-only">Example of </span>dedent <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eraser"><i class="fa fa-eraser" aria-hidden="true"></i> <span class="sr-only">Example of </span>eraser</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file"><i class="fa fa-file" aria-hidden="true"></i> <span class="sr-only">Example of </span>file</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-o"><i class="fa fa-file-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-text"><i class="fa fa-file-text" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-text</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="file-text-o"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-text-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="files-o"><i class="fa fa-files-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>files-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="floppy-o"><i class="fa fa-floppy-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>floppy-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="font"><i class="fa fa-font" aria-hidden="true"></i> <span class="sr-only">Example of </span>font</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="header"><i class="fa fa-header" aria-hidden="true"></i> <span class="sr-only">Example of </span>header</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="indent"><i class="fa fa-indent" aria-hidden="true"></i> <span class="sr-only">Example of </span>indent</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="italic"><i class="fa fa-italic" aria-hidden="true"></i> <span class="sr-only">Example of </span>italic</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="link"><i class="fa fa-link" aria-hidden="true"></i> <span class="sr-only">Example of </span>link</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="list"><i class="fa fa-list" aria-hidden="true"></i> <span class="sr-only">Example of </span>list</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="list-alt"><i class="fa fa-list-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>list-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="list-ol"><i class="fa fa-list-ol" aria-hidden="true"></i> <span class="sr-only">Example of </span>list-ol</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="list-ul"><i class="fa fa-list-ul" aria-hidden="true"></i> <span class="sr-only">Example of </span>list-ul</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="outdent"><i class="fa fa-outdent" aria-hidden="true"></i> <span class="sr-only">Example of </span>outdent</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paperclip"><i class="fa fa-paperclip" aria-hidden="true"></i> <span class="sr-only">Example of </span>paperclip</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paragraph"><i class="fa fa-paragraph" aria-hidden="true"></i> <span class="sr-only">Example of </span>paragraph</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="clipboard"><i class="fa fa-paste" aria-hidden="true"></i> <span class="sr-only">Example of </span>paste <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="repeat"><i class="fa fa-repeat" aria-hidden="true"></i> <span class="sr-only">Example of </span>repeat</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="undo"><i class="fa fa-rotate-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>rotate-left <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="repeat"><i class="fa fa-rotate-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>rotate-right <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="floppy-o"><i class="fa fa-save" aria-hidden="true"></i> <span class="sr-only">Example of </span>save <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="scissors"><i class="fa fa-scissors" aria-hidden="true"></i> <span class="sr-only">Example of </span>scissors</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="strikethrough"><i class="fa fa-strikethrough" aria-hidden="true"></i> <span class="sr-only">Example of </span>strikethrough</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="subscript"><i class="fa fa-subscript" aria-hidden="true"></i> <span class="sr-only">Example of </span>subscript</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="superscript"><i class="fa fa-superscript" aria-hidden="true"></i> <span class="sr-only">Example of </span>superscript</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="table"><i class="fa fa-table" aria-hidden="true"></i> <span class="sr-only">Example of </span>table</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="text-height"><i class="fa fa-text-height" aria-hidden="true"></i> <span class="sr-only">Example of </span>text-height</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="text-width"><i class="fa fa-text-width" aria-hidden="true"></i> <span class="sr-only">Example of </span>text-width</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="th"><i class="fa fa-th" aria-hidden="true"></i> <span class="sr-only">Example of </span>th</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="th-large"><i class="fa fa-th-large" aria-hidden="true"></i> <span class="sr-only">Example of </span>th-large</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="th-list"><i class="fa fa-th-list" aria-hidden="true"></i> <span class="sr-only">Example of </span>th-list</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="underline"><i class="fa fa-underline" aria-hidden="true"></i> <span class="sr-only">Example of </span>underline</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="undo"><i class="fa fa-undo" aria-hidden="true"></i> <span class="sr-only">Example of </span>undo</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chain-broken"><i class="fa fa-unlink" aria-hidden="true"></i> <span class="sr-only">Example of </span>unlink <span class="text-muted">(alias)</span></a></div>
                
            </div>
        </section>
        <section id="directional">
            <h2 class="page-header">Directional Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-double-down"><i class="fa fa-angle-double-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-double-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-double-left"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-double-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-double-right"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-double-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-double-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-double-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-down"><i class="fa fa-angle-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-left"><i class="fa fa-angle-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-right"><i class="fa fa-angle-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angle-up"><i class="fa fa-angle-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>angle-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-down"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-left"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-o-down"><i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-o-left"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-o-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-o-right"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-o-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-o-up"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-right"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-circle-up"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-circle-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-down"><i class="fa fa-arrow-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-left"><i class="fa fa-arrow-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrow-up"><i class="fa fa-arrow-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrow-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows"><i class="fa fa-arrows" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows-alt"><i class="fa fa-arrows-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows-h"><i class="fa fa-arrows-h" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-h</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows-v"><i class="fa fa-arrows-v" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-v</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-left"><i class="fa fa-caret-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-right"><i class="fa fa-caret-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-down"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-left"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-right"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-up"><i class="fa fa-caret-square-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-up"><i class="fa fa-caret-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-circle-down"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-circle-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-circle-left"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-circle-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-circle-right"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-circle-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-circle-up"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-circle-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-down"><i class="fa fa-chevron-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-left"><i class="fa fa-chevron-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-right"><i class="fa fa-chevron-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chevron-up"><i class="fa fa-chevron-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>chevron-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="exchange"><i class="fa fa-exchange" aria-hidden="true"></i> <span class="sr-only">Example of </span>exchange</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-down"><i class="fa fa-hand-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-left"><i class="fa fa-hand-o-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-right"><i class="fa fa-hand-o-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hand-o-up"><i class="fa fa-hand-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-o-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="long-arrow-down"><i class="fa fa-long-arrow-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>long-arrow-down</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="long-arrow-left"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>long-arrow-left</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="long-arrow-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>long-arrow-right</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="long-arrow-up"><i class="fa fa-long-arrow-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>long-arrow-up</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-down"><i class="fa fa-toggle-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-down <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-left"><i class="fa fa-toggle-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-left <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-right"><i class="fa fa-toggle-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-right <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="caret-square-o-up"><i class="fa fa-toggle-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>toggle-up <span class="text-muted">(alias)</span></a></div>
                
            </div>
        </section>
        <section id="video-player">
            <h2 class="page-header">Video Player Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="arrows-alt"><i class="fa fa-arrows-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="backward"><i class="fa fa-backward" aria-hidden="true"></i> <span class="sr-only">Example of </span>backward</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="compress"><i class="fa fa-compress" aria-hidden="true"></i> <span class="sr-only">Example of </span>compress</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eject"><i class="fa fa-eject" aria-hidden="true"></i> <span class="sr-only">Example of </span>eject</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="expand"><i class="fa fa-expand" aria-hidden="true"></i> <span class="sr-only">Example of </span>expand</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fast-backward"><i class="fa fa-fast-backward" aria-hidden="true"></i> <span class="sr-only">Example of </span>fast-backward</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fast-forward"><i class="fa fa-fast-forward" aria-hidden="true"></i> <span class="sr-only">Example of </span>fast-forward</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="forward"><i class="fa fa-forward" aria-hidden="true"></i> <span class="sr-only">Example of </span>forward</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pause"><i class="fa fa-pause" aria-hidden="true"></i> <span class="sr-only">Example of </span>pause</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pause-circle"><i class="fa fa-pause-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>pause-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pause-circle-o"><i class="fa fa-pause-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>pause-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="play"><i class="fa fa-play" aria-hidden="true"></i> <span class="sr-only">Example of </span>play</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="play-circle"><i class="fa fa-play-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>play-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="play-circle-o"><i class="fa fa-play-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>play-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="random"><i class="fa fa-random" aria-hidden="true"></i> <span class="sr-only">Example of </span>random</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="step-backward"><i class="fa fa-step-backward" aria-hidden="true"></i> <span class="sr-only">Example of </span>step-backward</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="step-forward"><i class="fa fa-step-forward" aria-hidden="true"></i> <span class="sr-only">Example of </span>step-forward</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stop"><i class="fa fa-stop" aria-hidden="true"></i> <span class="sr-only">Example of </span>stop</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stop-circle"><i class="fa fa-stop-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>stop-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stop-circle-o"><i class="fa fa-stop-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>stop-circle-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="youtube-play"><i class="fa fa-youtube-play" aria-hidden="true"></i> <span class="sr-only">Example of </span>youtube-play</a></div>
                
            </div>
        </section>
        <section id="brand">
            <h2 class="page-header">Brand Icons</h2>
            <div class="row fontawesome-icon-list margin-bottom-lg">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="500px"><i class="fa fa-500px" aria-hidden="true"></i> <span class="sr-only">Example of </span>500px</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="adn"><i class="fa fa-adn" aria-hidden="true"></i> <span class="sr-only">Example of </span>adn</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="amazon"><i class="fa fa-amazon" aria-hidden="true"></i> <span class="sr-only">Example of </span>amazon</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="android"><i class="fa fa-android" aria-hidden="true"></i> <span class="sr-only">Example of </span>android</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="angellist"><i class="fa fa-angellist" aria-hidden="true"></i> <span class="sr-only">Example of </span>angellist</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="apple"><i class="fa fa-apple" aria-hidden="true"></i> <span class="sr-only">Example of </span>apple</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bandcamp"><i class="fa fa-bandcamp" aria-hidden="true"></i> <span class="sr-only">Example of </span>bandcamp</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="behance"><i class="fa fa-behance" aria-hidden="true"></i> <span class="sr-only">Example of </span>behance</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="behance-square"><i class="fa fa-behance-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>behance-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bitbucket"><i class="fa fa-bitbucket" aria-hidden="true"></i> <span class="sr-only">Example of </span>bitbucket</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bitbucket-square"><i class="fa fa-bitbucket-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>bitbucket-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="btc"><i class="fa fa-bitcoin" aria-hidden="true"></i> <span class="sr-only">Example of </span>bitcoin <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="black-tie"><i class="fa fa-black-tie" aria-hidden="true"></i> <span class="sr-only">Example of </span>black-tie</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bluetooth"><i class="fa fa-bluetooth" aria-hidden="true"></i> <span class="sr-only">Example of </span>bluetooth</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="bluetooth-b"><i class="fa fa-bluetooth-b" aria-hidden="true"></i> <span class="sr-only">Example of </span>bluetooth-b</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="btc"><i class="fa fa-btc" aria-hidden="true"></i> <span class="sr-only">Example of </span>btc</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="buysellads"><i class="fa fa-buysellads" aria-hidden="true"></i> <span class="sr-only">Example of </span>buysellads</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-amex"><i class="fa fa-cc-amex" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-amex</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-diners-club"><i class="fa fa-cc-diners-club" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-diners-club</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-discover"><i class="fa fa-cc-discover" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-discover</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-jcb"><i class="fa fa-cc-jcb" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-jcb</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-mastercard"><i class="fa fa-cc-mastercard" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-mastercard</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-paypal"><i class="fa fa-cc-paypal" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-paypal</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-stripe"><i class="fa fa-cc-stripe" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-stripe</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="cc-visa"><i class="fa fa-cc-visa" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc-visa</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="chrome"><i class="fa fa-chrome" aria-hidden="true"></i> <span class="sr-only">Example of </span>chrome</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="codepen"><i class="fa fa-codepen" aria-hidden="true"></i> <span class="sr-only">Example of </span>codepen</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="codiepie"><i class="fa fa-codiepie" aria-hidden="true"></i> <span class="sr-only">Example of </span>codiepie</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="connectdevelop"><i class="fa fa-connectdevelop" aria-hidden="true"></i> <span class="sr-only">Example of </span>connectdevelop</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="contao"><i class="fa fa-contao" aria-hidden="true"></i> <span class="sr-only">Example of </span>contao</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="css3"><i class="fa fa-css3" aria-hidden="true"></i> <span class="sr-only">Example of </span>css3</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="dashcube"><i class="fa fa-dashcube" aria-hidden="true"></i> <span class="sr-only">Example of </span>dashcube</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="delicious"><i class="fa fa-delicious" aria-hidden="true"></i> <span class="sr-only">Example of </span>delicious</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="deviantart"><i class="fa fa-deviantart" aria-hidden="true"></i> <span class="sr-only">Example of </span>deviantart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="digg"><i class="fa fa-digg" aria-hidden="true"></i> <span class="sr-only">Example of </span>digg</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i> <span class="sr-only">Example of </span>dribbble</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="dropbox"><i class="fa fa-dropbox" aria-hidden="true"></i> <span class="sr-only">Example of </span>dropbox</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="drupal"><i class="fa fa-drupal" aria-hidden="true"></i> <span class="sr-only">Example of </span>drupal</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="edge"><i class="fa fa-edge" aria-hidden="true"></i> <span class="sr-only">Example of </span>edge</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="eercast"><i class="fa fa-eercast" aria-hidden="true"></i> <span class="sr-only">Example of </span>eercast</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="empire"><i class="fa fa-empire" aria-hidden="true"></i> <span class="sr-only">Example of </span>empire</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="envira"><i class="fa fa-envira" aria-hidden="true"></i> <span class="sr-only">Example of </span>envira</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="etsy"><i class="fa fa-etsy" aria-hidden="true"></i> <span class="sr-only">Example of </span>etsy</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="expeditedssl"><i class="fa fa-expeditedssl" aria-hidden="true"></i> <span class="sr-only">Example of </span>expeditedssl</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="font-awesome"><i class="fa fa-fa" aria-hidden="true"></i> <span class="sr-only">Example of </span>fa <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="facebook"><i class="fa fa-facebook" aria-hidden="true"></i> <span class="sr-only">Example of </span>facebook</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="facebook"><i class="fa fa-facebook-f" aria-hidden="true"></i> <span class="sr-only">Example of </span>facebook-f <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="facebook-official"><i class="fa fa-facebook-official" aria-hidden="true"></i> <span class="sr-only">Example of </span>facebook-official</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="facebook-square"><i class="fa fa-facebook-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>facebook-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="firefox"><i class="fa fa-firefox" aria-hidden="true"></i> <span class="sr-only">Example of </span>firefox</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="first-order"><i class="fa fa-first-order" aria-hidden="true"></i> <span class="sr-only">Example of </span>first-order</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="flickr"><i class="fa fa-flickr" aria-hidden="true"></i> <span class="sr-only">Example of </span>flickr</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="font-awesome"><i class="fa fa-font-awesome" aria-hidden="true"></i> <span class="sr-only">Example of </span>font-awesome</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fonticons"><i class="fa fa-fonticons" aria-hidden="true"></i> <span class="sr-only">Example of </span>fonticons</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="fort-awesome"><i class="fa fa-fort-awesome" aria-hidden="true"></i> <span class="sr-only">Example of </span>fort-awesome</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="forumbee"><i class="fa fa-forumbee" aria-hidden="true"></i> <span class="sr-only">Example of </span>forumbee</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="foursquare"><i class="fa fa-foursquare" aria-hidden="true"></i> <span class="sr-only">Example of </span>foursquare</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="free-code-camp"><i class="fa fa-free-code-camp" aria-hidden="true"></i> <span class="sr-only">Example of </span>free-code-camp</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="empire"><i class="fa fa-ge" aria-hidden="true"></i> <span class="sr-only">Example of </span>ge <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="get-pocket"><i class="fa fa-get-pocket" aria-hidden="true"></i> <span class="sr-only">Example of </span>get-pocket</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gg"><i class="fa fa-gg" aria-hidden="true"></i> <span class="sr-only">Example of </span>gg</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gg-circle"><i class="fa fa-gg-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>gg-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="git"><i class="fa fa-git" aria-hidden="true"></i> <span class="sr-only">Example of </span>git</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="git-square"><i class="fa fa-git-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>git-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="github"><i class="fa fa-github" aria-hidden="true"></i> <span class="sr-only">Example of </span>github</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="github-alt"><i class="fa fa-github-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>github-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="github-square"><i class="fa fa-github-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>github-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gitlab"><i class="fa fa-gitlab" aria-hidden="true"></i> <span class="sr-only">Example of </span>gitlab</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gratipay"><i class="fa fa-gittip" aria-hidden="true"></i> <span class="sr-only">Example of </span>gittip <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="glide"><i class="fa fa-glide" aria-hidden="true"></i> <span class="sr-only">Example of </span>glide</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="glide-g"><i class="fa fa-glide-g" aria-hidden="true"></i> <span class="sr-only">Example of </span>glide-g</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google"><i class="fa fa-google" aria-hidden="true"></i> <span class="sr-only">Example of </span>google</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google-plus"><i class="fa fa-google-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>google-plus</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google-plus-official"><i class="fa fa-google-plus-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>google-plus-circle <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google-plus-official"><i class="fa fa-google-plus-official" aria-hidden="true"></i> <span class="sr-only">Example of </span>google-plus-official</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google-plus-square"><i class="fa fa-google-plus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>google-plus-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="google-wallet"><i class="fa fa-google-wallet" aria-hidden="true"></i> <span class="sr-only">Example of </span>google-wallet</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="gratipay"><i class="fa fa-gratipay" aria-hidden="true"></i> <span class="sr-only">Example of </span>gratipay</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="grav"><i class="fa fa-grav" aria-hidden="true"></i> <span class="sr-only">Example of </span>grav</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hacker-news"><i class="fa fa-hacker-news" aria-hidden="true"></i> <span class="sr-only">Example of </span>hacker-news</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="houzz"><i class="fa fa-houzz" aria-hidden="true"></i> <span class="sr-only">Example of </span>houzz</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="html5"><i class="fa fa-html5" aria-hidden="true"></i> <span class="sr-only">Example of </span>html5</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="imdb"><i class="fa fa-imdb" aria-hidden="true"></i> <span class="sr-only">Example of </span>imdb</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="instagram"><i class="fa fa-instagram" aria-hidden="true"></i> <span class="sr-only">Example of </span>instagram</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="internet-explorer"><i class="fa fa-internet-explorer" aria-hidden="true"></i> <span class="sr-only">Example of </span>internet-explorer</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ioxhost"><i class="fa fa-ioxhost" aria-hidden="true"></i> <span class="sr-only">Example of </span>ioxhost</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="joomla"><i class="fa fa-joomla" aria-hidden="true"></i> <span class="sr-only">Example of </span>joomla</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="jsfiddle"><i class="fa fa-jsfiddle" aria-hidden="true"></i> <span class="sr-only">Example of </span>jsfiddle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="lastfm"><i class="fa fa-lastfm" aria-hidden="true"></i> <span class="sr-only">Example of </span>lastfm</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="lastfm-square"><i class="fa fa-lastfm-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>lastfm-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="leanpub"><i class="fa fa-leanpub" aria-hidden="true"></i> <span class="sr-only">Example of </span>leanpub</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i> <span class="sr-only">Example of </span>linkedin</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="linkedin-square"><i class="fa fa-linkedin-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>linkedin-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="linode"><i class="fa fa-linode" aria-hidden="true"></i> <span class="sr-only">Example of </span>linode</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="linux"><i class="fa fa-linux" aria-hidden="true"></i> <span class="sr-only">Example of </span>linux</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="maxcdn"><i class="fa fa-maxcdn" aria-hidden="true"></i> <span class="sr-only">Example of </span>maxcdn</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="meanpath"><i class="fa fa-meanpath" aria-hidden="true"></i> <span class="sr-only">Example of </span>meanpath</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="medium"><i class="fa fa-medium" aria-hidden="true"></i> <span class="sr-only">Example of </span>medium</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="meetup"><i class="fa fa-meetup" aria-hidden="true"></i> <span class="sr-only">Example of </span>meetup</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="mixcloud"><i class="fa fa-mixcloud" aria-hidden="true"></i> <span class="sr-only">Example of </span>mixcloud</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="modx"><i class="fa fa-modx" aria-hidden="true"></i> <span class="sr-only">Example of </span>modx</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="odnoklassniki"><i class="fa fa-odnoklassniki" aria-hidden="true"></i> <span class="sr-only">Example of </span>odnoklassniki</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="odnoklassniki-square"><i class="fa fa-odnoklassniki-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>odnoklassniki-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="opencart"><i class="fa fa-opencart" aria-hidden="true"></i> <span class="sr-only">Example of </span>opencart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="openid"><i class="fa fa-openid" aria-hidden="true"></i> <span class="sr-only">Example of </span>openid</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="opera"><i class="fa fa-opera" aria-hidden="true"></i> <span class="sr-only">Example of </span>opera</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="optin-monster"><i class="fa fa-optin-monster" aria-hidden="true"></i> <span class="sr-only">Example of </span>optin-monster</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pagelines"><i class="fa fa-pagelines" aria-hidden="true"></i> <span class="sr-only">Example of </span>pagelines</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="paypal"><i class="fa fa-paypal" aria-hidden="true"></i> <span class="sr-only">Example of </span>paypal</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pied-piper"><i class="fa fa-pied-piper" aria-hidden="true"></i> <span class="sr-only">Example of </span>pied-piper</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pied-piper-alt"><i class="fa fa-pied-piper-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>pied-piper-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pied-piper-pp"><i class="fa fa-pied-piper-pp" aria-hidden="true"></i> <span class="sr-only">Example of </span>pied-piper-pp</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i> <span class="sr-only">Example of </span>pinterest</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pinterest-p"><i class="fa fa-pinterest-p" aria-hidden="true"></i> <span class="sr-only">Example of </span>pinterest-p</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="pinterest-square"><i class="fa fa-pinterest-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>pinterest-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="product-hunt"><i class="fa fa-product-hunt" aria-hidden="true"></i> <span class="sr-only">Example of </span>product-hunt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="qq"><i class="fa fa-qq" aria-hidden="true"></i> <span class="sr-only">Example of </span>qq</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="quora"><i class="fa fa-quora" aria-hidden="true"></i> <span class="sr-only">Example of </span>quora</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rebel"><i class="fa fa-ra" aria-hidden="true"></i> <span class="sr-only">Example of </span>ra <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="ravelry"><i class="fa fa-ravelry" aria-hidden="true"></i> <span class="sr-only">Example of </span>ravelry</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rebel"><i class="fa fa-rebel" aria-hidden="true"></i> <span class="sr-only">Example of </span>rebel</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reddit"><i class="fa fa-reddit" aria-hidden="true"></i> <span class="sr-only">Example of </span>reddit</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reddit-alien"><i class="fa fa-reddit-alien" aria-hidden="true"></i> <span class="sr-only">Example of </span>reddit-alien</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="reddit-square"><i class="fa fa-reddit-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>reddit-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="renren"><i class="fa fa-renren" aria-hidden="true"></i> <span class="sr-only">Example of </span>renren</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="rebel"><i class="fa fa-resistance" aria-hidden="true"></i> <span class="sr-only">Example of </span>resistance <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="safari"><i class="fa fa-safari" aria-hidden="true"></i> <span class="sr-only">Example of </span>safari</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="scribd"><i class="fa fa-scribd" aria-hidden="true"></i> <span class="sr-only">Example of </span>scribd</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="sellsy"><i class="fa fa-sellsy" aria-hidden="true"></i> <span class="sr-only">Example of </span>sellsy</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share-alt"><i class="fa fa-share-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>share-alt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="share-alt-square"><i class="fa fa-share-alt-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>share-alt-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="shirtsinbulk"><i class="fa fa-shirtsinbulk" aria-hidden="true"></i> <span class="sr-only">Example of </span>shirtsinbulk</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="simplybuilt"><i class="fa fa-simplybuilt" aria-hidden="true"></i> <span class="sr-only">Example of </span>simplybuilt</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="skyatlas"><i class="fa fa-skyatlas" aria-hidden="true"></i> <span class="sr-only">Example of </span>skyatlas</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="skype"><i class="fa fa-skype" aria-hidden="true"></i> <span class="sr-only">Example of </span>skype</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="slack"><i class="fa fa-slack" aria-hidden="true"></i> <span class="sr-only">Example of </span>slack</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="slideshare"><i class="fa fa-slideshare" aria-hidden="true"></i> <span class="sr-only">Example of </span>slideshare</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="snapchat"><i class="fa fa-snapchat" aria-hidden="true"></i> <span class="sr-only">Example of </span>snapchat</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="snapchat-ghost"><i class="fa fa-snapchat-ghost" aria-hidden="true"></i> <span class="sr-only">Example of </span>snapchat-ghost</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="snapchat-square"><i class="fa fa-snapchat-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>snapchat-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="soundcloud"><i class="fa fa-soundcloud" aria-hidden="true"></i> <span class="sr-only">Example of </span>soundcloud</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="spotify"><i class="fa fa-spotify" aria-hidden="true"></i> <span class="sr-only">Example of </span>spotify</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stack-exchange"><i class="fa fa-stack-exchange" aria-hidden="true"></i> <span class="sr-only">Example of </span>stack-exchange</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stack-overflow"><i class="fa fa-stack-overflow" aria-hidden="true"></i> <span class="sr-only">Example of </span>stack-overflow</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="steam"><i class="fa fa-steam" aria-hidden="true"></i> <span class="sr-only">Example of </span>steam</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="steam-square"><i class="fa fa-steam-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>steam-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stumbleupon"><i class="fa fa-stumbleupon" aria-hidden="true"></i> <span class="sr-only">Example of </span>stumbleupon</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stumbleupon-circle"><i class="fa fa-stumbleupon-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>stumbleupon-circle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="superpowers"><i class="fa fa-superpowers" aria-hidden="true"></i> <span class="sr-only">Example of </span>superpowers</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="telegram"><i class="fa fa-telegram" aria-hidden="true"></i> <span class="sr-only">Example of </span>telegram</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tencent-weibo"><i class="fa fa-tencent-weibo" aria-hidden="true"></i> <span class="sr-only">Example of </span>tencent-weibo</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="themeisle"><i class="fa fa-themeisle" aria-hidden="true"></i> <span class="sr-only">Example of </span>themeisle</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="trello"><i class="fa fa-trello" aria-hidden="true"></i> <span class="sr-only">Example of </span>trello</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tripadvisor"><i class="fa fa-tripadvisor" aria-hidden="true"></i> <span class="sr-only">Example of </span>tripadvisor</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tumblr"><i class="fa fa-tumblr" aria-hidden="true"></i> <span class="sr-only">Example of </span>tumblr</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="tumblr-square"><i class="fa fa-tumblr-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>tumblr-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="twitch"><i class="fa fa-twitch" aria-hidden="true"></i> <span class="sr-only">Example of </span>twitch</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="twitter"><i class="fa fa-twitter" aria-hidden="true"></i> <span class="sr-only">Example of </span>twitter</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="twitter-square"><i class="fa fa-twitter-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>twitter-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="usb"><i class="fa fa-usb" aria-hidden="true"></i> <span class="sr-only">Example of </span>usb</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="viacoin"><i class="fa fa-viacoin" aria-hidden="true"></i> <span class="sr-only">Example of </span>viacoin</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="viadeo"><i class="fa fa-viadeo" aria-hidden="true"></i> <span class="sr-only">Example of </span>viadeo</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="viadeo-square"><i class="fa fa-viadeo-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>viadeo-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i> <span class="sr-only">Example of </span>vimeo</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="vimeo-square"><i class="fa fa-vimeo-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>vimeo-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="vine"><i class="fa fa-vine" aria-hidden="true"></i> <span class="sr-only">Example of </span>vine</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="vk"><i class="fa fa-vk" aria-hidden="true"></i> <span class="sr-only">Example of </span>vk</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="weixin"><i class="fa fa-wechat" aria-hidden="true"></i> <span class="sr-only">Example of </span>wechat <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="weibo"><i class="fa fa-weibo" aria-hidden="true"></i> <span class="sr-only">Example of </span>weibo</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="weixin"><i class="fa fa-weixin" aria-hidden="true"></i> <span class="sr-only">Example of </span>weixin</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i> <span class="sr-only">Example of </span>whatsapp</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wikipedia-w"><i class="fa fa-wikipedia-w" aria-hidden="true"></i> <span class="sr-only">Example of </span>wikipedia-w</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="windows"><i class="fa fa-windows" aria-hidden="true"></i> <span class="sr-only">Example of </span>windows</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wordpress"><i class="fa fa-wordpress" aria-hidden="true"></i> <span class="sr-only">Example of </span>wordpress</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wpbeginner"><i class="fa fa-wpbeginner" aria-hidden="true"></i> <span class="sr-only">Example of </span>wpbeginner</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wpexplorer"><i class="fa fa-wpexplorer" aria-hidden="true"></i> <span class="sr-only">Example of </span>wpexplorer</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wpforms"><i class="fa fa-wpforms" aria-hidden="true"></i> <span class="sr-only">Example of </span>wpforms</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="xing"><i class="fa fa-xing" aria-hidden="true"></i> <span class="sr-only">Example of </span>xing</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="xing-square"><i class="fa fa-xing-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>xing-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="y-combinator"><i class="fa fa-y-combinator" aria-hidden="true"></i> <span class="sr-only">Example of </span>y-combinator</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hacker-news"><i class="fa fa-y-combinator-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>y-combinator-square <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="yahoo"><i class="fa fa-yahoo" aria-hidden="true"></i> <span class="sr-only">Example of </span>yahoo</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="y-combinator"><i class="fa fa-yc" aria-hidden="true"></i> <span class="sr-only">Example of </span>yc <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hacker-news"><i class="fa fa-yc-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>yc-square <span class="text-muted">(alias)</span></a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="yelp"><i class="fa fa-yelp" aria-hidden="true"></i> <span class="sr-only">Example of </span>yelp</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="yoast"><i class="fa fa-yoast" aria-hidden="true"></i> <span class="sr-only">Example of </span>yoast</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="youtube"><i class="fa fa-youtube" aria-hidden="true"></i> <span class="sr-only">Example of </span>youtube</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="youtube-play"><i class="fa fa-youtube-play" aria-hidden="true"></i> <span class="sr-only">Example of </span>youtube-play</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="youtube-square"><i class="fa fa-youtube-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>youtube-square</a></div>
                
            </div>
        </section>
        <section id="medical">
            <h2 class="page-header">Medical Icons</h2>
            <div class="row fontawesome-icon-list">
                

                
                <div class="fa-hover col-sm-1"><a data-font-icon="ambulance"><i class="fa fa-ambulance" aria-hidden="true"></i> <span class="sr-only">Example of </span>ambulance</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="h-square"><i class="fa fa-h-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>h-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="heart"><i class="fa fa-heart" aria-hidden="true"></i> <span class="sr-only">Example of </span>heart</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="heart-o"><i class="fa fa-heart-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>heart-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="heartbeat"><i class="fa fa-heartbeat" aria-hidden="true"></i> <span class="sr-only">Example of </span>heartbeat</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="hospital-o"><i class="fa fa-hospital-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hospital-o</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="medkit"><i class="fa fa-medkit" aria-hidden="true"></i> <span class="sr-only">Example of </span>medkit</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="plus-square"><i class="fa fa-plus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-square</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="stethoscope"><i class="fa fa-stethoscope" aria-hidden="true"></i> <span class="sr-only">Example of </span>stethoscope</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="user-md"><i class="fa fa-user-md" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-md</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair"><i class="fa fa-wheelchair" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair</a></div>
                
                <div class="fa-hover col-sm-1"><a data-font-icon="wheelchair-alt"><i class="fa fa-wheelchair-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>wheelchair-alt</a></div>
                
            </div>
        </section>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#cms").siblings('a').attr('aria-expanded','true');
    $("ul#cms").addClass("show");
    $("ul#cms #cms-module-menu").addClass("active");

    var lang_id = <?php echo json_encode($lang_id); ?>;
    $("select[name=language_id]").val(lang_id);
    $('.selectpicker').selectpicker('refresh');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var icon_list = $('#icons section').clone();

    $(document).on("click", ".icon", function() {
        $(this).parent().parent().find(".card-body").html(icon_list);
    });

    $(document).on("click", ".fa-hover a", function() {
        var icon = $(this).data('font-icon');
        $(this).closest('.collapse').parent().find(".icon").val('fa fa-'+icon);
        $(this).closest('.collapse').removeClass('show');
    });

    $('.edit-btn').on('click', function(){
        $("#editModal input[name='icon']").val($(this).data('font'));
        $("#editModal input[name='name']").val($(this).data('name'));
        $("#editModal textarea[name='description']").html($(this).data('description'));
        $("#editModal input[name='module_id']").val($(this).data('id'));
    });
    $('#custom-btn').on('click', function(){
        var count = $('#custom-field hr').length + 1;
        htmlText = '<div class="row"><div class="col-sm-3"><input type="text" name="icon[]" class="form-control icon" value="" data-toggle="collapse" href="#icon_collapse'+count+'" aria-expanded="false" aria-controls="icon_collapse'+count+'"/></div><div class="col-sm-3"><input type="text" name="name[]" class="form-control" placeholder="{{trans('file.name')}}"/></div><div class="col-sm-5"><textarea name="description[]" class="form-control" placeholder="{{trans('file.description')}}"></textarea></div><div class="col-sm-1"><span class="input-group-btn delete-fields"><button class="btn btn-danger btn-lg delete-btn" type="button">X</button></span></div><div class="collapse icon_collapse" id="icon_collapse'+count+'"><div class="card"><div class="card-body"></div></div></div></div><hr>';
        $('#custom-field').append(htmlText);
    });

    $(document).on("click", ".delete-btn", function() {
        $(this).parent().parent().parent().next().remove();
        $(this).closest(".row").remove();
    });

    $('#module-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1, 2]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi', selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
                // customize: function(doc) {
                //     for (var i = 1; i < doc.content[1].table.body.length; i++) {
                //         if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                //             var imagehtml = doc.content[1].table.body[i][0].text;
                //             var regex = /<img.*?src=['"](.*?)['"]/;
                //             var src = regex.exec(imagehtml)[1];
                //             var tempImage = new Image();
                //             tempImage.src = src;
                //             var canvas = document.createElement("canvas");
                //             canvas.width = tempImage.width;
                //             canvas.height = tempImage.height;
                //             var ctx = canvas.getContext("2d");
                //             ctx.drawImage(tempImage, 0, 0);
                //             var imagedata = canvas.toDataURL("image/png");
                //             delete doc.content[1].table.body[i][0].text;
                //             doc.content[1].table.body[i][0].image = imagedata;
                //             doc.content[1].table.body[i][0].fit = [30, 30];
                //         }
                //     }
                // },
            },
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
                            if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                data = regex.exec(data)[1];
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'print',
                text: 'Print',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                }
            },
            {
                extend: 'colvis',
                text: 'Column visibility',
                columns: ':gt(0)'
            },
        ],
    } );

    $( "#tablecontents" ).sortable({
      items: "tr",
      cursor: 'move',
      opacity: 0.6,
      update: function() {
          sendOrderToServer();
      }
    });

    function sendOrderToServer() {
        var order = [];
        $('tr.row1').each(function(index,element) {
          order.push({
            id: $(this).attr('data-id'),
            position: index+1
          });
        });

        $.ajax({
          type: "POST",
          url: "{{ url('superadmin/module-section/sort') }}",
          data: {
            order:order
          },
          success: function(response) {
              alert(response);
          }
        });

    }
</script>
@endpush
