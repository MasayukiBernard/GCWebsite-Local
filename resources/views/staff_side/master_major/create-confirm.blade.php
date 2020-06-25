@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    New Major Creation
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">Major Name</th>
                <td>{{$inputted_major['major-name']}}</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('form-action')
    {{route('staff.major.create')}}
@endsection

@section('return-route')
    {{route('staff.major.create-page')}}
@endsection