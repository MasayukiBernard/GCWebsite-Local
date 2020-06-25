@extends('staff_side.crud_templates.confirm')

@section('entity-crud')
    Major Update
@endsection

@section('entity-distinct-content')
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">Old Data</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Major Name</th>
                                    <td>{{$referred_major->name}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header h2">New data</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Major Name</th>
                                    <td>{{$inputted_major['major-name']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('form-action')
    {{route('staff.major.update')}}
@endsection

@section('return-route')
    {{route('staff.major.edit-page', ['major' => $referred_major])}}
@endsection