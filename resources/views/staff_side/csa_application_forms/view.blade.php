@extends('layouts.app2')

@section('title')
    CSA Application Forms
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h2>CSA Application Forms</h2>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td>Academic Year</td>
                                <td>
                                    : {{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}}
                                </td>
                            </tr>
                            <tr>
                                <td>Major</td>
                                <td>: {{$major->name}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-striped m-0">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-6 d-flex p-0 align-items-center">
                                        <div class="col-2 py-3 border-right text-center" scope="col">No.</div>
                                        <div class="col-3 py-3 border-left" scope="col">NIM</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="nim_state" onclick="get_forms('nim');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-5 py-3 border-left" scope="col">Name</div>
                                        <div class="col-1 py-2 px-0 d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="name_state" onclick="get_forms('name');">
                                                &#8597
                                            </div>
                                        </div>
                                    </th>
                                    <th class="col-6 d-flex p-0 align-items-center">
                                        <div class="col-3 py-3" scope="col">Form Status</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="form_status_state" onclick="get_forms('form_status');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-3 py-3 pr-1 border-left" scope="col">Created At</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="rounded-circle py-2 px-3" id="created_at_state" onclick="get_forms('created_at');">
                                                &#8597
                                            </div>
                                        </div>
                                        <div class="col-3 py-1 border-left text-center" scope="col">Nomination Status</div>
                                        <div class="col-1 py-2 px-0 border-right d-flex justify-content-center align-items-center " style="cursor: pointer;">
                                            <div class="bg-info rounded-circle py-2 px-3" id="nomination_status_state" onclick="get_forms('nomination_status');">
                                                &#8593
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="csa_forms_data">
                                <?php $i = 0;?>
                                @foreach ($yearly_students as $yearly_student)
                                    @if ($yearly_student->csa_form != null)
                                        <tr class="d-flex" style="cursor: pointer;" onclick="window.location.assign('/staff/csa-forms/details/{{$yearly_student->csa_form->id}}');">
                                            <td class="col-6 p-0 d-flex align-items-center">
                                                <div class="col-2 py-2 border-right text-center"  scope="row">{{++$i}}</div>
                                                <div class="col-4 py-2 border-left border-right">{{$yearly_student->student->nim}}</div>
                                                <div class="col-6 py-2 border-left">{{$yearly_student->student->user->name}}</div>
                                            </td>
                                            <td class="col-6 p-0 d-flex align-items-center">
                                                <div class="col-4 py-2 border-right">{{$yearly_student->csa_form->is_submitted ? "Submitted" : "On Process"}}</div>
                                                <div class="col-4 py-2 border-left border-right">{{$yearly_student->csa_form->created_at == null ? "Null" : $yearly_student->csa_form->created_at}}</div>
                                                <div class="col-4 py-2 px-0 border-left text-center">{{$yearly_student->is_nominated ? "Nominated" : "Not Yet Nominated"}}</div>
                                            </td>
                                        </tr>
                                    @endif
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
@endsection

@push('scripts')
    <script>
        window.onload = function(){
            $('#loading_bar_container').fadeOut(0);
        };

        const academic_year_id = {{$academic_year->id}};
        const major_id = {{$major->id}};

        var sort_states ={
            nim: 'n',
            name: 'n',
            form_status: 'n',
            created_at: 'n',
            nomination_status: 'a',
        };

        function set_state(column, state){
            var properties = ['nim', 'name', 'form_status', 'created_at', 'nomination_status'];
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

        function get_forms(sort_by){
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
                var targetURL = "/staff/csa-forms/academic-year/"+ academic_year_id + "/major/" + major_id + "/sort-by/" + sort_by + "/" + sort_type;
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
                            var csa_forms = response_data['csa_forms'];
                            $("#csa_forms_data").empty();
                            $.each(csa_forms, function(index, value){
                                $("#csa_forms_data").append(
                                    '<tr class="d-flex" style="cursor: pointer;" onclick="window.location.assign(\'/staff/csa-forms/details/' + csa_forms[index].id + '\');">' +
                                    '<td class="col-6 p-0 d-flex align-items-center">' +
                                    '<div class="col-2 py-2 border-right text-center"  scope="row">' + (index+1) + '</div>' +
                                    '<div class="col-4 py-2 border-left border-right">' + csa_forms[index].nim + '</div>' + 
                                    '<div class="col-6 py-2 border-left">' + csa_forms[index].name + '</div>' +
                                    '</td>' +
                                    '<td class="col-6 p-0 d-flex align-items-center">' + 
                                    '<div class="col-4 py-2 border-right">' + (csa_forms[index].form_status ? "Submitted" : "On Process") + '</div>' + 
                                    '<div class="col-4 py-2 border-left border-right">' + (csa_forms[index].created_at == null ? "Null" : csa_forms[index].created_at) + '</div>' +
                                    '<div class="col-4 py-2 px-0 border-left text-center">' + (csa_forms[index].nomination_status ? "Nominated" : "Not Yet Nominated") + '</div>' +
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
    </script>
@endpush

