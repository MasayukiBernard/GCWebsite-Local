@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    New Partner Creation
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">Major Name</th>
                <td>{{$inputted_partner['major']}}</td>
            </tr>
            <tr>
                <th scope="row">University Name</th>
                <td>{{$inputted_partner['uni-name']}}</td>
            </tr>
            <tr>
                <th scope="row">Location</th>
                <td>{{$inputted_partner['location']}}</td>
            </tr>
            <tr>
                <th scope="row">Minimum GPA</th>
                <td>{{$inputted_partner['min-gpa']}}</td>
            </tr>
            <tr>
                <th scope="row">English Proficiency Requirements</th>
                <td>{{$inputted_partner['eng-proficiency']}}</td>
            </tr>
            <tr>
                <th scope="row" colspan="2">Short Details</th>
            </tr>
            <tr>
                <td colspan="2">{{$inputted_partner['details']}}</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('form-action')
    {{route('staff.partner-create')}}
@endsection

@section('return-route')
    {{route('staff.partner-create-page')}}
@endsection