@extends('layouts.app2')

@section('title')
    CSA Application Forms
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h2>CSA Application Forms</h2>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td>Academic Year</td>
                                <td>
                                    : {{$academic_year->starting_year}}/{{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd" : "Even"}}
                                </td>
                            </tr>
                            <tr>
                                <td>Major</td>
                                <td>: {{$major->name}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th scope="col">No</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Name</th>
                                <th scope="col">CSA Form Status</th>
                                <th scope="col">CSA Form Created At</th>
                                <th scope="col">Nomination Status</th>
                            </thead>
                            <?php $i = 0;?>
                            <tbody>
                                @foreach ($yearly_students as $yearly_student)
                                    <tr onclick="window.location.assign('/staff/csa-forms/details/{{$yearly_student->csa_form->id}}');" style="cursor: pointer;">
                                        <th scope="row">{{++$i}}</th>
                                        <td>{{$yearly_student->student->nim}}</td>
                                        <td>{{$yearly_student->student->user->name}}</td>
                                        <td>{{$yearly_student->csa_form->is_submitted ? "Submitted" : "On Process"}}</td>
                                        <td>{{$yearly_student->csa_form->created_at == null ? "Null" : $yearly_student->csa_form->created_at}}</td>
                                        <td>{{$yearly_student->is_nominated ? "Nominated" : "Not Yet Nominated"}}</td>
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

