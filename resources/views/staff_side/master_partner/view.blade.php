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
                                Major Name
                            </button>
                            <div class="dropdown-menu">
                                @foreach($all_majors as $major)
                                    <a id="major_{{$major->id}}" class="dropdown-item" style="cursor: pointer"
                                        onclick="get_partners({{$major->id}})">
                                        {{$major->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <a class="btn btn-success text-light" role="button" href={{route('staff.partner-create-page')}}>Add New Partner</a>

                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">University Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Minimum GPA</th>
                                    <th scope="col">English Proficiency Requirement</th>
                                    <th scope="col">Short Detail</th>
                                </tr>
                            </thead>
                            <tbody id="partner_tBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- 
    get_percentage() description:
    The function uses jquery library and utilizes AJAX feature provided by jquery.
    Perform async HTTP request to web server, in this case a POST request to a designated route,
    with 'X-CSRF-TOKEN' as the data in the POST body, it also expects JSON response from the server
    which is fulfilled in the controller, upon request success the method will show the the partners from
    requested major data from the server without refreshing the page.

--}}
@push('scripts')
    <script>
        function get_partners(major_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = "/staff/partner/major/"+ major_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    var data = response_data['major_partners'];
                    $(".partner_tData").remove();
                    $.each(data, function(index, value){
                        var truncatedString = data[index].short_detail;
                        if(truncatedString.length > 25){
                            truncatedString = truncatedString.substr(0,20);
                            truncatedString = truncatedString + "...";
                        }
                        $("#partner_tBody").append(
                            "<tr class=\"partner_tData position-relative\">" + 
                            "<th scope=row>" + (index+1) + "</th>" +
                            "<td><a href=/staff/partner/details/" + data[index].id +  " class=\"stretched-link text-body text-decoration-none\">" + data[index].name + "</a></td>" + 
                            "<td>" + data[index].location + "</td>" + 
                            "<td>" + data[index].min_gpa + "</td>" + 
                            "<td>" + data[index].eng_requirement + "</td>" + 
                            "<td>" + truncatedString + "</td>" +
                            "</tr>"
                        );
                    });
                    $("#major_name_dropdown").text($("#major_" + major_id).text());
                }
            });
        }
    </script>
@endpush