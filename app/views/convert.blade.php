@extends('layout.default')

@section('style')
@parent
	<style type="text/css">

		input[readonly] {
			background-color: white !important;
			cursor: text !important;
		}
	</style>
@stop

@section('content')



{{ Form::open(array('route' => 'convert', 'class' => 'form-horizontal', 'method' => 'post', 'files' => true, 'id' => 'uploadForm', 'name' => 'uploadForm')) }}
	<div class="form-group">
	
		<div class="input-group col-md-24">
			<span class="input-group-btn">
				<span class="btn btn-primary btn-file">
					Browse… <input type="file" multiple="" name="doc" id="doc">
				</span>
			</span>
			<input class="form-control" readonly="" type="text">
		</div>

	<span class="help-block"></span>
	</div>
	
<!-- Form Actions -->
<div class="form-group">
	<button type="submit" class="btn btn-primary" name="upload" id="upload">Upload</button>
	<button type="submit" class="btn btn-primary" name="download" id="download" style="display:none;">Download as Zip</button>
</div>
{{ Form::close() }}



<div class="iframe-container">
<iframe name="result" id="result" src="" frameborder="0">
  
</iframe>
</div>

@stop

@section('javascript')
@parent
	<script src="/assets/js/jquery-1.8.0.min.js"></script>

	<script>
		$(document)
			.on('change', '.btn-file :file', function() {
				$('#download').css('display','none');
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
				alert('Cannot inject dynamic contents into iframe.');
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
					if( log ) alert(log);
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
			});
			
			 // bind to the form's submit event 
			$('#uploadForm').submit(function() {
				
				
				if(button == 'upload')
				{
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
			
			$('span.help-block').text('Error');
		};
		
		function processJson(data) {
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
				alert('Cannot inject dynamic contents into iframe.');
			 }
			 
			 $('#download').css('display','inline');
		};
    </script>
@stop
