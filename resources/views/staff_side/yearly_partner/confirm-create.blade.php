@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    New Yearly Partner
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <thead class="thead-dark">
            <th>Academic Year</th>
            <th>{{$referred_year->starting_year}}/{{$referred_year->ending_year}} - {{$referred_year->odd_semester ? "Odd" : "Even"}}</th>
        </thead>
        <tbody>
            <tr>
                <th scope="row">University Name</th>
                <td>{{$referred_partner->name}}</td>
            </tr>
            <tr>
                <th scope="row">Location</th>
                <td>{{$referred_partner->location}}</td>
            </tr>
            <tr>
                <th scope="row">Minimum GPA</th>
                <td>{{$referred_partner->min_gpa}}</td>
            </tr>
            <tr>
                <th scope="row">English Proficiency Requirements</th>
                <td>{{$referred_partner->eng_requirement}}</td>
            </tr>
            <tr>
                <th scope="row" colspan="2">Short Details</th>
            </tr>
            <tr>
                <td colspan="2">{{$referred_partner->short_detail}}</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('form-action')
    {{route('staff.yearly-partner.create')}}
@endsection

@section('return-route')
    {{route('staff.yearly-partner.create-page')}}
@endsection