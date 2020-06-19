@extends('staff_side.crud_templates.create')

@section('entity')
    Single Student
@endsection

@section('form-action')
{{route('staff.student.create-single-confirm')}}
@endsection

@section('form-inputs')
    <label>NIM</label><br>
    <input type="text" name="nim" maxlength="10" mclass="@error('nim') is-invalid @enderror" value="{{ old('nim') }}"><br>
    @error('nim')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Password</label><br>
    <input type="password" maxlength="100" name="password" class="@error('password') is-invalid @enderror"><br>
    @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>    
@endsection

@section('confirm-value')
Student
@endsection