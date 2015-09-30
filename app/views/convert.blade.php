
@section('style')
@parent
	<style type="text/css">

		input[readonly] {
			background-color: white !important;
			cursor: text !important;
		}
		
		div.fileinputs {
	position: relative;
}

div.fakefile {
	position: absolute;
	top: 0px;
	right: 0px;
	z-index: 1;
}

#fakeinput {
	text-align: left;
	direction: ltr;
	width: 250px;
	height: 30px;
}

input.file {
	position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity: 0);
	opacity: 0;
	z-index: 2;
	width: 500px;
	height: 50px;
}

.iframe-container {
	position: relative;
    padding-bottom: 56.25%;
	padding-left: 20px;
	padding-right: 20px;
    padding-top: 35px;
    height: 0;
    overflow: hidden;

}

.iframe-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 95%;
    height: 100%;
}

.center {
	margin-left: auto;
	margin-right: auto;
	width: 12em;
}
	</style>
@stop

@section('content')

<div class="center">
استاد: {{ $teacher }}
<br>
درس: {{ $course }}
<br>
سال: {{ $date }}
<br>


</div>


{{ Form::open(
		[
			'route' =>
						[
							'convert',
							$feqh,
							$archive,
							$convert,
							$teacher,
							$course,
							$year
						],
			'class' => 'form-horizontal',
			'method' => 'post',
			'files' => true,
			'id' => 'uploadForm',
			'name' => 'uploadForm',
			'style' => 'padding-right: 5px;',
		]
	)
}}
	<br>
	<div class="form-group">
	
		<div class="input-group col-md-24">
			<span class="input-group-btn">
				<span class=" btn-primary btn-file">
				
					

					<div class="fileinputs">
						<input type="file" class="file hidden" multiple="" name="doc" id="doc">
					<div class="fakefile"><span>@lang('app.choose_file'): </span><input type="text" name="fakeinput" id="fakeinput" /></div></div>
				
				
					<!-- Browse… <input type="file" multiple="" name="doc" id="doc"> -->
				</span>
			</span>
			<!-- <input class="form-control" readonly="" type="text"> -->
		</div>

	<span class="help-block"></span>
	</div>
	<br><br>
<!-- Form Actions -->
<div class="form-group">
	<button type="submit" class=" btn-primary" name="upload" id="upload">@lang('app.convert_to_html')</button>
	<button type="submit" class=" btn-primary" name="download_html" id="download_html" style="display:none;">@lang('app.download_html')</button>
	<button type="submit" class=" btn-primary" name="download_style" id="download_style" style="display:none;">@lang('app.download_style')</button>
</div>
{{ Form::close() }}

<br><br>

<div class="iframe-container">
<iframe name="result" id="result" src="" frameborder="0">
  
</iframe>
</div>

@stop

@section('javascript')
@parent
	<script src="/assets/js/jquery-1.10.2.min.js"></script>
	<script src="/assets/js/jquery.form.js"></script>

	<script>
		$(document)
			.on('change', '.btn-file :file', function() {
				$('#download_html').css('display','none');
				$('#download_style').css('display','none');
				$('span.help-block').text('');
				
				
				var iframe = $('iframe#result').get(0);
			
					var iframeDoc = iframe.document;
				if (iframe.contentDocument)
					iframeDoc = iframe.contentDocument;
				else if (iframe.contentWindow)
					iframeDoc = iframe.contentWindow.document;

			 if (iframeDoc){
				 // Put the content in the iframe
				 
				 iframeDoc.open();
				 iframeDoc.write('');
				 iframeDoc.close();
				 $(window).scrollTop(0);
				 
			 } else {
				//just in case of browsers that don't support the above 3 properties.
				//fortunately we don't come across such case so far.
				//alert('Cannot inject dynamic contents into iframe.');
			 }

				var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				input.trigger('fileselect', [numFiles, label]);
		});
		
		
			$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
				
				var input = $(this).parents('.input-group').find(':text'),
					log = numFiles > 1 ? numFiles + ' files selected' : label;
				
				if( input.length ) {
					input.val(log);
				} else {
					//if( log ) alert(log);
				}
				
			});
		
	
        // wait for the DOM to be loaded 
        $(document).ready(function() {
			var options = {
				target:        '#result',   // target element(s) to be updated with server response 
				// beforeSubmit:  showRequest,  // pre-submit callback 
				success:       processJson,  // post-submit callback
				error:         displayError,
		 
				// other available options: 
				//url:       url         // override for form's 'action' attribute 
				//type:      type        // 'get' or 'post', override for form's 'method' attribute 
				dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type) 
				//clearForm: true        // clear all form fields after successful submit 
				//resetForm: true        // reset the form after successful submit 
		 
				// $.ajax options can be used here too, for example: 
				//timeout:   3000 
			};
			
			var button;

			$('button[type="submit"]').click(function(e){
			   button = $(this).attr("name");
			   $('span.help-block').text('');
			});
			
			 // bind to the form's submit event 
			$('#uploadForm').submit(function() {
				
				
				if(button == 'upload')
				{
					$('#upload').prop("disabled",true);
					
					// inside event callbacks 'this' is the DOM element so we first 
					// wrap it in a jQuery object and then invoke ajaxSubmit 
					$(this).ajaxSubmit(options); 
			 
					// !!! Important !!! 
					// always return false to prevent standard browser submit and page navigation 
					return false; 
				}
			
				
			}); 
			
            // bind 'myForm' and provide a simple callback function 
            //$('#uploadForm').ajaxForm(options); 
        });
		
		function displayError() {
			
			$('span.help-block').text('@lang('app.convert_error')');
			$('#upload').prop("disabled",false);
			$('#download_html').css('display','none');
			$('#download_style').css('display','none');
			
			var iframe = $('iframe#result').get(0);
			
					var iframeDoc = iframe.document;
				if (iframe.contentDocument)
					iframeDoc = iframe.contentDocument;
				else if (iframe.contentWindow)
					iframeDoc = iframe.contentWindow.document;

			 if (iframeDoc){
				 // Put the content in the iframe
				 
				 iframeDoc.open();
				 iframeDoc.write('');
				 iframeDoc.close();
				 $(window).scrollTop(0);
				 
			 } else {
				//just in case of browsers that don't support the above 3 properties.
				//fortunately we don't come across such case so far.
				//alert('Cannot inject dynamic contents into iframe.');
			 }
			
		};
		
		function processJson(data) {
			
			$('#upload').prop("disabled",false);
			
			// 'data' is the json object returned from the server
			
			// var iframeDoc = $('#result').contentWindow.document;
			// iframeDoc.open();
			// iframeDoc.write(data.content);
			// iframeDoc.close();
			
			// if jQuery is available, you may use the get(0) function to obtain the DOM object like this:
			var iframe = $('iframe#result').get(0);
			
					var iframeDoc = iframe.document;
				if (iframe.contentDocument)
					iframeDoc = iframe.contentDocument;
				else if (iframe.contentWindow)
					iframeDoc = iframe.contentWindow.document;

			 if (iframeDoc){
				 // Put the content in the iframe
				 
				 iframeDoc.open();
				 iframeDoc.write(data.content);
				 iframeDoc.close();
				 $(window).scrollTop(0);
				 
			 } else {
				//just in case of browsers that don't support the above 3 properties.
				//fortunately we don't come across such case so far.
				//alert('Cannot inject dynamic contents into iframe.');
			 }
			 
			 $('#download_html').css('display','inline');
			 $('#download_style').css('display','inline');
		};
    </script>
@stop

