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
                        <a class="btn btn-success" href="{{route('staff.yearly-partner.create-page')}}" role="button">Add New Yearly Partner</a>
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">University Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Major Name</th>
                                    <th scope="col">Delete</th>
                                </tr>
                              </thead>
                            <tbody>
                                <?php $i=0;?>
                                @foreach ($yearly_partners as $yearly_partner)
                                    <tr>
                                        <th style="cursor: pointer;" class="partner" onclick="window.location.assign('/staff/partner/details/{{$yearly_partner->partner_id}}')" scope="row">{{++$i}}</th>
                                        <td style="cursor: pointer;" class="partner" onclick="window.location.assign('/staff/partner/details/{{$yearly_partner->partner_id}}')">{{$yearly_partner->partner->name}}</td>
                                        <td style="cursor: pointer;" class="partner" onclick="window.location.assign('/staff/partner/details/{{$yearly_partner->partner_id}}')">{{$yearly_partner->partner->location}}</td>
                                        <td style="cursor: pointer;" class="partner" onclick="window.location.assign('/staff/partner/details/{{$yearly_partner->partner_id}}')">{{$yearly_partner->partner->major->name}}</td>
                                        <td><button type="button" class="btn btn-danger position-relative" onclick="deleteYearlyPartner({{$yearly_partner->id}})">Delete</button></td>
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
        function deleteYearlyPartner(yearly_partner_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/yearly-partner/delete/confirm/' + yearly_partner_id;
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
    </script>
@endpush