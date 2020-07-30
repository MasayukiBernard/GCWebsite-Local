@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h3">Dashboard</div>

                <div class="card-body">
                    @if ($user_verified)
                        <h5 class="m-0">You are logged in as a Student with a <span class="badge badge-pill badge-success">verified email</span> !</h5><br>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
