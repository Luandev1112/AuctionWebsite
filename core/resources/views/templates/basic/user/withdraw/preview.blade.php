@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="dashboard-section pt-60 pb-60">
    <div class="container">
        <div class="pt-60 pb-60">
            <div class="row justify-content-center g-4">
                <div class="col-lg-10">
                    <div class="card custom--card">
                        <div class="card-header text-center">
                            <h5 class="title m-0">@lang('Current Balance'): {{ showAmount(auth()->user()->balance)}} {{ __($general->cur_text) }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-5">

                                    <ul class="list-group withdraw-preview">
                                        <li class="list-group-item">
                                            <span>@lang('Request Amount') :</span>
                                            <span class=" text--info">{{showAmount($withdraw->amount)  }} {{__($general->cur_text)}}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>@lang('Withdrawal Charge') :</span>
                                            <span class=" text--danger">{{showAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>@lang('After Charge') :</span>
                                            <span class=" text--primary">{{showAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>@lang('Conversion Rate') : </span>
                                            <span>
                                              <span>1 {{__($general->cur_text)}}</span> = <span class=" text--success">{{showAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</span>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span>@lang('You Will Get') :</span>
                                            <span class="text--warning">{{showAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                                        </li>
                                    </ul>
                                    <div class="form-group mt-5">
                                        <label class="form--label mb-2">@lang('Balance Will be') : </label>
                                        <div class="input-group">
                                            <input type="text" value="{{showAmount($withdraw->user->balance - ($withdraw->amount))}}"  class="form-control form--control-2 bg--body" placeholder="@lang('Enter Amount')" required readonly>
                                            <span class="input-group-text ">{{ __($general->cur_text) }} </span>
                                        </div>
                                    </div>     
                                </div>

                                <div class="col-lg-7">
                                    <div class="profle-wrapper">
                                        <form action="{{route('user.withdraw.submit')}}" method="post" class="user-profile-form row" enctype="multipart/form-data">
                                        @csrf
                                            @if($withdraw->method->user_data)
                                            @foreach($withdraw->method->user_data as $k => $v)
                                                @if($v->type == "text")
                                                    <div class="form-group">
                                                        <label class="form--label mb-2">{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</label>
                                                        <input type="text" name="{{$k}}" class="form-control form--control-2 bg--body" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                                        @if ($errors->has($k))
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($v->type == "textarea")
                                                    <div class="form-group">
                                                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <textarea name="{{$k}}"  class="form-control form--control-2 bg--body"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                        @if ($errors->has($k))
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($v->type == "file")
                                                    <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <div class="form-group">
                                                        <div class="fileinput fileinput-new " data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                                 data-trigger="fileinput">
                                                                <img class="w-100" src="{{ getImage('/')}}" alt="@lang('Image')">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>
                                                            <div class="img-input-div">
                                                                <span class="btn btn-info btn-file">
                                                                    <span class="fileinput-new "> @lang('Select') {{__($v->field_level)}}</span>
                                                                    <span class="fileinput-exists"> @lang('Change')</span>
                                                                    <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                                </span>
                                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                                data-dismiss="fileinput"> @lang('Remove')</a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has($k))
                                                            <br>
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                            @endif
                                            @if(auth()->user()->ts)
                                                <div class="form-group">
                                                    <label>@lang('Google Authenticator Code')</label>
                                                    <input type="text" name="authenticator_code" class="form-control form--control-2 bg--body" required>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <button type="submit" class="cmn--btn">@lang('Confirm')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
