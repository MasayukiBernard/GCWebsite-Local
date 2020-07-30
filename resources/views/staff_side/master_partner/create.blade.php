@extends('staff_side.crud_templates.create')

@section('entity')
    Master Partner
@endsection

@section('form-action')
    {{route('staff.partner.create-confirm')}}
@endsection

@section('form-inputs')
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label class="input-group-text bg-info text-light" for="major-selection">Major Name</label>
        </div>
        <select class="custom-select @error('major') is-invalid @enderror" id="major-selection" name="major">
            @if ($all_majors->count() > 0)
                <option value=" ">Choose...</option>
                @foreach ($all_majors as $major)
                    <option {{session('last_picked_major_id') != null ? (session('last_picked_major_id') == $major->id ? "selected" : "") : (old('major') == $major-> id ? "selected" : "")}} value={{$major->id}}>
                        {{$major->name}}
                    </option>
                @endforeach
            @else
                <option value="0">No data yet!!</option>
            @endif
        </select>
    </div>
    @error('major')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>University Name</label><br>
    <input type="text" name="uni-name" class="@error('uni-name') is-invalid @enderror" value="{{ old('uni-name') }}"><br>
    @error('uni-name')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Location</label><br>
    <input type="text" name="location" class="@error('location') is-invalid @enderror" value="{{ old('location') }}"><br>
    @error('location')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Minimum GPA</label><br>
    <input type="number" step=0.01 min=0 max=4 name="min-gpa" class="@error('min-gpa') is-invalid @enderror" value="{{ old('min-gpa') }}"><br>
    @error('min-gpa')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>English Proficiency Requirements</label><br>
    <input type="text" name="eng-proficiency" class="@error('eng-proficiency') is-invalid @enderror" value="{{ old('eng-proficiency') }}"><br>
    @error('eng-proficiency')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <label>Short Details</label><br>
    <textarea name="details" class="@error('details') is-invalid @enderror">{{ old('details') }}</textarea><br>
    @error('details')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
@endsection

@section('confirm-value')
Master Partner
@endsection