@extends('layouts.app2')

@section('title')
    CSA Application Form Details
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header h2">
                        <table class="table table-borderless w-auto mb-0">
                            <tr>
                                <td class="p-0 pr-2">{{$csa_form->yearly_student->academic_year->starting_year}}/{{$csa_form->yearly_student->academic_year->ending_year}} - {{$csa_form->yearly_student->academic_year->odd_semester ? "Odd" : "Even"}}</td>
                                <td class="p-0 pl-2 border-left border-dark">{{$csa_form->yearly_student->student->nim}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body">
                        @if ($csa_form->is_submitted)
                            @if (!($csa_form->yearly_student->is_nominated))
                                <a class="btn btn-success mb-2" href="#application_details" role="button" onclick="blink_bg();">Nominate This Application</a>
                            @else
                                <button type="button" class="btn btn-danger mb-2" data-toggle="modal" data-target="#cancelNominationModal">
                                    Cancel Nomination
                                </button>
                            @endif
                        @endif
                            
                        <table class="table table-bordered table-sm">
                            <thead>
                                <th class="h4 bg-info" colspan="2">Status</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">CSA Form Status</th>
                                    <td>{{$csa_form->is_submitted ? "Submitted" : "On Process"}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nomination Status</th>
                                    <td>{{$csa_form->yearly_student->is_nominated ? "Nominated" : "Not Yet Nominated"}}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if ($csa_form->is_submitted)
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <th class="h4 bg-info" colspan="2">Personal Information</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center" colspan="2">
                                            <img src="/photos/users_id={{$csa_form->yearly_student->student->user_id}}&opt=picture_path" class="img-thumbnail" width="25%">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">NIM</th>
                                        <td>{{$csa_form->yearly_student->student->nim}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{$csa_form->yearly_student->student->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Gender</th>
                                        <td>{{$csa_form->yearly_student->student->gender === 'M' ? "Male" : "Female"}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Place of Birth</th>
                                        <td>{{$csa_form->yearly_student->student->place_birth}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Birth</th>
                                        <td>{{$csa_form->yearly_student->student->date_birth}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nationality</th>
                                        <td>{{$csa_form->yearly_student->student->nationality}}</td>
                                    </tr>
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
                                            <a target="_blank" href="{{route('see-image', ['table_name' => 'passports', 'id' => $csa_form->id, 'column_name' => 'pass_proof_path'])}}">See Image</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered table-sm">
                                <thead>
                                    <th class="h4 bg-info" colspan="4">Contact Information</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" colspan="2">Email Address</th>
                                        <td colspan="2">{{$csa_form->yearly_student->student->user->email}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Mobile Phone Number</th>
                                        <td>0{{$csa_form->yearly_student->student->user->mobile}}</td>
                                        <th scope="row">Telephone Number</th>
                                        <td>0{{$csa_form->yearly_student->student->user->telp_num}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2">Mailing Address</th>
                                        <td colspan="2">{{$csa_form->yearly_student->student->address}}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered table-sm" id="application_details">
                                <thead>
                                    <th class="h4 bg-info" colspan="4">Application Details</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row" colspan="1">Study Period</th>
                                        <td colspan="3">{{$csa_form->yearly_student->academic_year->odd_semester ? "Odd" : "Even"}} Semester</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="1">Year</th>
                                        <td colspan="3">{{$csa_form->yearly_student->academic_year->starting_year}}/{{$csa_form->yearly_student->academic_year->ending_year}}</td>
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
                                            <th class="text-center" scope="col">Nominate to</th>
                                        @endif
                                    </tr>
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
                                                        <<< Nominated to This
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    <button type="button" class="btn btn-success" onclick="confirm_nomination({{$choice->id}});">
                                                        <<< This
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
                                    <th class="h4 bg-info" colspan="2">Academic Information</th>
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
                                        <td>{{$csa_form->academic_info->class}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Major</th>
                                        <td>{{$csa_form->yearly_student->student->major->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Binusian Year</th>
                                        <td>{{$csa_form->yearly_student->student->binusian_year}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">GPA</th>
                                        <td>{{$csa_form->academic_info->gpa}} / 4.00</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">GPA Transcript Proof</th>
                                        <td>
                                            <a target="_blank" href="{{route('see-image', ['table_name' => 'academic_infos', 'id' => $csa_form->id, 'column_name' => 'gpa_proof_path'])}}">See Image</a>
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
                                            <a target="_blank" href="{{route('see-image', ['table_name' => 'english_tests', 'id' => $csa_form->id, 'column_name' => 'proof_path'])}}">See Image</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="h4 bg-info" colspan="2">Academic Achievements / Awards</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;?>
                                    @foreach ($csa_form->achievements as $achievement)
                                        <tr>
                                            <th class="h5 text-center" colspan="2">Achievement #{{++$i}}</th>
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
                                                <a target="_blank" href="{{route('see-image', ['table_name' => 'achievements', 'id' => $achievement->id, 'column_name' => 'proof_path'])}}">See Image</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="h4 bg-info" colspan="4">Emergency Contact</th>
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
                                        <th class="h4 bg-info" colspan="2">Medical, Dietary and Other Information</th>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!($csa_form->yearly_student->is_nominated))
        <div class="modal fade" id="nominationModal" tabindex="-1" role="dialog" aria-labelledby="nominationModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nominate This Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Do you want to nominate "<span id="nomination_subject"></span>" in "<span id="nomination_academic_year"></span>" to "<span id="nomination_partner"></span>"?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="document.getElementById('nominate-form').submit();">Yes</button>
                </div>
            </div>
            </div>
        </div>

        <form id="nominate-form" method="POST" action="{{route('staff.csa-forms.nominate')}}">
            @csrf
        </form>
    @else
        <div class="modal fade" id="cancelNominationModal" tabindex="-1" role="dialog" aria-labelledby="cancelNominationModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Nomination of This Application</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    Do you want to cancel "{{$csa_form->yearly_student->student->nim}} - {{$csa_form->yearly_student->student->user->name}}"'s nomination'?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('cancel-form').submit();">Yes</button>
                </div>
            </div>
            </div>
        </div>

        <form id="cancel-form" method="POST" action="{{route('staff.csa-forms.cancel-nomination', ['csa_form_id' => $csa_form->id])}}">
            @csrf
        </form>
    @endif
@endsection

@if (!($csa_form->yearly_student->is_nominated))
    @push('scripts')
        <script>
            function blink_bg(){
                $(".uni_nomination").animate({opacity: '0%'}, 0);
                $('.uni_nomination').addClass('bg-warning');
                setTimeout(function(){
                    $(".uni_nomination").animate({opacity: '100%'}, 333);
                    $(".uni_nomination").animate({opacity: '0%'}, 333);
                }, 100);
                setTimeout(function(){
                    $('.uni_nomination').removeClass('bg-warning');
                    $(".uni_nomination").animate({opacity: '100%'}, 500);
                },800);
            }
            
            function confirm_nomination(choice_id){
                var csa_form_id = {{$csa_form->id}};
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var targetURL = "/staff/csa-forms/" + csa_form_id + "/choice/" + choice_id + "/confirm-nomination";
                $.ajax({
                    type: 'POST',
                    url: targetURL,
                    data: {_token: CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function(response_data){
                        if(response_data['failed'] === false){
                            $('#nomination_subject').text(response_data['nim_name']);
                            $('#nomination_academic_year').text(response_data['academic_year']);
                            $('#nomination_partner').text(response_data['partner_name']);
                            $('#nominationModal').modal();
                        }
                    }
                });
            }
        </script>
    @endpush
@endif