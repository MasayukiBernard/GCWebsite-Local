@extends('layouts.app2')

@section('title')
    Master Major
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">Master Major</div>
                    <div class="card-body">
                    <a class="btn btn-success text-light" role="button" href={{route('staff.major.create-page')}}>Add New Major</a>
                    <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Major Name</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach($majors as $major)
                                <tr>
                                    <th>{{$major->id}}</th>
                                    <th>{{$major->name}}</th>
                                    <th>
                                        <a class="btn btn-primary text-light" role="button" href={{route('staff.major.edit-page', ['major' => $major])}}>Edit</a>
                                    </th>
                                    <th>
                                    <button type="button" class="btn btn-danger" onclick="deleteMajor({{$major->id}});">Delete</button>
                                    </th>
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
        function deleteMajor(major_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/major/delete/confirm/' + major_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] == null){
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