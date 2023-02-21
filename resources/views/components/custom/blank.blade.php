<!DOCTYPE html>
<html lang="en">
	<head>
        <title>@if(isset($title)) {{ $title }} |@endif {{ config('app.name', 'Laravel') }}</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="{{ asset('custom/images/logo.png') }}" type="image/icon type">

		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		
		@if(isset($css_template)) {{ $css_template }} @endif

		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('template/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('template/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		@if(isset($css_custom)) {{ $css_custom }} @endif
	</head>
	<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<script>
            var defaultThemeMode = "light"; 
            var themeMode; 
            
            if ( document.documentElement ) { 
                if ( document.documentElement.hasAttribute("data-theme-mode")) { 
                    themeMode = document.documentElement.getAttribute("data-theme-mode"); 
                } 
                else { 
                    if ( localStorage.getItem("data-theme") !== null ) { 
                        themeMode = localStorage.getItem("data-theme"); 
                    }
                    else { 
                        themeMode = defaultThemeMode; 
                    } 
                } 
                
                if (themeMode === "system") { 
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
                } 

                document.documentElement.setAttribute("data-theme", themeMode); 
            }
        </script>
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>
                body { 
                    background-image: url("{{ asset('template/assets/media/auth/bg5.jpg') }}"); 
                }
                [data-theme="dark"] body { 
                    background-image: url("{{ asset('template/assets/media/auth/bg5-dark.jpg') }}"); 
                }
            </style>

            {{ $slot }}
            
		</div>

		<script>var hostUrl = "{{ asset('template/assets') }}";</script>
		<script src="{{ asset('template/assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('template/assets/js/scripts.bundle.js') }}"></script>

		@if(isset($js_template)) {{ $js_template }} @endif
		@if(isset($js_custom)) {{ $js_custom }} @endif
	</body>
</html>