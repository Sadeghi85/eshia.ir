
@section('content')
{{ $content }}
@stop

@section('javascript')
	@parent
	
	<script type="text/javascript">
		var cumulativeOffset = function(element) {
			var top = 0, left = 0;
			do {
				top += element.offsetTop  || 0;
				left += element.offsetLeft || 0;
				element = element.offsetParent;
			} while(element);
			return {
				top: top,
				left: left
			};
		};
		
		var hilights = document.querySelectorAll('.hilight');
		
		if (hilights.length) {
			var target = hilights[0];
			window.scrollTo(0,cumulativeOffset(target).top-100);
		}
	</script>
	
@stop
