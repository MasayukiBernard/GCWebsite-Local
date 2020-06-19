@extends('layouts.app2')

@section('title')
    Create New Student(s)
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-11 border-bottom border-secondary text-center">
                            <h2>Create a Student</h2>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-11 justify-content-center text-center">
                            <table class="table table-borderless table-sm text-secondary">
                                <tbody>
                                    <tr>
                                        <td>Create one master student record.</td>
                                    </tr>
                                    <tr>
                                        <td>Determine every editable field for the new record.</td>
                                    </tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr>
                                        <td><a class="btn btn-success" href="{{route('staff.student.create-page-single')}}" role="button">Start Creating</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-11 border-bottom border-secondary text-center">
                            <h2>Create a Batch of Students</h2>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-11 text-center">
                            <table class="table table-borderless table-sm text-secondary">
                                <tbody>
                                    <tr>
                                        <td>Upload a tab delimited '.txt' file</td>
                                    </tr>
                                    <tr>
                                        <td><a onclick="event.preventDefault(); document.getElementById('download-form').submit();" href="download-batch-template">Download the template</a>, and insert the data as needed!</td>
                                    </tr>
                                    <tr>
                                        <td>Lastly, save the '.xlsx' file as a tab delimited '.txt' file.</td>
                                    </tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr>
                                        <td><a class="btn btn-success" href="{{route('staff.student.create-page-batch')}}" role="button">Upload the filled template</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="download-form" method="POST" action="{{route('staff.student.download-batch-template')}}">
    @csrf
</form>
@endsection