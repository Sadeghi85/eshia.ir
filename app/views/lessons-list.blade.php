@php
	$locale = App::getLocale();
@endphp
<span style="    float: right;
    margin-right: 20px;
    margin-top: 10px;
    position: absolute;">
@if($locale == 'ar')
	<a href="/Ar/Feqh/Archive/{{ $teacher }}/{{ $lesson }}/{{ $year }}_{{ $year+1 }}#lesson_{{ $date }}" style="    color: #bf5e2e !important;
    font-weight: bold;
    font-size: 14px;">الرجوع إلى قائمة الدروس</a>
@else
	<a href="/Feqh/Archive/{{ $teacher }}/{{ $lesson }}/{{ $year }}#lesson_{{ $date }}" style="    color: #bf5e2e !important;
    font-weight: bold;
    font-size: 14px;">رجوع به لیست درس</a>
@endif
</span>