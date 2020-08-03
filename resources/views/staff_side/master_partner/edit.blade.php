@extends('staff_side.crud_templates.update')

@section('entity')
    Partner
@endsection

@section('old-data')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">University Name</th>
                <td>{{$referred_partner->name}}</td>
            </tr>
            <tr>
                <th scope="row">Related Major Name</th>
                <td>{{$referred_partner->major->name}}</td>
            </tr>
            <tr>
                <th scope="row">Location</th>
                <td>{{$referred_partner->location}}</td>
            </tr>
            <tr>
                <th scope="row">Minimum GPA</th>
                <td>{{$referred_partner->min_gpa}}</td>
            </tr>
            <tr>
                <th scope="row">English Proficiency Requirement</th>
                <td>{{$referred_partner->eng_requirement}}</td>
            </tr>
            <tr class="text-center">
                <th scope="row" colspan="2">Short Detail</th>
            </tr>
            <tr class="text-center">
                <td colspan="2">{{$referred_partner->short_detail}}</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('form-action')
    {{route('staff.partner.update-confirm')}}
@endsection

@section('form-inputs')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">University Name</th>
                <td>
                    <input type="text" name="uni-name" class="form-control mb-n4 @error('uni-name') is-invalid @enderror" value="{{old('uni-name') == null ? $referred_partner->name : old('uni-name')}}"><br>
                    @error('uni-name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th scope="row">Related Major Name</th>
                <td>
                    <div class="input-group">
                        <select class="custom-select @error('major') is-invalid @enderror" id="major-selection" name="major">
                            <option value=" ">Choose...</option>
                            @foreach ($all_majors as $major)
                                <option {{old('major') == null ? ($referred_partner->major->id == $major->id ? "selected" : "") : (old('major') == $major->id ? "selected" : "")}} value={{$major->id}}>{{$major->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('major')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th scope="row">Location</th>
                <td>
                    <input type="text" name="location" class="form-control mb-n4 @error('location') is-invalid @enderror" value="{{old('location') == null ? $referred_partner->location : old('location')}}"><br>
                    @error('location')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th scope="row">Minimum GPA</th>
                <td>
                    <input type="number" step=0.01 min=0 max=4 name="min-gpa" class="form-control mb-n4 @error('min-gpa') is-invalid @enderror" value="{{old('min-gpa') == null ? $referred_partner->min_gpa : old('min-gpa')}}"><br>
                    @error('min-gpa')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <th scope="row">English Proficiency Requirement</th>
                <td>
                    <input type="text" name="eng-proficiency" class="form-control mb-n5 @error('eng-proficiency') is-invalid @enderror" value="{{old('eng-proficiency') == null ? $referred_partner->eng_requirement : old('eng-proficiency')}}"><br>
                    @error('eng-proficiency')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr class="text-center">
                <th scope="row" colspan="2">Short Detail</th>
            </tr>
            <tr class="text-center">
                <td colspan="2">
                    <textarea name="details" class="form-control mb-n3 @error('details') is-invalid @enderror" rows="5">{{old('details') == null ? $referred_partner->short_detail : old('details')}}</textarea><br>
                    @error('details')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input class="btn btn-primary btn-block" type="submit" value="Confirm Update Partner">
                </td>
            </tr>
        </tbody>
    </table>
@endsection