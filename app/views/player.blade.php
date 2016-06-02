<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> - </title>
	<link rel="stylesheet" href="/assets/player/skin/functional.css">
	
	<!--<script src="/assets/player/jquery-1.11.2.min.js"></script> -->
	<!-- Flowplayer library -->
	<script src="/assets/player/flowplayer.min.js"></script>
	
	<!-- load the Flowplayer hlsjs engine, including hls.js -->
	<script src="/assets/player/plugins/hlsjs/flowplayer.hlsjs.min.js"></script>
	
	<style>
		body {
			overflow-x: hidden !important;
			overflow-y: hidden !important;
			margin: 30px 5px 0 5px !important;
		}
		
		.flowplayer {
			max-width: 1366px !important;
			margin-bottom: 30px;
			background-color: #000000 !important;
		}
		
		.flowplayer.is-splash .fp-controls, .flowplayer.is-poster .fp-controls, .flowplayer.is-splash .fp-time, .flowplayer.is-poster .fp-time {
			display: block !important;
		}
		
		.flowplayer .fp-timeline-tooltip {
			bottom: 45px !important;
		}
	
		.flowplayer.is-mouseover .fp-controls, .flowplayer.fixed-controls .fp-controls {
			height: 60px !important;
		}
		
		.flowplayer .fp-play {
			height: 45px !important;
		}
		
		.flowplayer .fp-timeline {
			height: 30px !important;
			top: 15px !important;
		}

		.flowplayer .fp-time em {
			height: 25px !important;
			width: 40px !important;
			font-size: small !important;
		}
		
		.flowplayer .fp-waiting {
			display: none !important;
		}
		
	</style>
</head>
<body>

<div id="content" class="flowplayer fixed-controls no-toggle play-button no-mute no-volume"></div>

	<script>
		window.onload = function () {
			var timer,
			player = flowplayer("#content", {
					
					splash: true,
					ratio: 1/100,
					fullscreen: false,
					embed: false,
					
					clip: {

						sources: [
							{
								engine: "hlsjs",
								type: "application/x-mpegurl",
								src:  "{{ $hlsurl }}"
							}
							,
							{
								engine: "html5",
								type: "application/x-mpegurl",
								src:  "{{ $hlsurl }}"
							}
							,
							//{
							//	engine: "flash",
							//	type: "application/x-mpegurl",
							//	src:  "{{ $hlsurl }}"
							//}
							//,
							{
								engine: "html5",
								type: "video/mp4",
								src:  "{{ $url }}"
							}
							,
							{
								engine: "flash",
								type: "video/mp4",
								src:  "{{ $url }}"
							}
						]
					}
					
				}).on("load", function (e, api) {
					
				}).on("ready", function (e, api, video) {
					
				}).on("progress", function (e, api) {
				
				}).on("unload", function (e, api) {
					
				}).on("finish", function (e, api) {
					// all players go to splash state on finish
					api.unload();
				}).on("error", function (e, api, err) {
					clearInterval(timer);
					var delay = 1;
					
					api.error = api.loading = false;
					[].forEach.call(document.querySelectorAll('.is-error'), function(el) {
						el.className = el.className.replace(/ *is-error */, "");
					});
					api.load(api.conf.clip);
					
					timer = setInterval(function () {
						delay -= 1;
						
						if (!delay) {
							clearInterval(timer);
							api.unload();
						}

					}, 1000);

				});
		};
	</script>




</body>
</html>