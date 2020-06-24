@extends('layouts.app2')

@section('title')
    Master Major
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">Master Major</div>
                    <div class="card-body">
                    <a class="btn btn-success text-light" role="button" href={{route('staff.major.create-page')}}>Add New Major</a>
                    <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Major Name</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach($majors as $major)
                                <tr>
                                    <th>{{$major->id}}</th>
                                    <th>{{$major->name}}</th>
                                    <th>
                                        <a class="btn btn-primary text-light" role="button" href={{route('staff.major.edit-page', ['major' => $major])}}>Edit</a>
                                    </th>
                                    <th>
                                        <a class="btn btn-danger text-light" role="button" href="staff/major/delete/{{$major->id}}">Delete</a>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>                         
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection