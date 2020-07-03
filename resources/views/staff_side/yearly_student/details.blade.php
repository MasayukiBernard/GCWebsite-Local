@extends('layouts.app2')

@section('title')
    {{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}} Semester Students
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">{{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}} Semester Students List</div>
                    <div class="card-body">
                        <a class="btn btn-success" href="{{route('staff.yearly-student.create-page')}}" role="button">Add New Yearly Student</a>
                        <table class="table table-bordered table-hover table-striped m-0">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-6 d-flex p-0 align-items-center">
                                        <div class="col-2 py-3 border-right text-center" scope="col">No.</div>
                                        <div class="col-3 py-3 border-left" scope="col">NIM</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="bg-info rounded-circle py-2 px-3" id="nim_state" onclick="get_students('nim');">
                                                &#8593
                                            </div>
                                        </div>
                                        <div class="col-5 py-3 border-left" scope="col">Name</div>
                                        <div class="col-1 py-2 px-0 d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="name_state" onclick="get_students('name');">
                                                &#8597
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-6 d-flex p-0 align-items-center">
                                        <div class="col-5 py-3" scope="col">Major</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="major_name_state" onclick="get_students('major_name');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-3 py-3 border-left" scope="col">Nominated</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="nominated_state" onclick="get_students('nominated');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-2 py-3 border-left text-center" scope="col">Action</div>
                                    </th>
                                </tr>
                              </thead>
                            <tbody id="yearly_students_data">
                                <?php $i=0;?>
                                @foreach ($yearly_students as $yearly_student)
                                    <tr class="d-flex" style="cursor: pointer;">
                                        <td class="col-6 p-0 d-flex align-items-center" onclick="go_to({{$yearly_student->id}});">
                                            <div class="col-2 py-2 border-right text-center"  scope="row">{{++$i}}</div>
                                            <div class="col-4 py-2 border-left border-right">{{$yearly_student->student->nim}}</div>
                                            <div class="col-6 py-2 border-left">{{$yearly_student->student->user->name}}</div>
                                        </td>
                                        <td class="col-6 p-0 d-flex align-items-center">
                                            <div class="col-6 py-2 border-right" onclick="go_to({{$yearly_student->id}});">{{$yearly_student->student->major->name}}</div>
                                            <div class="col-4 py-2 border-left border-right" onclick="go_to({{$yearly_student->id}});">{{$yearly_student->is_nominated ? "Yes" : "No"}}</div>
                                            <div class="col-2 py-1 px-0 border-left text-center"><button type="button" class="btn btn-sm btn-danger position-relative" onclick="deleteYearlyStudent({{$yearly_student->id}});">Delete</button></div>
                                        </td>
                                    </tr>
                                @endforeach
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

    <!-- Bootstrap's popup window -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div id="popup_body" class="modal-body">
                </div>
                <div id="popup_footer" class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <form id="delete_form" method="POST" action="{{route('staff.yearly-student.delete')}}">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        window.onload = function(){
            $('#loading_bar_container').fadeOut(0);
        };

        const academic_year_id = {{$academic_year->id}};

        var sort_states ={
            nim: 'a',
            name: 'n',
            major_name: 'n',
            nominated: 'n',
        };

        function set_state(column, state){
            var properties = ['nim', 'name', 'major_name', 'nominated'];
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

        function go_to(id){
            window.location.assign('/staff/yearly-student/csa-forms/' + id);
        }

        function get_students(sort_by){
            if(academic_year_id > 0){
                var sort_type = 'a';
                if(sort_states[sort_by] != 'n'){
                    if(sort_states[sort_by] == 'a'){
                        sort_type = 'd';
                        set_state(sort_by, 'd');   
                    }
                    else if(sort_states[sort_by] == 'd'){
                        set_state(sort_by, 'a');
                    }
                }
                else{
                    set_state(sort_by, 'a');
                }
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = "/staff/yearly-student/academic-year/"+ academic_year_id + "/sort-by/" + sort_by + "/" + sort_type;
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
                            var students = response_data['students'];
                            $("#yearly_students_data").empty();
                            $.each(students, function(index, value){
                                $("#yearly_students_data").append(
                                    '<tr class="d-flex" style="cursor: pointer;">' +
                                    '<td class="col-6 p-0 d-flex align-items-center" onclick="go_to(' + students[index].id + ');">' +
                                    '<div class="col-2 py-2 border-right text-center"  scope="row">' + (index+1) + '</div>' +
                                    '<div class="col-4 py-2 border-left border-right">' + students[index].nim + '</div>' +
                                    '<div class="col-6 py-2 border-left">' + students[index].name + '</div>' +
                                    '</td>' +
                                    '<td class="col-6 p-0 d-flex align-items-center">' + 
                                    '<div class="col-6 py-2 border-right" onclick="go_to(' + students[index].id + ');">' + students[index].major_name + '</div>' +
                                    '<div class="col-4 py-2 border-left border-right" onclick="go_to(' + students[index].id + ');">' + (students[index].nominated == true ? 'Yes' : 'No' ) + '</div>' +
                                    '<div class="col-2 py-1 px-0 border-left text-center"><button type="button" class="btn btn-sm btn-danger position-relative" onclick="deleteYearlyStudent(' + students[index].id + ');">Delete</button></div>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
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
        
        function deleteYearlyStudent(yearly_student_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/yearly-student/delete/confirm/' + yearly_student_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] === false){
                        $('#deleteLabel').text('Confirm delete');
                        $('#popup_body').text('Confirm the deletion of "' + response_data['yearly_student_nim'] + ' - ' + response_data['yearly_student_name'] + '" in "' + response_data['academic_year'] + '".');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-danger\" onclick=\"document.getElementById('delete_form').submit();\">Delete</button>");
                    }
                    else{
                        $('#deleteLabel').text('DATA NOT FOUND!!');
                        $('#popup_body').text('Please pick the yearly student to delete from the provided list!!');
                        $('#popup_footer').empty();
                    }
                    $('#confirmDeleteModal').modal();
                }
            });
        }
    </script>
@endpush