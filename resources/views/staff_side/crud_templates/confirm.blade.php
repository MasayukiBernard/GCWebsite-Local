@extends('layouts.app2')

@section('title')
    Confirm @yield('entity-crud')
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h2">Confirm @yield('entity-crud')</div>
                <div class="card-body">
                    @yield('entity-distinct-content')
                    <form method="POST" action=@yield('form-action')>
                        @csrf
                        <input type="submit" class="btn btn-primary" value="Confirm">
                        <a class="btn btn-secondary" href=@yield('return-route') role="button">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection