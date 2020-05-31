@extends('layouts.app2')

@section('title')
    Add New @yield('entity')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h2">Add New @yield('entity')</div>
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