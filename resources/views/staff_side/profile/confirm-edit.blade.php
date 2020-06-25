@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    Edit Profile
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <tr>
            <th scope="row">Name</th>
            <td>{{$validated_data['name']}}</td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>{{$validated_data['email']}}</td>
        </tr>
        <tr>
            <th scope="row">Role</th>
            <td>Staff</td>
        </tr>
        <tr>
            <th scope="row">Position</th>
            <td>{{$validated_data['position']}}</td>
        </tr>
        <tr>
            <th scope="row">Gender</th>
            <td>{{$validated_data['gender'] === 'M' ? 'Male' : 'Female'}}</td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone Number</th>
            <td>0{{$validated_data['mobile']}}</td>
        </tr>
        <tr>
            <th scope="row">Telephone Number</th>
            <td>0{{$validated_data['telp-num']}}</td>
        </tr>
    </table>
@endsection

@section('form-action')
{{route('staff.profile-edit')}}
@endsection

@section('return-route')
{{route('staff.profile-edit-page')}}
@endsection