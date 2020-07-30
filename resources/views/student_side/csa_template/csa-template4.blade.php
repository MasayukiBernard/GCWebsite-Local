@extends('layouts.app2')

@section('title')
    @yield('entity')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h2">@yield('entity')</div>
                    <div class="card-body">
                        <div class="col-md-12">
                        <form method="POST" action=@yield('form-action')>
                            @csrf
                            @yield('form-inputs')
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection