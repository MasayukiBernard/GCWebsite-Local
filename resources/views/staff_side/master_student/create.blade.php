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
                                        <div class="col-md-8 p-2 border rounded bg-secondary text-light">
                                            <div class="row px-2">
                                                <div class="col-md-10 text-center">PASSWORD</div>
                                                <div class="col-md-2 text-right">
                                                    <button type="button" class="btn btn-primary btn-sm p-0 px-1" onclick="show_autoFillModal();">Auto Fill</button>
                                                </div>
                                            </div>
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

    <div class="modal fade" id="autoFillModal" tabindex="-1" role="dialog" aria-labelledby="autoFillModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="autoFillModalLabel">Autofill Passwords</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="autofill_value-name" class="col-form-label">Autofill the passwords with the below string:</label>
                        <input type="text" class="form-control" id="autofill_value">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="autoFillModal();">Confirm</button>
                </div>
            </div>
        </div>
      </div>
@endsection

@push('scripts')
    <script>
        function show_autoFillModal(){
            document.getElementById('autofill_value').value = '';
            $('#autoFillModal').modal();
        }

        function autoFillModal(){
            var input = document.getElementById('autofill_value').value;
            if(input.length != 0){
                var collection = document.getElementsByName("passwords[]");
                for(var i = 0; i < collection.length; ++i){
                    collection[i].value = input;
                }
            }
            $('#autoFillModal').modal('hide');
        }
    </script>
@endpush