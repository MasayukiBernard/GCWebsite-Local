@extends('staff_side.crud_templates.create')

@section('entity')
    Yearly Student
@endsection

@section('form-action')
    {{route('staff.yearly-student.create-confirm')}}
@endsection

@section('form-inputs')
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="academic_year_selection">Academic Year</label>
        </div>
        <select class="custom-select @error('academic_year') is-invalid @enderror" id="academic_year_selection" name="academic-year" onchange="get_students(document.getElementById('academic_year_selection').value, document.getElementById('binusian_year_selection').value);">
            <option value=" ">Choose...</option>
            @foreach ($academic_years as $year)
                <option {{session('latest_yearly_student_year_id') != null ? (session('latest_yearly_student_year_id') == $year->id ? "selected" : "") : (old('academic_year') == $year-> id ? "selected" : "")}} value={{$year->id}}>
                    {{$year->starting_year}}/{{$year->ending_year}} - {{$year->odd_semester ? "Odd" : "Even"}}
                </option>
            @endforeach
        </select>
    </div>
    @error('academic-year')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="partner_selection">Binusian Year</label>
        </div>
        <select class="custom-select @error('binusian-year') is-invalid @enderror" id="binusian_year_selection" name="binusian-year" onchange="get_students(document.getElementById('academic_year_selection').value, document.getElementById('binusian_year_selection').value);">
            <option value=" ">
                @if ($binusian_years->count() == 0)
                    No Student Data Yet
                @else
                    Choose...
                @endif
            </option>
            @foreach ($binusian_years as $binusian_year)
                <option value="{{$binusian_year->binusian_year}}">{{$binusian_year->binusian_year}}</option>
            @endforeach
        </select>
    </div>
    @error('binusian-year')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <span id="pre_students_query_alert" class="text-danger">NOTE: Pick a binusian year!!</span>
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header text-center h5">
                    Available Students
                </div>
                <ul id="available_students_list" class="list-group list-group-flush">
                    <li class="list-group-item">No Data Yet</li>
                </ul>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header text-center h5">
                    Enroll Students to Current Year
                </div>
                <ul id="enrolling_students_list" class="list-group list-group-flush">
                    <li class="list-group-item">No Data Yet</li>
                </ul>
            </div>
        </div>
    </div>
    @error('enrolling-students')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            Note: "Left Click" once to add or remove students from respective list.
        </div>
    </div>
@endsection

@section('confirm-value')
Yearly Student
@endsection

@push('scripts')
    <script>
        // Create 2 tables side by side, one for available students, one for students to be added to current year
        // concat their nims with ',' separator
        // explode the array by ','
        var students, users;
        var enrolling_students = [];

        function get_students(academic_year_id, binusian_year){
            $('#available_students_list').empty();
            $('#enrolling_students_list').empty();
            $('#enrolling_students_list').append("<li class=\"list-group-item\"> No Data Yet </li>");
            if(academic_year_id != " " && binusian_year != " "){
                $('#pre_students_query_alert').empty();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = '/staff/yearly-student/academic-year/' + academic_year_id + '/students/' + binusian_year;
                $.ajax({
                    type: 'POST',
                    url: targetURL,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function(response_data){
                        if(response_data['failed'] == false){
                            enrolling_students = [];
                            students = response_data['students'];
                            users = response_data['students_users'];
                            $('#available_students_list').empty();
                            if(jQuery.isEmptyObject(students) == true){
                                $('#available_students_list').append("<li class=\"list-group-item\">" + "All students have been added!!" + "</li>");
                            }
                            else{
                                for(var i = 0; i < students.length; ++i){
                                    $('#available_students_list').append(
                                    "<li id=\"" + students[i].nim + "\"class=\"list-group-item\" style=\"cursor: pointer;\" onclick=\"add_to_enroll(" + students[i].user_id + ");\">" + students[i].nim + " - " + users.find(element => element.id === students[i].user_id).name + "</li>"
                                );
                            }
                            }
                        }
                    }
                });
            }
            else{
                $('#available_students_list').append("<li class=\"list-group-item\"> No Data Yet </li>");
                if (academic_year_id == " " && binusian_year == " "){
                    $('#pre_students_query_alert').text("Note: Pick an academic year and a binusian year!!");
                }
                else if(academic_year_id == " "){
                    $('#pre_students_query_alert').text("Note: Pick an academic year!!");
                }
                else if (binusian_year = " "){
                    $('#pre_students_query_alert').text("Note: Pick a binusian year!!");
                }
            }
        }

        function add_to_enroll(user_id){
            $('.enrolling_students').remove();

            var student_index = students.findIndex(i => i.user_id  == user_id);
            if(student_index > -1){
                var temp_student = students[student_index];
                $('#' + students[student_index].nim).remove();
                students.splice(student_index, 1);

                if(students.length == 0){
                    $('#available_students_list').append("<li class=\"list-group-item\"> No Data Yet </li>");
                }

                enrolling_students.push(temp_student);
                enrolling_students.sort(function(a, b){
                    if (a.nim < b.nim) {return -1;}
                    if (a.nim > b.nim) {return 1;}
                    return 0;
                });

                $('#enrolling_students_list').empty();
                for(var i = 0; i < enrolling_students.length; ++i){
                    $('form').append("<input type=\"hidden\" class=\"enrolling_students\" name=\"enrolling-students[]\" value=\"" + enrolling_students[i].nim + "\">");
                    $('#enrolling_students_list').append(
                    "<li id=\"" + enrolling_students[i].nim + "\" class=\"list-group-item\" style=\"cursor: pointer;\" onclick=\"cancel_add(" + enrolling_students[i].user_id +  ");\">" + enrolling_students[i].nim + " - " + users.find(element => element.id === enrolling_students[i].user_id).name + "</li>");
                }
            }
        }

        function cancel_add(user_id){
            var student_index = enrolling_students.findIndex(i => i.user_id  == user_id);
            if(student_index > -1){
                var temp_student = enrolling_students[student_index];
                $('#' + enrolling_students[student_index].nim).remove();
                enrolling_students.splice(student_index, 1);
                
                $('.enrolling_students').remove();
                for(var i = 0; i < enrolling_students.length; ++i){
                    $('form').append("<input type=\"hidden\" id=\"enrolling_" + enrolling_students[i].nim + "\" class=\"enrolling_students\" name=\"enrolling-students[]\" value=\"" + enrolling_students[i].nim + "\">");
                }
                
                if(enrolling_students.length == 0){
                    $('#enrolling_students_list').append("<li class=\"list-group-item\"> No Data Yet </li>");
                }

                students.push(temp_student);
                students.sort(function(a, b){
                    if (a.nim < b.nim) {return -1;}
                    if (a.nim > b.nim) {return 1;}
                    return 0;
                });

                $('#available_students_list').empty();
                for(var i = 0; i < students.length; ++i){
                    $('#available_students_list').append(
                    "<li id=\"" + students[i].nim + "\" class=\"list-group-item\" style=\"cursor: pointer;\" onclick=\"add_to_enroll(" + students[i].user_id + ");\"" + ">" + students[i].nim + " - " + users.find(element => element.id === students[i].user_id).name + "</li>");
                }
            }
        }
    </script>
@endpush