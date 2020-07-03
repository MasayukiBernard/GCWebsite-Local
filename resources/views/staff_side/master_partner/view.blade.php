@extends('layouts.app2')

@section('title')
    Master Partner
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">Master Partner</div>
                    <div class="card-body">

                        List of all partners for students majoring in:<br>
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
                        <a class="btn btn-success text-light" role="button" href={{route('staff.partner.create-page')}}>Add New Partner</a>

                        <table class="table table-striped table-bordered table-hover m-0">
                            <thead>
                                <tr class="d-flex justify-content-center">
                                    <th class="d-flex col-6 p-0">
                                        <div class="col-1 py-3 px-0 text-center border-right">No.</div>
                                        <div class="col-5 py-3 border-left">University Name</div>
                                        <div class="col-1 border-right px-0 d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="bg-info rounded-circle py-2 px-3" id="name_state" onclick="get_partners('name');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-4 py-3 border-left">Location</div>
                                        <div class="col-1 border-right px-0 d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="bg-info rounded-circle py-2 px-3" id="location_state" onclick="get_partners('location');">
                                                &#8597
                                            </div>
                                        </div>
                                    </th>
                                    <th class="d-flex col-6 p-0 border-left-0">
                                        <div class="col-4 py-3">Minimum GPA</div>
                                        <div class="col-1 border-right px-0 d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="bg-info rounded-circle py-2 px-3" id="min_gpa_state" onclick="get_partners('min_gpa');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-6 py-3 border-left">English Proficiency Requirement</div>
                                        <div class="col-1 border-right px-0 d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="bg-info rounded-circle py-2 px-3" id="eng_requirement_state" onclick="get_partners('eng_requirement');">
                                                &#8597
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="partner_tBody">
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

        var major_id = 0;
        var sort_states ={
            name: 'n',
            location: 'n',
            min_gpa: 'n',
            eng_requirement: 'n',
        };

        function set_state(column, state){
            var properties = ['name', 'location', 'min_gpa', 'eng_requirement', 'short_detail'];
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

        function set_major(id){
            major_id = id;
            sort_states.name = 'n';
            sort_states.location = 'n';
            sort_states.min_gpa = 'n';
            sort_states.eng_requirement = 'n';
            sort_states.short_detail = 'n';
            get_partners('name');
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
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = "/staff/partner/major/"+ major_id + "/sort-by/" + sort_by + "/" + sort_type;
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
                            var data = response_data['major_partners'];
                            $("#partner_tBody").empty();
                            $.each(data, function(index, value){
                                $("#partner_tBody").append(
                                    '<tr class="d-flex justify-content-center" onclick="go_to(' + data[index].id + ');">' + 
                                    '<td style="cursor: pointer;" class="d-flex col-6 p-0">' +
                                    '<div class="col-1 py-2 px-0 text-center border-right">' + (index+1) + '</div>' +
                                    '<div class="col-6 py-2 border-left border-right">' + data[index].name + '</div>' +
                                    '<div class="col-5 py-2 border-left">' + data[index].location + '</div>' +
                                    '</td>' + 
                                    '<td style="cursor: pointer;" class="d-flex col-6 p-0">' +
                                    '<div class="col-5 py-2 border-right">' + data[index].min_gpa + '</div>' +
                                    '<div class="col-7 py-2 border-left border-right">' + data[index].eng_requirement + '</div>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
                            $("#major_name_dropdown").text($("#major_" + major_id).text());
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

        function go_to(partner_id){
            window.location.assign('/staff/partner/details/' + partner_id);
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