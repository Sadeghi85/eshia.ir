@php
	$locale = App::getLocale();
@endphp
<span class="backtoleslist">
@if($locale == 'ar')
	<a  href="/Ar/Feqh/Archive/{{ $teacher }}/{{ $lesson }}/{{ $year }}_{{ $year+1 }}#lesson_{{ $date }}">  <  قائمة الدروس</a>
@else
	<a href="/Feqh/Archive/{{ $teacher }}/{{ $lesson }}/{{ $year }}#lesson_{{ $date }}"> < فهرست دروس</a>
@endif
</span>