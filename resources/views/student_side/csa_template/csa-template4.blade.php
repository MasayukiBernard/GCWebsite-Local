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
                    <div class="card-body px-0">
                        <div class="col-md-12">
                        <form method="POST" action=@yield('form-action') enctype="multipart/form-data">
                            @csrf
                            @yield('form-inputs')
                            <div class="form-group row">
                                <div class="col-md-3 pl-4">
                                    <a class="btn btn-secondary btn-lg ml-1" href=@yield('return-route') role="button">Prev</a>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <div>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a role="button" href="{{route('student.csa-form.csa-page1')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">1</a>
                                            <a role="button" href="{{route('student.csa-form.csa-page2')}}" class="b tn btn-secondary rounded-circle py-2 px-3 mx-1">2</a>
                                            <a role="button" href="{{route('student.csa-form.csa-page2a')}}"class="btn btn-secondary rounded-circle py-2 px-2 mx-1">2 A</a>
                                            <a role="button" href="{{route('student.csa-form.csa-page3')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">3</a>
                                            <a role="button" class="btn btn-warning rounded-circle py-2 px-3 mx-1">4</a>
                                            <a role="button" href="{{route('student.csa-form.csa-page5')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">5</a>
                                            <a role="button" href="{{route('student.csa-form.csa-page6')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">6</a>
                                            <a role="button" href="{{route('student.csa-form.csa-page7')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">7</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right">
                                    <input type="submit" id="submit_btn" class="btn btn-primary btn-lg mr-3 d-none" value="@yield('confirm-value')">
                                    <a class="btn btn-primary btn-lg mr-3" href="{{route('student.csa-form.csa-page5')}}" role="button" id="next_btn">@yield('next-value')</a>
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