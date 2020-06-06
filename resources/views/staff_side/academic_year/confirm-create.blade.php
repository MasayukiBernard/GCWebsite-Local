@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    New Academic Year    
@endsection

@section('form-action')
    {{route('staff.academic-year.create')}}
@endsection

@section('entity-distinct-content')
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">Starting Year</th>
                <td>{{$inputtedData['start-year']}}</td>
            </tr>
            <tr>
                <th scope="row">Ending Year</th>
                <td>{{$inputtedData['end-year']}}</td>
            </tr>
            <tr>
                <th scope="row">Semester Type</th>
                <td>{{$inputtedData['smt-type'] ? "Odd" : "Even"}}</td>
            </tr>
        </tbody>
    </table>
@endsection

@section('return-route')
    {{route('staff.academic-year.create-page')}}
@endsection