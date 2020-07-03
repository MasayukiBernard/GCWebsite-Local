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
                        <table class="table table-striped table-bordered table-hover text-center table-sm">
                            <thead>
                                <tr class="d-flex">
                                    <th class="col-1" scope="col">No.</th>
                                    <th class="col-3" scope="col">Starting Year</th>
                                    <th class="col-1" scope="col">/</th>
                                    <th class="col-3" scope="col">Ending Year</th>
                                    <th class="col-3" scope="col">Semester Type</th>
                                    <th class="col-1" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academic_years as $year)
                                    <tr class="d-flex">
                                        <th class="col-1 d-flex align-items-center justify-content-center" scope="row">{{++$i}}</th>
                                        <td class="col-3 d-flex align-items-center justify-content-center"><div>{{$year->starting_year}}</div></td>
                                        <td class="col-1 d-flex align-items-center justify-content-center"><div>/</div></td>
                                        <td class="col-3 d-flex align-items-center justify-content-center"><div>{{$year->ending_year}}</div></td>
                                        <td class="col-3 d-flex align-items-center justify-content-center"><div>{{$year->odd_semester ? "Odd" : "Even"}}</div></td>
                                        <td class="col-1"><button type="button" class="btn btn-danger" onclick="deleteAcademicYear({{$year->id}});">Delete</button></td>
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
                    if(response_data['failed'] === false){
                        var data = response_data['reffered_academic_year'];
                        $('#deleteLabel').text('Confirm delete');
                        $('#popup_body').text('Confirm the deletion of "' + data.starting_year + '/' + data.ending_year + ' - ' + (data.odd_semester ? 'Odd' : 'Even') + '"');
                        $('#popup_footer').empty();
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Cancel</button>");
                        $('#popup_footer').append("<button type=\"button\" class=\"btn btn-danger\" onclick=\"document.getElementById('delete_form').submit();\">Delete</button>");
                    }
                    else{
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