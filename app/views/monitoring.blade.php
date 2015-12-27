@section('content')


<div class="wrap">




<table id="table2" width="100%" border="0"  cellpadding="0" cellspacing="0">

	<tr>
  	<td colspan="2" align="right">
	
		<table class="downloadtable" width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td   align="center" valign="middle" class="download-td-title" >نام فایل</td>
				<td   align="center" valign="middle" class="download-td-title" >تاریخ</td>
				<td   align="center" valign="middle" class="download-td-title">ساعت</td>
				<td   align="center" valign="middle" class="download-td-title">استاد</td>
				<td   align="center" valign="middle" class="download-td-title">درس</td>
				<td   align="center" valign="middle" class="download-td-title">محتوا</td>
				<td   align="center" valign="middle" class="download-td-title">سال</td>
				<td   align="center" valign="middle" class="download-td-title">حجم فایل</td>
				
			</tr>
			
		@foreach ($results as $key => $result)
			<tr>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle"><a href="{{ $result['fileUrl'] }}" target=_blank>{{ $result['file_name'] }}</a></td>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle">{{ $result['date'] }}</td>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle">{{ $result['time'] }}</td>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle">{{ $result['teacher'] }}</td>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle">{{ $result['course'] }}</td>
				<td class="{{ $result['extension'] == 'wma' ? 'download-td-voice' : 'download-td-text' }}" align="center" valign="middle">{{ $result['type'] }}</td>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle"><a href="{{ $result['indexUrl'] }}" target=_blank>{{ $result['year'] }}</a></td>
				<td class="{{ $result['year'] < 50 ? 'download-td-arabic' : 'download-td-persian' }}" align="center" valign="middle">{{ $result['file_size'] }}</td>
			</tr>
			
        @endforeach
        
  		</table>
	</td>
  	</tr>

</table>













</div>
@stop
