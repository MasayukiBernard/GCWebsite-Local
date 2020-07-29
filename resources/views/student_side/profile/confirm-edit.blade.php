@extends('student_side.crud_templates.confirm')

@section('entity-crud')
    Edit Profile
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <tr>
            <th scope="row" class="align-middle">Profile Picture</th>
            <th scope="row" class="align-middle">ID Card Picture</th>
        </tr>
        <tr>
            <td class="text-center" rowspan="3">
                <img src="/photos/type=temp&opt=profile-picture" width="275vw" alt="No Data" class="img-thumbnail border-secondary">
            </td>
            <td class="text-center">
                <img src="/photos/type=temp&opt=id-card" width="175vw" alt="No Data" class="img-thumbnail border-secondary">
            </td>
        </tr>
        <tr>
            <th scope="row" class="align-middle">Flazz Card Picture</th>
        </tr>
        <tr>
            <td class="text-center">
                <img src="/photos/type=temp&opt=flazz-card" width="175vw" alt="No Data" class="img-thumbnail border-secondary">
            </td>
        </tr>
        <tr>
            <th scope="row">Name</th>
            <td>{{$validatedData['name']}}</td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>{{$validatedData['email']}}</td>
        </tr>
        <tr>
            <th scope="row">NIM</th>
            <td>{{$nim}}</td>
        </tr>
        <tr>
            <th scope="row">Gender</th>
            <td>{{$validatedData['gender'] === 'M' ? 'Male' : 'Female'}}</td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone Number</th>
            <td>0{{$validatedData['mobile']}}</td>
        </tr>
        <tr>
            <th scope="row">Telephone Number</th>
            <td>0{{$validatedData['telp-num']}}</td>
        </tr>
        <tr>
            <th scope="row">Enrolled Major</th>
            <td>{{$major->name}}</td>
        </tr>
        <tr>
            <th scope="row">Place of Birth</th>
            <td>{{$validatedData['place-birth']}}</td>
        </tr>
        <tr>
            <th scope="row">Date of Birth</th>
            <td>{{$validatedData['date-birth']}}</td>
        </tr>
        <tr>
            <th scope="row">Nationality</th>
            <td>{{$validatedData['nationality']}}</td>
        </tr>
        <tr>
            <th scope="row">Address</th>
            <td>{{$validatedData['address']}}</td>
        </tr>
    </table>
@endsection

@section('form-action')
{{route('student.profile-edit')}}
@endsection

@section('return-route')
{{route('student.profile-edit-page')}}
@endsection