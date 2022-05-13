@php
	$captcha = loadCustomCaptcha();
@endphp
@if($captcha)
<div class="row">
    <div class="form-group col-md-12">
        @php echo $captcha @endphp
    </div>
    
    <div class="form-group col-md-12">
        <div class="position-relative">
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control">
        </div>
    </div>
</div>
@endif
