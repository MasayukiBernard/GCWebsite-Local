@extends('staff_side.crud_templates.update')

@section('entity')
    Profile
@endsection

@section('old-data')
    <table class="table table-bordered">
        <tr>
            <th scope="row">Name</th>
            <td>{{$old_user->name}}</td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>{{$old_user->email}}</td>
        </tr>
        <tr>
            <th scope="row">Role</th>
            <td>Staff</td>
        </tr>
        <tr>
            <th scope="row">Position</th>
            <td>{{$old_user->staff->position}}</td>
        </tr>
        <tr>
            <th scope="row">Gender</th>
            <td>{{$old_user->gender === 'M' ? 'Male' : 'Female'}}</td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone Number</th>
            <td>0{{$old_user->mobile}}</td>
        </tr>
        <tr>
            <th scope="row">Telephone Number</th>
            <td>0{{$old_user->telp_num}}</td>
        </tr>
    </table>    
@endsection

@section('form-action')
{{route('staff.profile-edit-confirm')}}
@endsection

@section('form-inputs')
<table class="table table-bordered">
        <tr>
            <th scope="row">Name</th>
            <td> 
                <input type="text" name="name" class="@error('name') is-invalid @enderror" value="{{old('name') == null ? $old_user->name : old('name')}}"><br>
                @error('name')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>
                <input type="email" name="email" class="@error('email') is-invalid @enderror" value="{{old('email') == null ? $old_user->email : old('email')}}"><br>
                @error('email')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Role</th>
            <td>Staff</td>
        </tr>
        <tr>
            <th scope="row">Position</th>
            <td>
                <input type="text" name="position" class="@error('position') is-invalid @enderror" value="{{old('position') == null ? $old_user->staff->position : old('position')}}"><br>
                @error('position')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <th scope="row">Gender</th>
            <td>
                <input type="radio" id="male" name="gender" class="@error('gender') is-invalid @enderror" value="M" {{old('gender') == null ? ($old_user->gender === 'M' ? "Checked" : "") : (old('gender') == 'M' ? "Checked" : "")}}>
                <label class="m-0 mr-2" for="male">Male</label>
                <input type="radio" id="female" name="gender" class="@error('gender') is-invalid @enderror" value="F" {{old('gender') == null ? ($old_user->gender === 'F' ? "Checked" : "") : (old('gender') == 'F' ? "Checked" : "")}}>
                <label class="m-0" for="female">Female</label><br>
                @error('gender')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone Number</th>
            <td>
                0
                <input type="text" name="mobile" class="@error('mobile') is-invalid @enderror" value="{{old('mobile') == null ? $old_user->mobile : old('mobile')}}"><br>
                @error('mobile')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Telephone Number</th>
            <td>
                0
                <input type="text" name="telp-num" class="@error('telp-num') is-invalid @enderror" value="{{old('telp-num') == null ? $old_user->telp_num : old('telp-num')}}"><br>
                @error('telp-num')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <input type="submit" class="btn btn-primary" value="Confirm New Profile Data">
            </td>
        </tr>
    </table>
@endsection