@extends('staff_side.crud_templates.create')

@section('entity')
    Master Major
@endsection

@section('form-action')
    {{route('staff.major.create-confirm')}}
@endsection

@section('form-inputs')
    <label>Major Name</label><br>
    <input type="text" name="major-name" class="form-control @error('major-name') is-invalid @enderror" autocomplete="off"><br>
    @error('major-name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <br>
@endsection

@section('confirm-value')
Master Major
@endsection