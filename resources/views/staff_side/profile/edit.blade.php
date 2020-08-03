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
                <input type="text" name="name" class="form-control mb-n4 @error('name') is-invalid @enderror" value="{{old('name') == null ? $old_user->name : old('name')}}" autocomplete="off"><br>
                @error('name')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Email</th>
            <td>
                <input type="email" name="email" class="form-control mb-n4 @error('email') is-invalid @enderror" value="{{old('email') == null ? $old_user->email : old('email')}}" autocomplete="off"><br>
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
                <input type="text" name="position" class="form-control mb-n4 @error('position') is-invalid @enderror" value="{{old('position') == null ? $old_user->staff->position : old('position')}}" autocomplete="off"><br>
                @error('position')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror    
            </td>
        </tr>
        <tr>
            <th scope="row">Gender</th>
            <td>
                <div class="custom-control custom-radio d-inline">
                    <input type="radio" id="male" name="gender" class="custom-control-input @error('gender') is-invalid @enderror" value="M" {{old('gender') == null ? ($old_user->gender === 'M' ? "Checked" : "") : (old('gender') == 'M' ? "Checked" : "")}}>
                    <label class="custom-control-label" for="male">Male</label>
                </div>
                <div class="custom-control custom-radio d-inline ml-3">
                    <input type="radio" id="female" name="gender" class="custom-control-input @error('gender') is-invalid @enderror" value="F" {{old('gender') == null ? ($old_user->gender === 'F' ? "Checked" : "") : (old('gender') == 'F' ? "Checked" : "")}}>
                    <label class="custom-control-label" for="female">Female</label>
                </div>
                @error('gender')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Mobile Phone Number</th>
            <td>
                <div class="row">
                    <div class="col-2 pr-0">
                        <div class="pl-2 pt-2">
                            0
                        </div>
                    </div>
                    <div class="col-10 pl-0">
                        <input type="text" name="mobile" class="form-control mb-n4 @error('mobile') is-invalid @enderror" value="{{old('mobile') == null ? $old_user->mobile : old('mobile')}}" autocomplete="off"><br>
                    </div>
                </div>
                
                @error('mobile')
                    <div class="alert alert-danger mb-0">{{ $message }}</div>
                @enderror
            </td>
        </tr>
        <tr>
            <th scope="row">Telephone Number</th>
            <td>
                <div class="row">
                    <div class="col-2 pr-0">
                        <div class="pl-2 pt-2">
                            0
                        </div>
                    </div>
                    <div class="col-10 pl-0">
                        <input type="text" name="telp-num" class="form-control mb-n4 @error('telp-num') is-invalid @enderror" value="{{old('telp-num') == null ? $old_user->telp_num : old('telp-num')}}" autocomplete="off"><br>
                    </div>
                </div>
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