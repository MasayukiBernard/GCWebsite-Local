@extends('layouts.app2')

@section('title')
    @yield('entity')
@endsection

@section('content')
    <div class="container">
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
                                <div class="col-md-12 text-right">
                                    <a class="btn btn-secondary btn-lg" href=@yield('return-route') role="button">Prev</a>
                                    @if ($allow_submit)
                                        <input type="submit" id="submit_btn" class="btn btn-success btn-lg mr-3" value="@yield('confirm-value')">
                                    @else
                                        <span class="badge badge-danger p-3">@yield('confirm-value')</span>
                                        <div>
                                            <span class="text-danger">You are not allowed to submit the application form yet, please input all of the required informations!</span> 
                                        </div>
                                    @endif
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