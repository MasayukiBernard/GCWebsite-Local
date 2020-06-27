@extends('layouts.app2')

@section('title')
    Yearly Partner
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">Yearly Partner</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                Academic Year<br>
                                Tahun Ajaran
                            </div>
                            <div class="col-8">
                                <div class="dropdown show">
                                    <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @if ($academic_years->count() > 0)
                                            Academic Years
                                        @else
                                            No Data Yet!!
                                        @endif
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        @if ($academic_years->count() > 0)
                                            @foreach ($academic_years as $year)
                                                <a class="dropdown-item" href="{{route('staff.yearly-partner.details', ['academic_year_id' => $year->id])}}">{{$year->starting_year}}/{{$year->ending_year}} - {{$year->odd_semester ? "Odd" : "Even    "}}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection