@extends('layouts.app2')

@section('title')
    Master Student
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
                    <div class="card-header h2">Master Student</div>
                    <div class="card-body">
                        <a class="btn btn-success text-light" role="button" href="{{route('staff.student.create-page')}}">Add New Student(s)</a>
                        
                        <br><br>List of all students for students in Binusian Year:<br>
                        <div class="btn-group">
                            <button type="button" id="binusian_year_dropdown" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($binusian_years->count() > 0)
                                    B{{$binusian_years->first()->binusian_year}}
                                @else
                                    No Binusian Year Data Yet
                                @endif
                            </button>
                            <div class="dropdown-menu">
                                @foreach($binusian_years as $year)
                                    <a class="dropdown-item" onclick="set_year({{$year->binusian_year}});" style="cursor: pointer;">
                                        B{{$year->binusian_year}}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover m-0">
                            <thead>
                                <tr class="d-flex">
                                    <th scope="col" class="col-1 text-center">No.</th>
                                    <th scope="col" class="col-1 border-right-0">NIM</th>
                                    <th scope="col" class="col-1 p-0 border-left-0">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 m-1 bg-info rounded-circle text-center" style="cursor: pointer;" id="nim_state" onclick="get_students('nim');">&#8593</div>
                                        </div>
                                    </th>
                                    <th scope="col" class="col-2 border-right-0">Name</th>
                                    <th scope="col" class="col-1 p-0 border-left-0">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 m-1 rounded-circle text-center" style="cursor: pointer;" id="name_state" onclick="get_students('name');">&#8597</div>
                                        </div>
                                    </th>
                                    <th scope="col" class="col-2 border-right-0">Major</th>
                                    <th scope="col" class="col-1 p-0 border-left-0">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 m-1 rounded-circle text-center" style="cursor: pointer;" id="major_name_state" onclick="get_students('major_name');">&#8597</div>
                                        </div>
                                    </th>
                                    <th scope="col" class="col-2 border-right-0">Nationality</th>
                                    <th scope="col" class="col-1 p-0 border-left-0">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 m-1 rounded-circle text-center" style="cursor: pointer;" id="nationality_state" onclick="get_students('nationality');">&#8597</div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="students_data">
                                <?php $i = 0;?>
                                @if (isset($students))
                                    @foreach ($students as $student)
                                        <tr class="d-flex" style="cursor: pointer;" onclick="window.location.assign('/staff/student/details/{{$student->user_id}}');">
                                            <th class="col-1 text-center" scope="row">{{++$i}}</th>
                                            <td class="col-2">{{$student->nim}}</td>
                                            <td class="col-3">{{$student->user->name}}</td>
                                            <td class="col-3">{{$student->major->name}}</td>
                                            <td class="col-3">{{$student->nationality}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="row" id="loading_bar_container">
                            <div class="col-12">
                                <div class="row" style="position: relative;">
                                    <div class="col-6 p-0 text-right">Loading</div>
                                    <div id="dots" class="col-6 p-0"></div>
                                </div>
                                <div class="progress mt-n4" style="height: 25px;">
                                    <div id="loading_bar1" class="progress-bar progress-bar-striped progress-bar-animated bg-success rounded" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%; margin-left: -50%;"></div>
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
        window.onload = function(){
            $('#loading_bar_container').fadeOut(0);
        };
        
        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }

        var year = {{$binusian_years->first() !== null ? $binusian_years->first()->binusian_year : '0'}};
        
        var sort_states ={
            nim: 'a',
            name: 'n',
            major_name: 'n',
            nationality: 'n'
        };

        function set_year(binusian_year){
            year = binusian_year;
            sort_states['nim'] = 'n';
            sort_states['name'] = 'n';
            sort_states['major_name'] = 'n';
            sort_states['nationality'] = 'n';
            get_students('nim', 'a');
        }

        function set_state(column, state){
            var properties = ['nim', 'name', 'major_name', 'nationality'];
            var states = ['a', 'd'];
            if(properties.includes(column) && states.includes(state)){
                for(var i = 0; i < 5; ++i){
                    if(column == properties[i]){
                        sort_states[column] = state;
                        if(state == 'a'){
                            $('#' + properties[i] + '_state').html('&#8593');
                        }
                        else if(state == 'd'){
                            $('#' + properties[i] + '_state').html('&#8595');
                        }
                        $('#' + properties[i] + '_state').addClass('bg-info');
                        continue;
                    }
                    sort_states[properties[i]] = 'n';
                    $('#' + properties[i] + '_state').removeClass('bg-info');
                    $('#' + properties[i] + '_state').html('&#8597');
                }
            }
        }

        function get_students(field){
            if(year > 0){
                var sort_type = 'a';
                if(sort_states[field] != 'n'){
                    if(sort_states[field] == 'a'){
                        sort_type = 'd';
                        set_state(field, 'd');   
                    }
                    else if(sort_states[field] == 'd'){
                        set_state(field, 'a');
                    }
                }
                else{
                    set_state(field, 'a');
                }
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = "/staff/student/binusian-year/"+ year + "/sort-by/" + field + "/" + sort_type;
                $.ajax({
                    type: 'POST',
                    url: targetURL,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    beforeSend: function(){
                        animate_loading();
                    },
                    success: function(response_data){
                        if(response_data['failed'] === false){
                            $("#students_data").empty();
                            var students = response_data['students'];

                            $.each(students, function(index, value){
                                $("#students_data").append(
                                    "<tr class=\"d-flex\" style=\"cursor: pointer;\" onclick=\"window.location.assign('/staff/student/details/" + students[index].user_id + "');\">" + 
                                    "<th class=\"col-1 text-center\" scope=row>" + (index+1) + "</th>" +
                                    "<td class=\"col-2\">" + students[index].nim + "</td>" +
                                    "<td class=\"col-3\">" + students[index].name + "</td>" +
                                    "<td class=\"col-3\">" + students[index].major_name + "</td>" +
                                    "<td class=\"col-3\">" + students[index].nationality + "</td>" + 
                                    "</tr>"
                                );
                            });
                            $("#binusian_year_dropdown").text('B' + year);
                        }
                    },
                    complete: function(){
                        clearInterval(bar_interval);
                        clearInterval(dots_interval);
                        $('#loading_bar_container').fadeOut(750);
                    }
                });
            }
        }

        var bar_interval, dots_interval, freq = 0;
        function animate_loading(){
            $('#loading_bar_container').fadeIn(0);
            ++freq;
            if(freq == 1){
                $('#loading_bar1').animate({'margin-left': '+=125%'}, 2500);
                $('#loading_bar1').animate({'margin-left': '-=100%'}, 2000);
            }
            run_1();
            dots_interval = setInterval(run_2, 1300);
            bar_interval = setInterval(run_1, 4000);
            function run_1(){
                $('#loading_bar1').animate({'margin-left': '+=100%'}, 2000);
                $('#loading_bar1').animate({'margin-left': '-=100%'}, 2000);
                $('#dots').empty();
            }
            function run_2(){
                $('#dots').append(' .');
            }
        }
    </script>
@endpush