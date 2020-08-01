@extends('layouts.app2')

@section('title')
    Create a CSA Application Form
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header h2">Create a Compulsory Study Abroad Application Form</div>
                <div class="card-body">
                    <div>
                        You do not have a CSA application form yet in <b>'{{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? 'Odd' : 'Even'}} Semester'</b> academic year!<br><br>
                        Do you want to create one ?
                        <form method="POST" action="{{route('student.csa-form.create')}}" class="d-inline">
                            @csrf
                            <input class="btn btn-primary px-2" type="submit" value="Yes, Create a CSA Application Form">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection