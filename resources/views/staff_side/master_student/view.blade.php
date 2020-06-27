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
                                    <a class="dropdown-item" onclick="get_students({{$year->binusian_year}});" style="cursor: pointer;">
                                        B{{$year->binusian_year}}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">NIM</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Major</th>
                                    <th scope="col">Nationality</th>
                                </tr>
                            </thead>
                            <tbody id="students_data">
                                <?php $i = 0;?>
                                @if (isset($students))
                                    @foreach ($students as $student)
                                        <tr style="cursor: pointer;" onclick="window.location.assign('/staff/student/details/{{$student->user_id}}');">
                                            <th scope="row">{{++$i}}</th>
                                            <td>{{$student->nim}}</td>
                                            <td>{{$student->user->name}}</td>
                                            <td>{{$student->major->name}}</td>
                                            <td>{{$student->nationality}}</td>
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
        function get_students(year){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = "/staff/student/binusian-year/"+ year;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] === false){
                        $("#students_data").empty();

                        var i;
                        var students = response_data['students'];
                        var usersName = response_data['usersName'];
                        var majors = response_data['majors'];
                        for(i = 0; i < students.length; ++i){
                            console.log(i);
                            $("#students_data").append(
                                "<tr style=\"cursor: pointer;\" onclick=\"window.location.assign('/staff/student/details/" + students[i].user_id + "');\">" + 
                                "<th scope=row>" + (i+1) + "</th>" +
                                "<td>" + students[i].nim + "</td>" +
                                "<td>" + usersName.find(element => element.id === students[i].user_id).name + "</td>" +
                                "<td>" + majors.find(element => element.id === students[i].major_id).name + "</td>" +
                                "<td>" + students[i].nationality + "</td>" + 
                                "</tr>"
                            );
                        }
                        $("#binusian_year_dropdown").text('B' + year);
                    }
                }
            });
        }
    </script>
@endpush