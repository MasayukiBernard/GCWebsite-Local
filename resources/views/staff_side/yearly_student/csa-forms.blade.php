@extends('layouts.app2')

@section('title')
    Yearly Student's CSA Form
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header h2">{{$yearly_student->student->nim}}'s CSA Form in "{{$yearly_student->academic_year->starting_year}}/{{$yearly_student->academic_year->ending_year}} - {{$yearly_student->academic_year->odd_semester ? "Odd" : "Even"}}"</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td>{{$yearly_student->csa_form->is_submitted ? "Submitted" : "On Process"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Created at</th>
                                    <td>{{$yearly_student->csa_form->created_at}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><a href="{{route('staff.csa-forms.details', ['csa_form_id' => $yearly_student->csa_form->id])}}" role="button" class="btn btn-primary">See Details</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection