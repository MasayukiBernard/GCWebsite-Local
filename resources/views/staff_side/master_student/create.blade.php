@extends('layouts.app2')

@section('title')
    Create New Master Student(s)
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h2">Create New Master Student(s)</div>
                    <div class="card-body">
                        <div class="row mx-0">
                            <div class="col-md-8 p-0">
                                <form id="set_form" method="POST" action="{{route('staff.student.set-students')}}">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-5 pr-0 pt-2">
                                                <label for="students_num">How Many Student Do You Want to Create?</label>
                                            </div>
                                            <div class="col-md-2 p-0">
                                                <input type="number" name="sum" id="student_num" class="form-control" min="1">
                                            </div>
                                            <div class="col-md-5 pl-2">
                                                <input class="btn btn-success" type="submit" value="Confirm">
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        @if (session('set_student_sum') != null)
                            <form method="POST" action="{{route('staff.student.create-confirm')}}">
                                @csrf
                                <div class="col-md-12 px-0" id="create_student_table">
                                    <div class="row mx-0 justify-content-center">
                                        <div class="col-md-1 p-2 text-center border rounded bg-secondary text-light">
                                            NO.
                                        </div>
                                        <div class="col-md-3 p-2 text-center border rounded bg-secondary text-light">
                                            NIM
                                        </div>
                                        <div class="col-md-8 p-2 text-center border rounded bg-secondary text-light">
                                            PASSWORD
                                        </div>
                                    </div>

                                    @for($i = 0; $i < session('set_student_sum'); ++$i)
                                        <div class="row mx-0 justify-content-center">
                                            <div class="col-md-1 p-2 py-3 text-center border rounded font-weight-bold">
                                                {{($i + 1)}}
                                            </div>
                                            <div class="col-md-3 p-2 text-center border rounded">
                                                <input type="text" class="form-control" name="nims[]" minlength="10" maxlength="10" autocomplete="off" value="{{old('nims.' . $i)}}">
                                            </div>
                                            <div class="col-md-8 p-2 text-center border rounded">
                                                <input type="password" class="form-control" name="passwords[]" minlength="8" maxlength="100" autocomplete="off">
                                            </div>
                                        </div>
                                        @error('nims.' . $i)
                                            <div class="row mx-0 mb-0 justify-content-center alert alert-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        @error('passwords.' . $i)
                                            <div class="row mx-0 mb-0 justify-content-center alert alert-danger">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    @endfor
                                    <hr>
                                </div>
                                <input type="submit" class="btn btn-success" value="Confirm New Master Student(s)">
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection