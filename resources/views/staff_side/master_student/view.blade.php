@extends('layouts.app2')

@section('title')
    Master Student
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
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

                        <table class="table table-striped table-bordered table-hover">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var year = {{isset($binusian_years) ? $binusian_years->first()->binusian_year : '0'}};
        
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
                    }
                });
            }
        }
    </script>
@endpush