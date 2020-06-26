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
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                                            Delete
                                        </button>
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

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirm the deletion of '{{$referred_major->name}}' data!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-form').submit();">Confirm</button>
            </div>
        </div>
        </div>
    </div>
    <form id="delete-form" method="POST" action={{route('staff.major.delete')}}>
        @csrf
    </form>

@endsection