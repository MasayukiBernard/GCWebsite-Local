@extends('staff_side.crud_templates.create')

@section('entity')
    Master Major
@endsection

@section('form-action')
    /staff/major/create/master-major
@endsection

@section('form-inputs')

<label>Major Name</label><br>
    <input type="text" name="major-name" class="@error('major-name') is-invalid @enderror"><br>
    @error('major-name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <input class="btn btn-success" type="submit" value="Add to Master Major">
@endsection