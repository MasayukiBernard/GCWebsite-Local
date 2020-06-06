@extends('staff_side.crud_templates.create')

@section('entity')
    Academic Year
@endsection

@section('form-action')
    {{route('staff.academic-year.create-confirm')}}
@endsection

@section('form-inputs')
    <input type="hidden" name="existed" class="@error('existed') is-invalid @enderror" value="1">
    @error('existed')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Starting Year</label><br>
    <input type="text" name="start-year" class="@error('start-year') is-invalid @enderror" value="{{ old('start-year') == null ? $temp_year->starting_year : old('start-year')}}"><br>
    @error('start-year')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Ending Year</label><br>
    <input type="text" name="end-year" class="@error('end-year') is-invalid @enderror" value="{{ old('end-year') == null ? $temp_year->ending_year : old('end-year') }}"><br>
    @error('end-year')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Semester Type</label><br>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="type-selection">Semester Type</label>
        </div>
        <select name="smt-type" class="custom-select @error('smt-type') is-invalid @enderror" id="smt-type-selection">
            <option value=" ">Choose...</option>
            <option value="1" {{$temp_year->odd_semester ? "selected" : ""}}>Odd Semester</option>
            <option value="0" {{$temp_year->odd_semester ? "" : "selected"}}>Even Semester</option>
        </select>
    </div>
    @error('smt-type')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@endsection

@section('confirm-value')
Academic Year
@endsection