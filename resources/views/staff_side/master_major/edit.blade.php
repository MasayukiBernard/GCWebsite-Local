@extends('staff_side.crud_templates.update')

@section('entity')
    Major
@endsection

@section('form-action')
    {{route('staff.major-update')}}
@endsection

@section('old-data')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">Major Name</th>
                <td>{{$major->name}}</td>
            </tr>
            </tbody>
    </table>
@endsection

@section('form-inputs')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">Major Name</th>
                <td>
                    <input type="text" name="major-name" class="@error('major-name') is-invalid @enderror" value="{{$major->name}}"><br>
                    @error('major-name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input class="btn btn-primary btn-block" type="submit" value="Update Major">
                </td>
            </tr>
        </tbody>
    </table>
@endsection