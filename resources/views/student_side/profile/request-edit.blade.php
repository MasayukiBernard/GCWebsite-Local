@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header h2">Request a Profile Edit</div>
                <div class="card-body">
                    <form method="POST" action="{{route('student.profile-request-edit')}}">
                        @csrf
                        <div class="form-group">
                            <div class="text-center h4"><label for="desc">State descriptively your reasons to edit the profile that you have finalized!</label></div>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="desc" rows="5" name="description" placeholder="Type your reasons here!"></textarea>
                            @error('description')
                                <div class="alert alert-danger m-0 mt-1">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                <div class="col">
                                    <small>Your request will be notified to the staffs, please wait for its approval!</small>
                                </div>
                                <div class="col text-right mt-2">
                                    <input class="btn btn-primary" type="submit" value="Submit Request">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection