@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
                    <div class="card-header h3">Student Requests Approval</div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1 text-center" scope="col">No.</th>
                                    <th class="col-2 text-center" scope="col">Requestor</th>
                                    <th class="col-2 text-center" scope="col">Request Type</th>
                                    <th class="col-5 text-center" scope="col">Description</th>
                                    <th class="col-2 text-center" scope="col">Approval State</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 0;
                                    $request_types = array(
                                        '1' => 'Profile Edit'
                                    );
                                ?>
                                @foreach($student_requests as $request)
                                    <tr class="d-flex">
                                        <td class="col-1 d-flex align-items-center justify-content-center text-center">{{++$i}}</td>
                                        <td class="col-2 d-flex flex-column align-items-center">
                                            <div class="font-weight-bold">
                                                {{$request->name}}
                                            </div>
                                            <div>
                                                {{$request->nim}}
                                            </div>
                                        </td>
                                        <td class="col-2 d-flex align-items-center">{{$request_types[$request->request_type]}}</td>
                                        <td class="col-5 d-flex align-items-center">{{$request->description}}</td>
                                        <td class="col-2 d-flex align-items-center d-flex justify-content-center">
                                            <button type="button" class="btn btn-danger mr-2 " onclick="denyRequest({{$request->id}});">Deny</button>
                                            <button type="button" class="btn btn-success" onclick="approveRequest({{$request->id}});">Approve</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>                         
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="deny_form" method="POST" action="{{route('staff.student-request.deny-request')}}">
        @csrf
    </form>
    <form id="approve_form" method="POST" action="{{route('staff.student-request.approve-request')}}">
        @csrf
    </form>

    <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="approvalLabel"></h5>
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
@endsection

@push('scripts')
    <script>
        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }

        function denyRequest(req_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/student-request/notify/' + req_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] === false){
                        var data = response_data['student_request'];
                        var request_types = ['profile edit'];
                        $('#approvalLabel').text('Confirm Denial');
                        $('#popup_body').text('Confirm the denial of "' + data.nim + ' - ' + data.name + '" ' + request_types[(data.request_type - 1)] + ' request.');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-danger\" onclick=\"document.getElementById('deny_form').submit();\">Deny</button>");
                    }
                    else{
                        $('#approvalLabel').text('DATA NOT FOUND!!');
                        $('#popup_body').text('Please pick the student request to deny from the provided list!!');
                        $('#popup_footer').empty();
                    }
                    $('#approvalModal').modal();
                }
            });
        }

        function approveRequest(req_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/student-request/notify/' + req_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] === false){
                        var data = response_data['student_request'];
                        var request_types = ['profile edit'];
                        $('#approvalLabel').text('Confirm Approval');
                        $('#popup_body').text('Confirm the approval of "' + data.nim + ' - ' + data.name + '" ' + request_types[(data.request_type - 1)] + ' request.');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-success\" onclick=\"document.getElementById('approve_form').submit();\">Approve</button>");
                    }
                    else{
                        $('#approvalLabel').text('DATA NOT FOUND!!');
                        $('#popup_body').text('Please pick the student request to approve from the provided list!!');
                        $('#popup_footer').empty();
                    }
                    $('#approvalModal').modal();
                }
            });
        }
    </script>
@endpush