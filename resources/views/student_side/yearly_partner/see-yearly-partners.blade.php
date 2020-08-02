@extends('layouts.app2')

@section('title')
    '{{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}}' Academic Year Partners for {{$major_name}}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h2">'{{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}}' Academic Year Partners for {{$major_name}}</div>
                    <div class="card-body">
                        @foreach ($partners as $partner)
                            <div class="card mb-3">
                                <div class="card-header h2">{{$partner->name}}</div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Location</th>
                                                <td>{{$partner->location}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Minimum GPA</th>
                                                <td>{{$partner->min_gpa}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">English Proficiency Requirement</th>
                                                <td>{{$partner->eng_requirement}}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <th scope="row" colspan="2">Short Detail</th>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="2">{{$partner->short_detail}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection