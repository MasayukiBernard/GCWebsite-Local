@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    Single Student
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="2"><h3>Inputted Data</h3></td>
            <tr>
            <tr>
                <th scope="row">NIM</th>
                <td>{{$validatedData['nim']}}</td>
            </tr>
            <tr>
                <th scope="row">Password</th>
                <td>{{$validatedData['password']}}</td>
            </tr>
            <tr>
                <td colspan="2"><h3>Default Data</h3></td>
            <tr>
                <th scope="row">Name</th>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">Gender</th>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">Email</th>
                <td>randomized</td>
            </tr>
            <tr>
                <th scope="row">Mobile Number</th>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">Telephone Number</th>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">Major</th>
                <td>Computer Science</td>
            </tr>
            <tr>
                <th scope="row">Place of Birth</th>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">Date of Birth</th>
                <td>1st January 1970</td>
            </tr>
            <tr>
                <th scope="row">Nationality</th>
                <td>-</td>
            </tr>
            <tr>
                <th scope="row">Address</th>
                <td>-</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('form-action')
{{route('staff.student.create-single')}}
@endsection

@section('return-route')
{{route('staff.student.create-page-single')}}
@endsection