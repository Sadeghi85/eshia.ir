@extends('layout.default')

@section('content')
<div id="contents">
<div id="contents_cover" class="Page_showPage">
<table class="content_headers" align="center" cellpadding="0" cellspacing="0">
<tr>
<td>	
<table class="Page-query-noresualt">
<tr>
<td>
<span class="not-found">
{{ preg_replace('#"(.+)?"#', sprintf('&nbsp;<i><font color="#000000"> %s </font></i>&nbsp;', '$1'), $message) }}
</span>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</div>
@stop

@section('title')
	@parent
@stop