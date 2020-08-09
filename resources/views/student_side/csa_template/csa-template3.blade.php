@extends('layouts.app2')

@section('title')
    @yield('entity')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div id="notification_bar" class="row justify-content-center m-0 mb-2 text-light">
                    @isset($success)
                        <div id="success_notif" class="col-md-12 bg-success rounded py-2 font-weight-bold h4 m-0">
                            <div class="row">
                                <div class="col-11">
                                    {{$success}}
                                </div>
                                <div class="col-1 text-right">
                                    <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                                </div>
                            </div>
                        </div>
                    @endisset
                    @error('id')
                        <div id="failed_notif" class="col-md-12 bg-danger rounded py-2 font-weight-bold h4 m-0">
                            <div class="row">
                                <div class="col-11">
                                    Failed to delete an achievement!
                                </div>
                                <div class="col-1 text-right">
                                    <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                                </div>
                            </div>
                        </div>
                    @enderror
                </div>
                <div class="card">
                    <div class="card-header h2">@yield('entity')</div>
                    <div class="card-body">
                        <div class="col-md-12 px-0">
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
                                                <a role="button" href="{{route('student.csa-form.csa-page2a')}}" class="btn btn-secondary rounded-circle py-2 px-2 mx-1">2 A</a>
                                                <a role="button" class="btn btn-warning rounded-circle py-2 px-3 mx-1">3</a>
                                                <a role="button" href="{{route('student.csa-form.csa-page4')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">4</a>
                                                <a role="button" href="{{route('student.csa-form.csa-page5')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">5</a>
                                                <a role="button" href="{{route('student.csa-form.csa-page6')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">6</a>
                                                <a role="button" href="{{route('student.csa-form.csa-page7')}}" class="btn btn-secondary rounded-circle py-2 px-3 mx-1">7</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <input type="submit" id="submit_btn" class="btn btn-primary btn-lg mr-3 d-none" value="@yield('confirm-value')">
                                        <a class="btn btn-primary btn-lg mr-3" href="{{route('student.csa-form.csa-page4')}}" role="button" id="next_btn">@yield('next-value')</a>
                                    </div>
                                </div>
                            </form>

                            <form id="deleteForm" method="POST" action="{{route('student.csa-form.delete-achievement')}}">
                                @csrf
                                <input type="hidden" name="id">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection