@extends('layouts.app2')

@section('title')
    Master Major
@endsection

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
                </div>
                <div class="card">
                    <div class="card-header h2">Master Major</div>
                    <div class="card-body">
                        <a class="btn btn-success text-light" role="button" href={{route('staff.major.create-page')}}>Add New Major</a>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1 text-center" scope="col">No.</th>
                                    <th class="col-9" scope="col">Major Name</th>
                                    <th class="col-2 text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0;?>
                                @foreach($majors as $major)
                                <tr class="d-flex">
                                    <td class="col-1 d-flex align-items-center justify-content-center text-center">{{++$i}}</td>
                                    <td class="col-9 d-flex align-items-center">{{$major->name}}</td>
                                    <td class="col-2 d-flex align-items-center d-flex justify-content-center">
                                        <a class="btn btn-primary text-light mr-2" role="button" href={{route('staff.major.edit-page', ['major' => $major])}}>Edit</a>
                                        <button type="button" class="btn btn-danger" onclick="deleteMajor({{$major->id}});">Delete</button>
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

    <form id="delete_form" method="POST" action="{{route('staff.major.delete')}}">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        function close_notif(){
            $('#notification_bar').fadeOut(500);
        }

        function deleteMajor(major_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/major/delete/confirm/' + major_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] === false){
                        var data = response_data['referred_major'];
                        $('#deleteLabel').text('Confirm delete');
                        $('#popup_body').text('Confirm the deletion of "' + data.name+ '"');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-danger\" onclick=\"document.getElementById('delete_form').submit();\">Delete</button>");
                    }
                    else{
                        $('#deleteLabel').text('DATA NOT FOUND!!');
                        $('#popup_body').text('Please pick the major to delete from the provided list!!');
                        $('#popup_footer').empty();
                    }
                    $('#confirmDeleteModal').modal();
                }
            });
        }
    </script>
@endpush