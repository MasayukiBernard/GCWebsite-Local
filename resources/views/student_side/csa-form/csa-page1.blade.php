@extends('student_side.csa_template.csa-template')

@section('entity')
    Personal Information &mdash; CSA Application Form Page 1
@endsection

@section('form-action')
{{route('student.csa-form.after-page1')}}
@endsection

@section('form-inputs')
    <div class="font-weight-bold">
        *** <u>All of below information are reflected from your account's profile information!</u> ***
    </div>
    <hr>
    <div class="form-group row pt-4">
        <label for="picture_path" class="col-md-4 col-form-label text-md-left font-weight-bold">Profile Picture</label>
        <div class="col-md-8">
            <div>
                <div class="d-flex align-items-center border border-dark rounded" style="height: 18vw; width: 18vw;">
                    <img src="/photos/mt={{$filemtimes['pp']}}&ys=0&opt=profile-picture" style="max-width: 100%; max-height: 100%;" alt="profile picture" class="p-2">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-left font-weight-bold">Name</label>
        <div class="col-md-8">
            <input id="name" class="col-md-12 form-control @error('name') is-invalid @enderror" type="text" disabled name="name" value="{{$user->name}}" >
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="nim" class="col-md-4 col-form-label text-md-left font-weight-bold">Binusian ID</label>
        <div class="col-md-8">
            <input id="binusianID" class="col-md-12 form-control @error('binusianID') is-invalid @enderror" type="text" disabled name="binusianID" value="{{$user_student->nim}}" >
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-left font-weight-bold">Gender</label>
        <div class="col-md-8">
            <input type="text" name="gender" class="form-control" disabled value="{{$user->gender === 'M' ? 'Male' : 'Female'}}">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="place_birth" class="col-md-4 col-form-label text-md-left font-weight-bold">Place of Birth</label>
        <div class="col-md-8">
            <input id="place_birth" class="col-md-12 form-control @error('place_birth') is-invalid @enderror" type="text" disabled name="place_birth" value="{{$user_student->place_birth}}">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="date_birth" class="col-md-4 col-form-label text-md-left font-weight-bold">Date of Birth</label>
        <div class="col-md-8">
            <input id="date_birth" class="col-md-12 form-control @error('date_birth') is-invalid @enderror" type="text" disabled name="date_birth" value="{{$user_student->date_birth}}">
            @error('date_birth')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror  
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="nationality" class="col-md-4 col-form-label text-md-left font-weight-bold">Nationality</label>

        <div class="col-md-8">
            <input id="nationality" class="col-md-12 form-control @error('nationality') is-invalid @enderror" type="text" disabled name="nationality" value="{{$user_student->nationality}}">
            @error('nationality')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-left font-weight-bold">Email</label>
        <div class="col-md-8">
            <input id="email" class="col-md-12 form-control @error('email') is-invalid @enderror" type="text" name="email" disabled  value="{{$user->email}}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="mobile" class="col-md-4 col-form-label text-md-left font-weight-bold">Mobile Phone</label>
        <div class="col-md-8">
            <input id="mobilenum" class="col-md-12 form-control @error('mobilenum') is-invalid @enderror" type="text" name="mobilenum" disabled  value="0{{$user->mobile}}">
            @error('mobilenum')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="telp_num" class="col-md-4 col-form-label text-md-left font-weight-bold">Telephone Number</label>
        <div class="col-md-8">
            <input id="telp_num" class="col-md-12 form-control @error('telp_num') is-invalid @enderror" type="text" name="telp_num" disabled  value="0{{$user->telp_num}}">
            @error('telp_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-left font-weight-bold">Address</label>
        <div class="col-md-8">
            <textarea class="col-md-12 form-control @error('address') is-invalid @enderror" rows="3" name="address" disabled style="resize: none;">{{$user_student->address}}</textarea>
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="flazz_card_proof_path" class="col-md-4 col-form-label text-md-left font-weight-bold">Binusian Flash Picture Attachment</label>
        <div class="col-md-8">
            <div>
                <div class="d-flex align-items-center border border-dark rounded justify-content-center" style="height: 10vw; width: 18vw;">
                    <img src="/photos/mt={{$filemtimes['fc']}}&ys=0&opt=flazz-card" style="max-width: 100%; max-height: 100%;" alt="Flazz Card" class="p-2">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="id_card_picture_path" class="col-md-4 col-form-label text-md-left font-weight-bold">National ID Picture Attachment</label>
        <div class="col-md-8">
            <div>
                <div class="d-flex align-items-center border border-dark rounded justify-content-center" style ="height: 10vw; width: 18vw;">
                    <img src="/photos/mt={{$filemtimes['ic']}}&ys=0&opt=id-card" style="max-width: 100%; max-height: 100%;" alt="e-KTP" class="p-2">
                </div>
            </div>
        </div>
    </div>
    <hr>
@endsection

@section('confirm-value')
Next &#x0226B;
@endsection