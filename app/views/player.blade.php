<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> &zwnj; </title>
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
			display: block !important;
			opacity: 1 !important;
			margin-left: 7px !important;
			left: 10px !important;
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
		
		.flowplayer.fixed-controls .fp-elapsed, .flowplayer.fixed-controls.is-mouseover .fp-elapsed {
			left: 50px !important;
		}
		
		.flowplayer.is-loading .fp-controls, .flowplayer.is-loading .fp-time {
			display: block !important;
		}
		
		.no-mute.no-volume.no-brand.flowplayer .fp-timeline {
			margin-right: 55px !important;
		}

		.flowplayer.fixed-controls .fp-controls .fp-timeline, .flowplayer.fixed-controls.is-mouseover .fp-controls .fp-timeline {
			margin-left: 95px !important;
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
						
						hlsjs: {
							startLevel: -1,
							smoothSwitching: true,
							maxBufferLength: 30,
							maxMaxBufferLength: 60,
							capLevelToPlayerSize: true
						},
						
						flashls: {
							maxbackbufferlength: 30,
							maxbufferlength: 60,
							seekfromlevel: -1,
							startfromlevel: -1,
							seekmode: "KEYFRAME",
							capleveltostage: true,
							maxlevelcappingmode: "upscale"
						},
				
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
							// Flash doesn't support Range requests
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
					
					api.unload();
					
					timer = setInterval(function () {
						delay -= 1;
						
						if (!delay) {
							clearInterval(timer);
							api.load(api.conf.clip);
						}

					}, 1000);
					
					

				});
		};
	</script>




</body>
</html>