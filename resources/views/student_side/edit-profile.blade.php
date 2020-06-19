@extends('staff_side.crud_templates.create')

@section('entity')
    Single Student
@endsection

@section('form-action')

@endsection

@section('form-inputs')
    <h2>Personal Informatiion</h2>

    <label>Name</label><br>
    <input type="text" name="name" maxlength="75" class="@error('name') is-invalid @enderror" value="{{ old('name') }}"><br>
    @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <label>NIM</label><br>
    <input type="text" name="nim" class="@error('nim') is-invalid @enderror" value="{{ old('nim') }}"><br>
    @error('nim')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Password</label><br>
    <input type="password" maxlength="100" name="password" class="@error('password') is-invalid @enderror"><br>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="gender-selection">Gender</label>
        </div>
        <select class="custom-select @error('gender') is-invalid @enderror" id="gender-selection" name="gender">
            <option value=" ">Choose...</option>
            <option {{session('last_picked_gender') != null ? (session('last_picked_gender') === 'M' ? "selected" : "") : (old('gender') === 'M' ? "selected" : "")}} value="M">
                Male
            </option>
            <option {{session('last_picked_gender') != null ? (session('last_picked_gender') === 'F' ? "selected" : "") : (old('gender') === 'F' ? "selected" : "")}} value="F">
                Female
            </option>
        </select>
    </div>
    @error('gender')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Email</label><br>
    <input type="email" name="email" maxlength="50" class="@error('email') is-invalid @enderror" value="{{ old('email') }}"><br>
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Mobile Number</label><br>
    <input type="text" maxlength="13" placeholder="remove the first zero" name="mobile" class="@error('mobile') is-invalid @enderror" value="{{ old('mobile') }}"><br>
    @error('mobile')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <label>Telephone Number</label><br>
    <input type="text" maxlength="14" placeholder="remove the first zero" name="telp-num" class="@error('telp-num') is-invalid @enderror" value="{{ old('telp-num') }}"><br>
    @error('telp-num')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <hr>

    <h2>Student Info</h2>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="major-selection">Major Name</label>
        </div>
        <select class="custom-select @error('major') is-invalid @enderror" id="major-selection" name="major">
            <option value=" ">Choose...</option>
            @foreach ($majors as $major)
                <option {{session('last_picked_major_id') != null ? (session('last_picked_major_id') == $major->id ? "selected" : "") : (old('major') == $major-> id ? "selected" : "")}} value={{$major->id}}>
                    {{$major->name}}
                </option>
            @endforeach
        </select>
    </div>
    @error('major')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Place of Birth</label><br>
    <input type="text" maxlength="50" name="place-birth" class="@error('place-birth') is-invalid @enderror" value="{{ old('place-birth') }}"><br>
    @error('place-birth')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <label>Date of Birth</label><br>
    <input type="text" maxlength="10" name="date-birth" class="@error('date-birth') is-invalid @enderror" value="{{ old('date-birth') }}"><br>
    @error('date-birth')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Nationality</label><br>
    <input type="text" maxlength="20" name="nationality" class="@error('nationality') is-invalid @enderror" value="{{ old('nationality') }}"><br>
    @error('nationality')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Address</label><br>
    <textarea name="address" class="@error('address') is-invalid @enderror">{{ old('address') }}</textarea><br>
    @error('address')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Minimum GPA</label><br>
    <input type="number" step=0.01 min=0 max=4 name="min-gpa" class="@error('min-gpa') is-invalid @enderror" value="{{ old('min-gpa') }}"><br>
    @error('min-gpa')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <label></label><br>
    <input type="number" step=0.01 min=0 max=4 name="min-gpa" class="@error('min-gpa') is-invalid @enderror" value="{{ old('min-gpa') }}"><br>
    @error('min-gpa')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    
@endsection

@section('confirm-value')
@endsection