@extends('staff_side.crud_templates.create')

@section('entity')
    Master Major
@endsection

@section('form-action')
    {{route('staff.major.create-confirm')}}
@endsection

@section('form-inputs')

<label>Major Name</label><br>
    <input type="text" name="major-name" class="@error('major-name') is-invalid @enderror"><br>
    @error('major-name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@endsection

@section('confirm-value')
Master Major
@endsection