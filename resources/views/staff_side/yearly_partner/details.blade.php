@extends('layouts.app2')

@section('title')
    {{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
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
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1 text-center" scope="col">#</th>
                                    <th class="col-4 border-right-0" scope="col">University Name</th>
                                    <th class="col-1 p-0 border-left-0 text-center" scope="col">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 m-1 bg-info rounded-circle" style="cursor: pointer;" id="name_state" onclick="get_partners('name');">&#8597</div>
                                        </div>
                                    </th>
                                    <th class="col-4 border-right-0" scope="col">Location</th>
                                    <th class="col-1 p-0 border-left-0 text-center" scope="col">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="col-6 py-2 my-1 mx-1 bg-info rounded-circle" style="cursor: pointer;" id="location_state" onclick="get_partners('location');">&#8597</div>
                                        </div>
                                    </th>
                                    <th class="col-1 text-center" scope="col">Action</th>
                                </tr>
                              </thead>
                            <tbody id="yearly_partner_data">
                            </tbody>
                        </table>
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
            major: 'n'
        };

        function set_major(id){
            major_id = id;
            sort_states.name = 'n';
            sort_states.location = 'n';
            sort_states.min_gpa = 'n';
            sort_states.eng_requirement = 'n';
            sort_states.short_detail = 'n';
            get_partners('name');
        }

        function set_state(column, state){
            var properties = ['name', 'location'];
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

                $("#yearly_partner_data").empty();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = "/staff/yearly-partner/list/"+ academic_year_id + "/major/" + major_id + "/sort-by/" + sort_by + "/" + sort_type;
                $.ajax({
                    type: 'POST',
                    url: targetURL,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function(response_data){
                        if(response_data['failed'] === false){
                            var data = response_data['yearly-partners'];
                            $.each(data, function(index, value){
                                $("#yearly_partner_data").append(
                                    "<tr class=\"d-flex\">" + 
                                    "<th class=\"col-1\" scope=row onclick=\"go_to(" + data[index].id + ");\">" + (index+1) + "</th>" +
                                    "<td class=\"col-5\" colspan=\"2\" style=\"cursor: pointer;\" onclick=\"go_to(" + data[index].id + ");\">"   + data[index].name + "</td>" + 
                                    "<td class=\"col-5\" colspan=\"2\" style=\"cursor: pointer;\" onclick=\"go_to(" + data[index].id + ");\">" + data[index].location + "</td>" +
                                    "<td class=\"col-1\"><button type=\"button\" class=\"btn btn-danger\"  onclick=\"deleteYearlyPartner(" + data[index].id + ");\">Delete</button></td>" +
                                    "</tr>"
                                );
                            });
                        }
                        $("#major_name_dropdown").text($("#major_" + major_id).text());
                    }
                });
            }
        }
    </script>
@endpush