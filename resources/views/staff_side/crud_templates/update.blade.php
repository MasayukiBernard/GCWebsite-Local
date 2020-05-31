@extends('layouts.app2')

@section('title')
    Edit @yield('entity')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">Old @yield('entity') data</div>
                    <div class="card-body">
                        @yield('old-data')
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">Edit @yield('entity') data</div>
                    <div class="card-body">
                        <form method="POST" action="@yield('form-action')">
                            @csrf
                            @yield('form-inputs')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection