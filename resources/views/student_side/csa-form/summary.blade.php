@extends('layouts.app2')

@section('title')
    Summary &mdash; CSA Application Form
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header h2">
                    Summary &mdash; CSA Application Form
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <th class="h4 bg-info p-2" colspan="2">Status</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">CSA Form Status</th>
                                <td>{{$csa_form->is_submitted ? "Submitted" : "On Process"}}</td>
                            </tr>
                            <tr class="{{$csa_form->yearly_student->is_nominated ? "bg-success text-light" : ""}}">
                                <th scope="row">Nomination Status</th>
                                <td>{{$csa_form->yearly_student->is_nominated ? "Nominated" : "Not Yet Nominated"}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <th class="h4 bg-info p-2" colspan="2">Personal Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="align-middle">Profile Picture</th>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex align-items-center border border-dark rounded" style="height: 18vw; width: 18vw;">
                                            <img src="/photos/mt={{$filemtimes['pp']}}&ys=0&opt=profile-picture" style="max-width: 100%; max-height: 100%;" alt="profile picture" class="p-2">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">NIM</th>
                                <td>{{$student->nim}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{$student->user->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Gender</th>
                                <td>{{$student->gender === 'M' ? "Male" : "Female"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Place of Birth</th>
                                <td>{{$student->place_birth}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Birth</th>
                                <td>{{$student->date_birth}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nationality</th>
                                <td>{{$student->nationality}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email Address</th>
                                <td>{{$student->user->email}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile Phone Number</th>
                                <td>0{{$student->user->mobile}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Telephone Number</th>
                                <td>0{{$student->user->telp_num}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mailing Address</th>
                                <td>{{$student->address}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <th class="h4 bg-info p-2" colspan="2">Academic Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Campus</th>
                                <td>{{$csa_form->academic_info->campus}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Study Level</th>
                                <td>{{$csa_form->academic_info->study_level === 'U' ? "Undergraduate" : "Graduate"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Class</th>
                                <?php $classes = array('Global Class');?>
                                <td>{{$classes[$csa_form->academic_info->class]}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Major</th>
                                <td>{{$student->major->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Binusian Year</th>
                                <td>{{$student->binusian_year}}</td>
                            </tr>
                            <tr>
                                <th scope="row">GPA</th>
                                <td>{{$csa_form->academic_info->gpa}} / 4.00</td>
                            </tr>
                            <tr>
                                <th scope="row">GPA Transcript Proof</th>
                                <td>
                                    <a target="_blank" href="{{route('student.see-image', ['last_modified' => $filemtimes['gpa_trans'], 'yearly_student_id' => $ysid, 'requested_image' => 'gpa-transcript-proof'])}}">See Image</a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">English Proficiency Test Type / Score</th>
                                <td>{{$csa_form->english_test->test_type}} / {{$csa_form->english_test->score}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Test Date</th>
                                <td>{{$csa_form->english_test->test_date}}</td>
                            </tr>
                            <tr>
                                <th scope="row">English Test Result Proof</th>
                                <td>
                                    <a target="_blank" href="{{route('student.see-image', ['last_modified' => $filemtimes['english_test'], 'yearly_student_id' => $ysid, 'requested_image' => 'english-test-result'])}}">See Image</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <th class="h4 bg-info p-2" colspan="4">Passport Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Passport Number</th>
                                <td>{{$csa_form->passport->pass_num}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Passport Expiration Date</th>
                                <td>{{$csa_form->passport->pass_expiry}}</td>
                            </tr>
                            <tr>    
                                <th scope="row">Passport Proof</th>
                                <td>
                                    <a target="_blank" href="{{route('student.see-image', ['last_modified' => $filemtimes['passport'], 'yearly_student_id' => $ysid, 'requested_image' => 'passport'])}}">See Image</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="h4 bg-info p-2" colspan="2">Academic Achievements / Awards</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0;?>
                            @foreach ($csa_form->achievements as $achievement)
                                <tr>
                                    <th class="h5 text-center" colspan="2">Achievement #{{$i}}</th>
                                </tr>
                                <tr>
                                    <th scope="row">Name</th>
                                    <td>{{$achievement->achievement}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Year</th>
                                    <td>{{$achievement->year}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Institution</th>
                                    <td>{{$achievement->institution}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Other Details</th>
                                    <td>{{$achievement->other_details}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Achievement Proof</th>
                                    <td>
                                        <a target="_blank" href="{{route('student.see-image', ['last_modified' => $filemtimes['achievements'][$i], 'yearly_student_id' => $ysid, 'requested_image' => 'achievement-proof', 'optional_id' => $ac_ids[$i++]])}}">See Image</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm" id="application_details">
                        <thead>
                            <th class="h4 bg-info p-2" colspan="4">Application Details</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" colspan="1">Study Period</th>
                                <td colspan="3">{{$academic_year->odd_semester ? "Odd" : "Even"}} Semester</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="1">Year</th>
                                <td colspan="3">{{$academic_year->starting_year}}/{{$academic_year->ending_year}}</td>
                            </tr>
                            <tr class="uni_nomination">
                                <th class="align-middle" scope="row" rowspan="4">
                                    Partner University Choices<br>
                                    (Sorted Ascendingly by Priority)
                                </th>
                                <th class="text-center" scope="col">Name</th>
                                <th class="text-center" scope="col">Major Name</th>
                                @if ($csa_form->yearly_student->is_nominated)
                                    <th class="text-center" scope="col">Status</th>
                                @else
                                    <th class="text-center" scope="col">Nominated to</th>
                                @endif
                            </tr>
                            <?php $choices_count = 0?>
                            @foreach ($csa_form->choices as $key => $choice)
                                @if ($choice->nominated_to_this)
                                    <tr class="text-center uni_nomination bg-success">
                                @else
                                    <tr class="text-center uni_nomination">
                                @endif
                                    <td class="align-middle">{{$choice->yearly_partner->partner->name}}</td>
                                    <td class="align-middle">{{$choice->yearly_partner->partner->major->name}}</td>
                                    <td class="align-middle">
                                        @if ($csa_form->yearly_student->is_nominated)
                                            @if ($choice->nominated_to_this)
                                                <b><<<  Nominated to This</b>
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <?php ++$choices_count?>
                            @endforeach
                            @for($choices_count; $choices_count < 3; ++$choices_count)
                                <tr>
                                    <td class="py-3"></td>
                                    <td class="py-3"></td>
                                    <td class="py-3"></td>
                                </tr>
                            @endfor
                            <tr>
                                <th scope="col" class="text-center" colspan="4">Motivations</th>
                            </tr>
                            @foreach ($csa_form->choices as $choice)
                                <tr>
                                    <th scope="row" coslpan="2" class="text-center" colspan="1">{{$choice->yearly_partner->partner->name}}</th>
                                    <td colspan="3">{{$choice->motivation}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="h4 bg-info p-2" colspan="4">Emergency Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" colspan="2">Name</th>
                                <td colspan="2">Mr{{$csa_form->emergency->gender === 'M' ? "" : "s"}}. {{$csa_form->emergency->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="2">Relationship</th>
                                <td colspan="2">{{$csa_form->emergency->relationship}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="2">Address</th>
                                <td colspan="2">{{$csa_form->emergency->address}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Telephone Number</th>
                                <td>0{{$csa_form->emergency->telp_num}}</td>
                                <th scope="row">Mobile Phone Number</th>
                                <td>0{{$csa_form->emergency->mobile}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="2">Email Address</th>
                                <td colspan="2">{{$csa_form->emergency->email}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="h4 bg-info p-2" colspan="2">Medical, Dietary and Other Information</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Have any disability or Medical Condtion</th>
                                <td>{{$csa_form->condition->med_condition ? "Yes" : "No"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Have any allergy(s)</th>
                                <td>{{$csa_form->condition->allergy ? "Yes" : "No"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Special dietary requirement(s)</th>
                                <td>{{$csa_form->condition->special_diet? "Yes" : "No"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Have ever convicted crime(s)</th>
                                <td>{{$csa_form->condition->convicted_crime ? "Yes" : "No"}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Have any possible future difficulties</th>
                                <td>{{$csa_form->condition->future_diffs ? "Yes" : "No"}}</td>
                            </tr>
                            <tr>
                                <th scope="row" colspan="2">Reasons</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$csa_form->condition->reasons}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection