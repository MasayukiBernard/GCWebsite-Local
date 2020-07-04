@extends('layouts.app2')

@section('title')
    CSA Application Forms
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
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
                    <div class="card-header h2">CSA Application Forms</div>
                    <div class="card-body">
                        <span class="text-danger" id="alert"></span>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="align-middle" scope="row">Academic Year</th>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="academicYearDropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if ($academic_years->count() > 0)
                                                    Academic Year
                                                @else
                                                    No academic year data yet!!
                                                @endif
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="academicYearDropdownMenuButton">
                                                @foreach ($academic_years as $year)
                                                    <a id="academic_year_{{$year->id}}" onclick="set_year_id({{$year->id}});" style="cursor: pointer;" class="dropdown-item">{{$year->starting_year}}/{{$year->ending_year}} - {{$year->odd_semester ? "Odd" : "Even"}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="align-middle">Major Name</th>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle xml-3" type="button" id="majorDropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if ($majors->count() > 0)
                                                    Major Name
                                                @else
                                                    No major data yet!!
                                                @endif
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="majorDropdownMenuButton">
                                                @foreach ($majors as $major)
                                                    <a id="major_{{$major->id}}" onclick="set_major_id({{$major->id}});" style="cursor: pointer;" class="dropdown-item">{{$major->name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-center">
                                        @if ($academic_years->count() > 0 && $majors->count() > 0)
                                            <a onclick="get_view();" class="btn btn-success btn-lg text-light px-5" role="button">
                                                Search
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var academic_year_id = 0, major_id = 0;

        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }
        
        function set_year_id(id){
            academic_year_id = id;
            $('#academicYearDropdownMenuButton').text($('#academic_year_' + academic_year_id).text());
        }

        function set_major_id(id){
            major_id = id;
            $('#majorDropdownMenuButton').text($('#major_' + major_id).text());
        }

        function get_view(){
            if(Number.isInteger(academic_year_id) && Number.isInteger(major_id) && academic_year_id > 0 && major_id > 0){
                window.location.assign("/staff/csa-forms/academic-year/" + academic_year_id + "/major/" +  major_id);
            }
            else{
                if(!Number.isInteger(academic_year_id) || !Number.isInteger(major_id)){
                    $('#alert').text("Note: Input Error!!");
                }
                else if(academic_year_id <= 0){
                    $('#alert').text("Note: Pick an academic year from the provided list!");
                }
                else if(major_id <= 0){
                    $('#alert').text("Note: Pick a major from the provided list!");
                }
            }
        }
    </script>
@endpush