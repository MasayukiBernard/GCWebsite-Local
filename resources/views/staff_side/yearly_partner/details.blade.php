@extends('layouts.app2')

@section('title')
    {{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}}
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
                    <div class="card-header h2">{{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}} Semester Partners List</div>
                    <div class="card-body">
                        List of yearly partners for students majoring in:<br>
                        <div class="btn-group">
                            <button type="button" id="major_name_dropdown" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if ($all_majors->count() > 0)
                                    Major Name
                                @else
                                    No major data yet!!
                                @endif
                            </button>
                            <div class="dropdown-menu">
                                @foreach($all_majors as $major)
                                    <a id="major_{{$major->id}}" class="dropdown-item" style="cursor: pointer"
                                        onclick="set_major({{$major->id}});">
                                        {{$major->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <a class="btn btn-success" href="{{route('staff.yearly-partner.create-page')}}" role="button">Add New Yearly Partner</a>
                        <table class="table table-bordered table-hover table-striped m-0">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1 text-center" scope="col">#</th>
                                    <th class="col-4 border-right-0" scope="col">University Name</th>
                                    <th class="col-1 p-0 border-left-0 text-center" scope="col">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 m-1 bg-info rounded-circle" style="cursor: pointer;" id="name_state" onclick="get_partners('name');">&#8597</div>
                                        </div>
                                    </th>
                                    <th class="col-2 border-right-0" scope="col">Location</th>
                                    <th class="col-1 p-0 border-left-0 text-center" scope="col">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 my-1 mx-1 bg-info rounded-circle" style="cursor: pointer;" id="location_state" onclick="get_partners('location');">&#8597</div>
                                        </div>
                                    </th>
                                    <th class="col-1 border-right-0" scope="col">Quota</th>
                                    <th class="col-1 p-0 border-left-0 text-center" scope="col">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 my-1 mx-1 bg-info rounded-circle" style="cursor: pointer;" id="quota_state" onclick="get_partners('quota');">&#8597</div>
                                        </div>
                                    </th>
                                    <th class="col-1 text-center" scope="col">Action</th>
                                </tr>
                              </thead>
                            <tbody id="yearly_partner_data">
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
                    Confirm the deletion of <b>'<span id="yearly_partner"></span>'</b> in <b>'<span id="academic_year"></span>'</b>
                </div>
                <div id="popup_footer" class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <form id="delete_form" method="POST" action="{{route('staff.yearly-partner.delete')}}">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        window.onload = function(){
            $('#loading_bar_container').fadeOut(0);
        };

        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }

        const academic_year_id = {{$academic_year->id}};
        
        function deleteYearlyPartner(partner_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/yearly-partner/delete/confirm/academic-year/' + academic_year_id + '/partner/' + partner_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] == null){
                        $('#deleteLabel').text('Confirm delete');
                        $('#popup_body').text('Confirm the deletion of "' + response_data['yearly_partner_name'] + '" in "' + response_data['academic_year'] + '".');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-danger\" onclick=\"document.getElementById('delete_form').submit();\">Delete</button>");
                    }
                    else{
                        $('#deleteLabel').text('DATA NOT FOUND!!');
                        $('#popup_body').text('Please pick the yearly partner to delete from the provided list!!');
                        $('#popup_footer').empty();
                    }
                    $('#confirmDeleteModal').modal();
                }
            });
        }

        var major_id = 0;

        var sort_states ={
            name: 'n',
            location: 'n',
            quota:'n',
            major: 'n'
        };

        function set_major(id){
            major_id = id;
            sort_states.name = 'n';
            sort_states.location = 'n';
            sort_states.min_gpa = 'n';
            sort_states.quota = 'n';
            get_partners('name');
        }

        function set_state(column, state){
            var properties = ['name', 'location', 'quota'];
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
            window.location.assign('/staff/partner/details/' + id);
        }

        function get_partners(sort_by){
            $("#yearly_partner_data").empty();
            if(major_id > 0){
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
                var targetURL = "/staff/yearly-partner/list/"+ academic_year_id + "/major/" + major_id + "/sort-by/" + sort_by + "/" + sort_type;
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
                            var data = response_data['yearly-partners'];
                            $.each(data, function(index, value){
                                $("#yearly_partner_data").append(
                                    "<tr class=\"d-flex\">" + 
                                    "<th class=\"col-1 text-center\" scope=row onclick=\"go_to(" + data[index].id + ");\">" + (index+1) + "</th>" +
                                    "<td class=\"col-5\" colspan=\"2\" style=\"cursor: pointer;\" onclick=\"go_to(" + data[index].id + ");\">"   + data[index].name + "</td>" + 
                                    "<td class=\"col-3\" colspan=\"2\" style=\"cursor: pointer;\" onclick=\"go_to(" + data[index].id + ");\">" + data[index].location + "</td>" +
                                    "<td class=\"col-2\" colspan=\"2\" style=\"cursor: pointer;\" onclick=\"go_to(" + data[index].id + ");\">" + data[index].quota + "</td>" +
                                    "<td class=\"col-1 text-center\"><button type=\"button\" class=\"btn btn-danger\"  onclick=\"deleteYearlyPartner(" + data[index].id + ");\">Delete</button></td>" +
                                    "</tr>"
                                );
                            });
                        }
                        $("#major_name_dropdown").text($("#major_" + major_id).text());
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