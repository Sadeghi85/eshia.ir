<div class="insidesearchbox">
	
		<form action="#" id="mainSearchDarsPanel" class="searchdarsform" onsubmit="do_search(document.getElementById('searchContentInput').value, '{{ $teacher }}', '{{ $course }}', '{{ $year }}');return false;">
		<div>
			<label for="search_input" ></label>
			<input id="searchContentInput" value="@lang('app.content_search')" class="empty-search-item" autocomplete="off" onfocus="if (this.value == '@lang('app.content_search')') {this.value = ''; this.className=''}" onblur="if (this.value == '') {this.value = '@lang('app.content_search')'; this.className='empty-search-item'}">
			<input type="submit" value="" id="searchButton" class="SearchKey">
		</div>
		</form>
	
</div>