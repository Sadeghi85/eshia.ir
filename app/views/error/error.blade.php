@extends('layouts.master')

@section('content')

<br />
	<p style="padding:10px;">
		@if ($message)
			{{ preg_replace('#"(.+)?"#', sprintf('&nbsp;<i><font color="#000000"> %s </font></i>&nbsp;', '$1'), $message) }}
		@else
			@lang('app.not_found')
		@endif
	</p>
<br />

@stop

@section('title')
	@parent
@stop