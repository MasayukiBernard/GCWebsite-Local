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
                                    <input type="submit" id="submit_btn" class="btn btn-primary btn-lg mr-3 d-none" value="@yield('confirm-value')">
                                    <a class="btn btn-primary btn-lg mr-3" href="{{route('student.csa-form.csa-page7')}}" role="button" id="next_btn">@yield('next-value')</a>
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