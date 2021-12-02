<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
     

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    
                    {{-- User part of Navbar. Is seen only by Private ro Commercial users --}}

                    <ul class="navbar-nav mr-auto">
                        @if ( !Auth::guest() && !Auth::user()->isBlocked() && (Auth::user()->isPrivate() || Auth::user()->isCommercial()))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" href="/events">{{ __('user_messages.events') }}</a>
                                    <div class="dropdown-menu">                       
                                        <a class="nav-link" href="/events">{{ __('user_messages.all_events') }}</a>
                                        
                                        {{-- Output each current event, that is not finished --}}
                                        
                                        @foreach($current_events as  $current_event)
                                            <a class="nav-link" href={{"/events/".$current_event->id}}>{{ $current_event->name }}</a>
                                        @endforeach
                                        
                                    </div>
                            
                        </li>
                        <li><a class="nav-link" href="/bills">{{ __('user_messages.bills') }}</a></li>
                        <li><a class="nav-link" href="/articles">{{ __('user_messages.articles') }}</a></li>

                        @endif
                            
                        @if ( !Auth::guest() && Auth::user()->isReviewer() )
                            <a class="nav-link" href="/review">Reviewer dashboard</a>
                        @endif
                        {{-- Admin part of Navbar --}}
                        
                        @if ( !Auth::guest() && Auth::user()->isAdmin() )
                            <li><a class="nav-link" href="/notifications">{{ __('admin_messages.notifications') }}</a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ __('admin_messages.events') }}</a>
                                    <div class="dropdown-menu">
                                        <a class="nav-link" href="/events/create">{{ __('admin_messages.create_event') }}</a>
                                        <a class="nav-link" href="/events/manage">{{ __('admin_messages.manage_events') }}</a>
                                    </div>
                            </li>
                            <li><a class="nav-link" href="/bills/manage">{{ __('admin_messages.manage_bills') }}</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ __('admin_messages.billing_plans') }}</a>
                                    <div class="dropdown-menu">
                                        <a class="nav-link" href="/billing_plans/create">{{ __('admin_messages.create_billing_plan') }}</a>
                                        <a class="nav-link" href="/billing_plans">{{ __('admin_messages.manage_billing_plans') }}</a>
                                    </div>
                            </li>
                            <li><a class="nav-link" href="/users">{{ __('admin_messages.manage_roles') }}</a></li>
                            <li><a class="nav-link" href="/statistics">{{ __('admin_messages.statistics') }}</a></li>
                            
                        @endif
                    </ul>
                    <!-- Right Side Of Navbar -->
                    
                    {{-- Localization part of Navbar; No access restrictions. --}}
                    
                    <ul class="navbar-nav ml-auto">
                        <li><a class="nav-link" href="/lang/en">   <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAARCAIAAAAzPjmrAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTExIDc5LjE1ODMyNSwgMjAxNS8wOS8xMC0wMToxMDoyMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkFCM0QxQTlGMEQyRDExRTZBOEJGRTZCOUM2NjUxNEM1IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkFCM0QxQUEwMEQyRDExRTZBOEJGRTZCOUM2NjUxNEM1Ij4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QUIzRDFBOUQwRDJEMTFFNkE4QkZFNkI5QzY2NTE0QzUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QUIzRDFBOUUwRDJEMTFFNkE4QkZFNkI5QzY2NTE0QzUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5Osz06AAACAklEQVR42rSTO2/TUBiGfeyTNs7FtY/tJDaxkyZCpFwqMbGj0rFSESMDG7+AjbELf4C1P6FTFyRY6NIJqUMiRSIXx0l8i3NpokJjO3xUYmSoJZ/hO+cs73ue9/sOOjr6uJXCvn+tKKTft+t1td02Gw2t1TIaDR3O+sPyVrdz3P6OaLSh7r3Qq4MPqkowxsvlDbeTnU2XgpADPyJyvr8gQt7zr+Vs6uT9AYXQ/fUpnM2maYZZzFeg7rkzWeZte1osCdbYL5UEx5nyhGOi9Y3t0igOAZ7PVyy7zQs5151DSqbpaZpsGI6uFwam+0AVx5Plb8tsnnxF8Qx4PpfPs543LylkOJyALnSiWi31elalUhwMXEniSOX54afPkGeciCDo7XRKknbGo0m5LIF6pVrsdMa1GnjYml4wrdlt37h4/Q4MYhJw+YzjzhRFNE0XCHpd647A1rTCaOhJspBlKfK4DlNExetBJpOWRM6yfEUVIRPwMAxQl03TUVVpOJqkZK769g0MURwCQvIMQ8N7IfFW09jb06+uOvv7NahPn+22mv3dR3rY7X57eUzTdJx/8HM03UQbmkFhGGGGCYIQp5hg/a9iZh1GLIpI8IuKA0Dh4PQUtvDucvufukJoEWuE/hpYlz+oJBeKgjBRA/zlxWGyBIOz82QJ0gU5WYIz5UmiBn8EGAAtZN8UaBAz4gAAAABJRU5ErkJggjE0MjY=" alt="EN"></a></li>  
                        <li><a class="nav-link" href="/lang/ru">   <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAVCAIAAACor3u9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTExIDc5LjE1ODMyNSwgMjAxNS8wOS8xMC0wMToxMDoyMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjczMEExNkExMEQwRTExRTY4MzM4RUQxQTY1ODVGRkFFIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjczMEExNkEyMEQwRTExRTY4MzM4RUQxQTY1ODVGRkFFIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6NzMwQTE2OUYwRDBFMTFFNjgzMzhFRDFBNjU4NUZGQUUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6NzMwQTE2QTAwRDBFMTFFNjgzMzhFRDFBNjU4NUZGQUUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4XLy0KAAAAV0lEQVR42mL8//8/Ay0BEwONwagFA28By7tPv2hqAaOwx1ra+uDt2++0tYCBhWk0FREIIgZm2lrA//8LbZPpUR0N2vpA5P9n2lrwh8ZxMFqaDrwFAAEGALQmEA+T9rNSAAAAAElFTkSuQmCCOTk5" alt="RU"></a></li>

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
