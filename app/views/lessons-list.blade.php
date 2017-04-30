@php
	$locale = App::getLocale();
@endphp
<span class="backtoleslist">
@if($locale == 'ar')
	<a  href="/Ar/Feqh/Archive/{{ $teacher }}/{{ $lesson }}/{{ $year }}_{{ $year+1 }}#lesson_{{ $date }}">  < الرجوع إلى قائمة الدروس</a>
@else
	<a href="/Feqh/Archive/{{ $teacher }}/{{ $lesson }}/{{ $year }}#lesson_{{ $date }}"> < بازگشت  به لیست دروس </a>
@endif
</span>