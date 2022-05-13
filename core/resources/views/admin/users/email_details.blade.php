<!DOCTYPE html>
<html>
<head>
	<title>{{ $pageTitle }}</title>
	<style>
		.info{
			margin-top: 40px;
		    margin-left: 40px;
		    margin-bottom: 25px;
		}
		p{
			margin: 0;
			margin-bottom: 10px;
		}
		h4{
			margin: 0;
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="info">
		<h4>{{ __($email->subject) }}</h4>
		<p><strong>@lang('To'): </strong> {{ $email->email_to }}</p>
		<p><strong>@lang('From'): </strong> {{ __($general->sitename) }} {{'<'.$email->email_from.'>'}}</p>
		<p><strong>@lang('Via'): </strong> <span>@</span>{{ __($email->mail_sender) }} {{ showDateTime($email->created_at) }}</p>
	</div>
	@php echo $email->message @endphp
</body>
</html>