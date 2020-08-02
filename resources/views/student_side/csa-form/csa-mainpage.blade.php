@extends('layouts.app2')

@section('title')
    CSA Main Page
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
                    @isset($failed)
                        <div id="failed_notif" class="col-md-12 bg-danger rounded py-2 font-weight-bold h4 m-0">
                            <div class="row">
                                <div class="col-11">
                                    {{$failed}}
                                </div>
                                <div class="col-1 text-right">
                                    <span id="close_notif" style="cursor: pointer;" onclick="close_notif();">X</span>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
                <div class="card">
                    <div class="card-header h2">Pick an Academic Year</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                Academic Year<br>
                                Tahun Ajaran
                            </div>
                            <div class="col-8">
                                <div class="dropdown show">
                                    <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if ($yearly_students_academic_year->count() > 0)
                                            Academic Years
                                        @else
                                            No Data Yet
                                        @endif
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @if ($yearly_students_academic_year->count() > 0)
                                            @foreach ($yearly_students_academic_year as $ysac)
                                        <a class="dropdown-item" style="cursor: pointer;" onclick="set_ysid({{$ysac->id}});">{{$ysac->starting_year}}/{{$ysac->ending_year}} - {{$ysac->odd_semester ? "Odd" : "Even    "}}</a>
                                            @endforeach
                                        @endif

                                        <form id="set_ysid_form" method="POST" action="{{route('student.csa-form.set-ysid')}}">
                                            @csrf
                                            <input type="hidden" id="ys_id" name="ys-id">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }
        
        function set_ysid(ys_id){
            document.getElementById('ys_id').value = ys_id;
            document.getElementById('set_ysid_form').submit();
        }
    </script>
@endpush