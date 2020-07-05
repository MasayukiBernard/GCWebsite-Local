<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') &mdash; {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')

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
                <a class="navbar-brand" href="{{Auth::user()->is_staff ? route('staff.home') : route('student.home')}}">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if ((Auth::user()->is_staff))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.major.page') }}">
                                    Major
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('staff.academic-year.page') }}">
                                    Academic Year
                                </a>
                            </li>

                            <li class="nav-item">
                                <div class="nav-link dropdown show">
                                    <a class="text-decoration-none text-secondary dropdown-toggle" style="cursor: pointer;" role="button" id="partnerDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Partner
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="partnerDropdown">
                                        <a class="dropdown-item" href="{{route('staff.yearly-partner.page')}}">Yearly Partner</a>
                                        <a class="dropdown-item" href="{{route('staff.partner.page')}}">Master Partner</a>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="nav-item">
                                <div class="nav-link dropdown show">
                                    <a class="text-decoration-none text-secondary dropdown-toggle" style="cursor: pointer;" role="button" id="studentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Student
                                    </a>
                                  
                                    <div class="dropdown-menu" aria-labelledby="studentDropdown">
                                        <a class="dropdown-item" href="{{route('staff.yearly-student.page')}}">Yearly Student</a>
                                        <a class="dropdown-item" href="{{route('staff.student.page')}}">Master Student</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">

                                <a class="nav-link" href="{{ route('staff.csa-forms.page') }}">
                                    CSA Application Forms
                                </a>
                            </li>
                            @else
                            <li class='nav-item'>
                                <a class="nav-link" href="{{ route('student.csaform') }}">
                                    CSA Form
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ Auth::user()->is_staff ? route('staff.profile') : route('student.profile') }}">
                                    Profile
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
