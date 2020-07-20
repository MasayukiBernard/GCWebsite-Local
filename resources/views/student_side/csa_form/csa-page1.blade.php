@extends('student_side.csa_template.csa-template')

@section('entity')
    Personal Information
@endsection

@section('form-action')
{{route('student.csa_form.csa-page2')}}
@endsection

@section('form-inputs')
    <div class="form-group row pt-4">
        <label for="picture_path" class="col-md-4 col-form-label text-md-left">Profile Picture</label>
        <div class="col-md-8">
            <img src="/photos/usersx_id={{$user->id}}&opt=picture_path" alt="profile picture" width="250px" height="250px">
        </div>
    </div>

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left">Name</label>
        <div class="col-md-8">
            <input id="name" class="col-md-6 form-control @error('name') is-invalid @enderror" type="text" disabled name="name" value="{{$user->name}}" >
        </div>
    </div>

    <div class="form-group row">
        <label for="nim" class="col-md-4 col-form-label text-md-left">Binusian ID</label>
        <div class="col-md-8">
            <input id="binusianID" class="col-md-6 form-control @error('binusianID') is-invalid @enderror" type="text" disabled name="binusianID" value="{{$user_student->nim}}" >
        </div>
    </div>

    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-left">Gender</label>
        <div class="col-md-8">
            <select class="col-md-6 form-control @error('gender') is-invalid @enderror" name="gender" disabled>
                <option value="" selected='selected'> - Select - </option>    
                    <option value="M" {{$user->gender === 'M' ? "selected" : ""}}> Male </option>
                    <option value="F" {{$user->gender === 'F' ? "selected" : ""}}> Female </option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="place_birth" class="col-md-4 col-form-label text-md-left">Place of Birth</label>
        <div class="col-md-8">
            <input id="place_birth" class="col-md-6 form-control @error('place_birth') is-invalid @enderror" type="text" disabled name="place_birth" value="{{$user_student->place_birth}}">
        </div>
    </div>

    <div class="form-group row">
        <label for="date_birth" class="col-md-4 col-form-label text-md-left">Date of Birth</label>
        <div class="col-md-8">
            <input id="date_birth" class="col-md-6 form-control @error('date_birth') is-invalid @enderror" type="text" disabled name="date_birth" value="{{$user_student->date_birth}}">
            @error('date_birth')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror  
        </div>
    </div>
    
    <div class="form-group row">
        <label for="nationality" class="col-md-4 col-form-label text-md-left">Nationality</label>

        <div class="col-md-8">
            <input id="nationality" class="col-md-6 form-control @error('nationality') is-invalid @enderror" type="text" disabled name="nationality" value="{{$user_student->nationality}}">
            @error('nationality')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-left">Email</label>
        <div class="col-md-8">
            <input id="email" class="col-md-6 form-control @error('email') is-invalid @enderror" type="text" name="email" disabled  value="{{$user->email}}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="mobile" class="col-md-4 col-form-label text-md-left">Mobile Phone</label>
        <div class="col-md-8">
            <input id="mobilenum" class="col-md-6 form-control @error('mobilenum') is-invalid @enderror" type="text" name="mobilenum" disabled  value="{{$user->mobile}}">
            @error('mobilenum')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="telp_num" class="col-md-4 col-form-label text-md-left">Telephone Number</label>
        <div class="col-md-8">
            <input id="telp_num" class="col-md-6 form-control @error('telp_num') is-invalid @enderror" type="text" name="telp_num" disabled  value="{{$user->telp_num}}">
            @error('telp_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-left">Address</label>
        <div class="col-md-8">
            <textarea class="col-md-6 form-control @error('address') is-invalid @enderror" rows="3" name="address" disabled  value="{{$user_student->address}}">
            </textarea>
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="flazz_card_proof_path" class="col-md-4 col-form-label text-md-left">Binusian Flash Picture Attachment</label>
        <div class="col-md-8">
            <img src="/photos/users_id={{$user->id}}&opt=flazz_card_proof_path" alt="Binusian flazz picture" width="250px" height="250px">
        </div>
    </div>
    <div class="form-group row">
        <label for="id_card_picture_path" class="col-md-4 col-form-label text-md-left">National ID Picture Attachment</label>
        <div class="col-md-8">
            <img src="/photos/users_id={{$user->id}}&opt=id_card_picture_path" alt="e-KTP picture" width="250px" height="250px">
        </div>
    </div>

@endsection

@section('confirm-value')
Next
@endsection