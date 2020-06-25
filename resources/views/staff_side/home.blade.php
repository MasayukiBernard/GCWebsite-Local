@extends('layouts.app2')

@section('title')
    Home
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h5 class="card-title">You are logged in as a Staff!</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Major:
                                <div class="btn-group">
                                    <button type="button" id="major_dropdown" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu">
                                        @foreach ($majors as $major)
                                            <a id="major_{{$major->id}}" class="dropdown-item" style="cursor: pointer" 
                                                onclick="get_percentages({{$major->id}})">
                                                {{$major->name}}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                Academic Year:
                                <div class="btn-group">
                                    <button type="button" id="academic_year_dropdown" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @isset($initial_percentages)
                                            {{$initial_percentages['year']}}
                                        @endisset
                                    </button>
                                    <div class="dropdown-menu">
                                        @isset ($academic_years)
                                            @foreach ($academic_years as $year)
                                                <a id="year_{{$year->id}}" class="dropdown-item" style="cursor: pointer" 
                                                    onclick="get_percentages({{$year->id}})">
                                                    {{$year->starting_year}}/{{$year->ending_year}} - {{$year->odd_semester ? 'Odd' : 'Even'}}
                                                </a>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                @isset($initial_percentages)
                                    <div class="card-text">
                                        CSA Form Submission Percentage: <span id="csa_percentage">{{$initial_percentages['submitted_percentage']}}%</span>
                                    </div>
                                    <div class="card-text">
                                        Nominated Student Percentage: <span id="nominated_percentage">{{$initial_percentages['nominated_percentage']}}%</span>
                                    </div>
                                @endisset
                                @isset($failed)
                                    <div class="card-text text-danger">
                                        No academic year data yet!!
                                    </div>
                                @endisset
                            </li>
                        </ul>
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
    which is fulfilled in the controller, upon request success the method will show the percentages
    data from the server without refreshing the page.

--}}
@push('scripts')
    <script>
        function get_percentages(academic_year_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var targetURL = '/staff/home/academic-year/' + academic_year_id;
            $.ajax({
                type: 'POST',
                url: targetURL,
                data: {_token: CSRF_TOKEN},
                dataType: 'JSON',
                success: function(response_data){
                    if(response_data['empty'] === null){
                        $("#academic_year_dropdown").text("No Data Yet");
                    }
                    else{
                        var submission_percentage;
                        var nominated_percentage;
                        if (response_data['total_yearly_students'] == 0){
                            submission_percentage = nominated_percentage = '-';
                        }
                        else{
                            submission_percentage = (response_data['submitted_csa_forms'] / response_data['total_yearly_students'] * 100);
                            submission_percentage = submission_percentage.toFixed(2) + '%';
                            nominated_percentage = (response_data['nominated_students'] / response_data['total_yearly_students'] * 100);
                            nominated_percentage = nominated_percentage.toFixed(2) + '%';
                        }
                        $("#csa_percentage").text(submission_percentage);
                        $('#nominated_percentage').text(nominated_percentage);
                        $("#academic_year_dropdown").text($("#year_"+academic_year_id).text());
                    }
                }
            });
        }
    </script>
@endpush