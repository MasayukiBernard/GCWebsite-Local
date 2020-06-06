@extends('layouts.app2')

@section('title')
    Academic Year
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">Academic Year</div>
                    <div class="card-body">
                        <a class="btn btn-success text-light" role="button" href="{{route('staff.academic-year.create-page')}}">Add New Academic Year</a>

                        <?php $i = 0;?>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Starting Year</th>
                                    <th scope="col">/</th>
                                    <th scope="col">Ending Year</th>
                                    <th scope="col">Semester Type</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academic_years as $year)
                                    <tr>
                                        <th scope="row">{{++$i}}</th>
                                        <td>{{$year->starting_year}}</td>
                                        <td></td>
                                        <td>{{$year->ending_year}}</td>
                                        <td>{{$year->odd_semester ? "Odd" : "Even"}}</td>
                                        <td><button type="button" class="btn btn-danger" onclick="deleteAcademicYear({{$year->id}});">Delete</button></td>
                                    </tr>
                                @endforeach
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
                </div>
                <div id="popup_footer" class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <form id="delete_form" method="POST" action="{{route('staff.academic-year.delete')}}">
        @csrf
    </form>
@endsection

@push('scripts')
    <script>
        function deleteAcademicYear(academic_year_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/academic-year/delete/confirm/' + academic_year_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['failed'] == null){
                        var data = response_data['reffered_academic_year'];
                        $('#deleteLabel').text('Confirm delete');
                        $('#popup_body').text('Confirm the deletion of "' + data.starting_year + '/' + data.ending_year + ' - ' + (data.odd_semester ? 'Odd' : 'Even') + '"');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-danger\" onclick=\"document.getElementById('delete_form').submit();\">Delete</button>");
                    }
                    else if(response_data['failed']){
                        $('#deleteLabel').text('DATA NOT FOUND!!');
                        $('#popup_body').text('Please pick the academic year to delete from the provided list!!');
                        $('#popup_footer').empty();
                    }
                    $('#confirmDeleteModal').modal();
                }
            });
        }
    </script>
@endpush