@extends('layouts.app2')

@section('title')
    Home
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h5 class="card-title"><u>You are logged in as a Staff!</u></h5>
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td class="align-middle col-2">Major</td>
                                    <td class="align-middle col-3">
                                        <div class="btn-group">
                                            <button type="button" id="major_dropdown" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                All Majors
                                            </button>
                                            <div class="dropdown-menu">
                                                @isset ($majors)
                                                    <a id="major_0" class="dropdown-item" style="cursor: pointer"
                                                        onclick="set_major(0);">
                                                        All Majors  
                                                    </a>
                                                    @foreach ($majors as $major)
                                                        <a id="major_{{$major->id}}" class="dropdown-item" style="cursor: pointer"
                                                            onclick="set_major({{$major->id}});">
                                                            {{$major->name}}
                                                        </a>
                                                    @endforeach
                                                @endisset
                                            </div>
                                        </div>
                                    </td>
                                    <td rowspan="2" class="align-middle pl-3 col-7">
                                        <table class="table table-borderless table-sm mb-0 w-auto">
                                            @isset($initial_percentages)
                                                <tr>
                                                    <td>CSA Form Submission</td>
                                                    <td>
                                                        : <span id="csa_percentage">{{$initial_percentages['submitted_percentage']}}%</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Nominated Student</td>
                                                    <td>
                                                        : <span id="nominated_percentage">{{$initial_percentages['nominated_percentage']}}%</span>
                                                    </td>
                                                </tr>
                                            @endisset
                                            @isset($failed)
                                                <tr>
                                                    <td class="text-danger">
                                                        No academic year data yet!!
                                                    </td>
                                                </tr>
                                        @endisset
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Academic Year</td>
                                    <td>
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
                                                            onclick="set_year({{$year->id}});">
                                                            {{$year->starting_year}}/{{$year->ending_year}} - {{$year->odd_semester ? 'Odd' : 'Even'}}
                                                        </a>
                                                    @endforeach
                                                @endisset
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
    which is fulfilled in the controller, upon request success the method will show the percentages
    data from the server without refreshing the page.

--}}


@push('scripts')
    <script>
        var major_id = 0, academic_year_id = {{$academic_years->first()->id}};

        function set_major(id){
            major_id = id;
            get_percentages();
        }

        function set_year(id){
            academic_year_id = id;
            get_percentages();
        }

        function get_percentages(){
            if(Number.isInteger(major_id) && Number.isInteger(academic_year_id) && major_id >= 0 && academic_year_id > 0){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = '/staff/home/major/' + major_id + '/academic-year/' + academic_year_id;
                $.ajax({
                    type: 'POST',
                    url: targetURL,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function(response_data){
                        console.log('succeed');
                        if(response_data['empty'] === true){
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
                                submission_percentage = Number(submission_percentage.toFixed(2)) + '%';
                                nominated_percentage = (response_data['nominated_students'] / response_data['total_yearly_students'] * 100);
                                nominated_percentage = Number(nominated_percentage.toFixed(2))   + '%';
                            }
                            $("#csa_percentage").text(submission_percentage);
                            $('#nominated_percentage').text(nominated_percentage);
                            $("#major_dropdown").text($("#major_"+major_id).text());
                            $("#academic_year_dropdown").text($("#year_"+academic_year_id).text());
                        }
                    }
                });
            }
        }
    </script>

    <!-- Charting library -->
    <script src="https://unpkg.com/chart.js/dist/Chart.min.js"></script>

    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs/dist/chartisan_chartjs.js"></script>
@endpush