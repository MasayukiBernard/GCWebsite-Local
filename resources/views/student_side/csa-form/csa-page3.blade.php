@extends('student_side.csa_template.csa-template3')

@section('entity')
    Your Achievements &mdash; CSA Application Form Page 3
@endsection

@section('form-action')
{{route('student.csa-form.after-page3')}}
@endsection

@section('form-inputs')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2 pr-0 text-center">
                                <a class="font-weight-bold">No</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <a class="font-weight-bold">Achievement Name</a>
                            </div>
                            <div class="col-md-2 text-center">
                                <a class="font-weight-bold">Year</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <a class="font-weight-bold">Institution</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <a class="font-weight-bold">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @for($i = 0; $i < 3; $i++)
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-2 pr-0 text-center">
                                    <label for="achievement[]">{{ __($i + 1) }}</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="name_{{$i}}" class="col-md-12 form-control @error('name-' . $i) is-invalid @enderror" name="name-{{$i}}" onkeypress="changeUpdate();" value="{{old('name-' . $i, isset($achievements[$i]) ? $achievements[$i]->achievement : '')}}" autocomplete="off">
                                </div>
                                <div class="col-md-2">
                                    <input id="year_{{$i}}" class="col-md-12 form-control p-2 @error('year-' . $i) is-invalid @enderror" type="text" name="year-{{$i}}" onkeypress="changeUpdate();" value="{{old('year-' . $i, isset($achievements[$i]) ? $achievements[$i]->year : '')}}" autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <input id="institution_{{$i}}" class="col-md-12 form-control @error('institution-' . $i) is-invalid @enderror" type="text" name="institution-{{$i}}" onkeypress="changeUpdate();" value="{{old('institution-' . $i, isset($achievements[$i]) ? $achievements[$i]->institution : '')}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-2 pr-0"></div>
                                <div class="col-md-10 px-0 px-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="achievement_proof_file" class="custom-file">
                                                <input type="file" name="proof-path-{{$i}}" id="proof_path_{{$i}}" onchange="changeLabel('proof_path_label_{{$i}}', 'proof_path_{{$i}}'); changeUpdate();" class="custom-file-input @error('proof-path{{$i}}') is-invalid @enderror" style="cursor: pointer;">
                                                <label class="custom-file-label text-truncate" id="proof_path_label_{{$i}}" for="proof_path_{{$i}}">
                                                    @if(isset($achievements[$i]))
                                                        Change this achievement proof file
                                                    @else
                                                        Choose achievement proof file
                                                    @endif
                                                </label>
                                                <small class="file_size_notif" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @isset($achievements[$i])
                                            <div class="col-md-12">
                                                <a target="_blank" href="/student/{{$filemtimes[$i]}}/{{$ysid}}/image/achievement-proof/{{$proof_ids[$i]}}">See Existing Achievement Proof</a>
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="other_details_{{$i}}" style="resize: none;" rows="5" class="col-md-12 form-control @error('other-details-' . $i) is-invalid @enderror" name="other-details-{{$i}}" onkeypress="changeUpdate();">{{old('other-details-' . $i, isset($achievements[$i]) ? $achievements[$i]->other_details : '')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $inputs = array('name', 'year', 'institution', 'other-details', 'proof-path');?>
                    @for($j = 0; $j < 5; ++$j)
                        @error($inputs[$j]. '-' . $i)
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    @endfor
                    <hr>
                @endfor
                
                <div class="form-group row">
                    <div class="col-md-12">
                        <b>Note:</b><br>
                        Insert this form only if applicable and the occurence is during university period.<BR>
                        Please attach the copy of proof for the achievement(certificate/etc)!
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
@endsection

@section('return-route')
{{route('student.csa-form.csa-page2a')}}
@endsection

@section('confirm-value')
Update & Next &#x0226B;
@endsection

@section('next-value')
Next &#x0226B;
@endsection

@push('scripts')
    <script>
        function changeLabel(label_id, input_id){
            document.getElementById(label_id).innerHTML = document.getElementById(input_id).files[0].name;
        }

        function changeUpdate(){
            $('#next_btn').addClass('d-none');
            $('#submit_btn').removeClass('d-none');
        }
    </script>
@endpush

