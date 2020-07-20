@extends('layouts.app2')

@section('title')
    @yield('entity')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h2">@yield('entity')</div>
                    <div class="card-body">
                        <div class="col-md-12">
                        <form method="POST" action=@yield('form-action')>
                            @csrf
                            @yield('form-inputs')
                            <div class="form-group row">
                                <div class="col-md-4 offset-md-4">
                                    <a class="btn btn-secondary" href=@yield('return-route') role="button">Prev</a>
                                    <input type="submit" class="btn btn-primary" value="Next">
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection