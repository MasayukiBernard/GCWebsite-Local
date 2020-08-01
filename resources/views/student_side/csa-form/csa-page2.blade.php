@extends('student_side.csa_template.csa-template2')

@section('entity')
     Academic Information &mdash; CSA Application Form Page 2
@endsection

@section('form-action')
{{route('student.csa-form.after-page2')}}
@endsection

@section('return-route')
{{route('student.csa-form.csa-page1')}}
@endsection

@section('form-inputs')
     <hr>
     <div class="form-group row mt-4">
          <label for="major" class="col-md-4 col-form-label text-md-left font-weight-bold">Major</label>
          <div class="col-md-5">
               <input type="text" class="form-control" disabled value="{{$major}}">
               <small class="form-text text-muted m-0">***Retrieved from your profile!</small>
          </div>
          <div class="col-md-3 py-2 px-0">
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="campus" class="col-md-4 col-form-label text-md-left font-weight-bold">Campus</label>
          <div class="col-md-8">
               <div class="custom-control custom-radio">
                    <input type="radio" id="alsut" name="campus" class="custom-control-input" onclick="changeUpdate();" value="0" {{old('campus') != null ? (old('campus') == '0' ? 'checked' : '') : ($academic_info != null ? ($academic_info->campus == 'Alam Sutera' ? 'checked' : '') : '')}}>
                    <label class="custom-control-label" for="alsut">Alam Sutera</label>
               </div>
               <div class="custom-control custom-radio">
                    <input type="radio" id="kmg" name="campus" class="custom-control-input" onclick="changeUpdate();" value="1" {{old('campus') != null ? (old('campus') == '1' ? 'checked' : '') : ($academic_info != null ? ($academic_info->campus == 'Kemanggisan' ? 'checked' : '') : '')}}>
                    <label class="custom-control-label" for="kmg">Kemanggisan</label>
               </div>
               @error('campus')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="study_level" class="col-md-4 col-form-label text-md-left font-weight-bold">Level of Study</label>
          <div class="col-md-8">
               <div class="custom-control custom-radio">
                    <input type="radio" id="undergraduate" name="study-level" class="custom-control-input" onclick="changeUpdate();" value="U" {{old('study-level') != null ? (old('study-level') == 'U' ? 'checked' : '') : ($academic_info != null ? ($academic_info->study_level == 'U' ? 'checked' : '') : '')}}>
                    <label class="custom-control-label" for="undergraduate">Undergraduate</label>
               </div>
               <div class="custom-control custom-radio">
                    <input type="radio" id="graduate" name="study-level" class="custom-control-input" onclick="changeUpdate();" value="G" {{old('study-level') != null ? (old('study-level') != 'U' ? 'checked' : '') : ($academic_info != null ? ($academic_info->study_level != 'U' ? 'checked' : '') : '')}}>
                    <label class="custom-control-label" for="graduate">Graduate</label>
               </div>
               @error('study-level')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="class" class="col-md-4 col-form-label text-md-left font-weight-bold">Class</label>
          <div class="col-md-8">
               <?php $classes = array('Global Class');?>
               <input id="class" class="col-md-12 form-control @error('study_level') is-invalid @enderror" type="text" name="class" value="{{$academic_info != null ? $classes[$academic_info->class] : 'Global Class'}}" disabled>
               <small class="form-text text-muted m-0">***Class field is auto-picked!</small>
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="semester" class="col-md-4 col-form-label text-md-left font-weight-bold">Semester</label>
          <div class="col-md-4">
               <input id="semester" class="col-md-12 form-control @error('semester') is-invalid @enderror" type="number" name="semester" min="0" max="14" onkeypress="changeUpdate();" onchange="changeUpdate();" value="{{old('semester', $academic_info != null ? $academic_info->semester : '')}}">
               <small class="form-text text-muted m-0">Value must be in the range of [1 - 14]!</small>
               @error('semester')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="gpa" class="col-md-4 col-form-label text-md-left font-weight-bold">GPA</label>
          <div class="col-md-4">
               <input id="gpa" class="col-md-12 form-control @error('gpa') is-invalid @enderror" type="number" name="gpa" step="0.01" min="0.00" max="4.00" onkeypress="changeUpdate();" onchange="changeUpdate();" value="{{old('gpa', $academic_info != null ? $academic_info->gpa : '')}}">
               <small class="form-text text-muted m-0">Value must be in the range of [0.00 - 4.00]</small>
               @error('gpa')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="gpa_proof_path" class="col-md-4 col-form-label text-md-left font-weight-bold">GPA Proof</label>
          <div class="col-md-8">
               @isset($academic_info)
                    <div>
                         <a target="_blank" href="/student/{{$filemtimes['gpa']}}/{{$ysid}}/image/gpa-transcript-proof">See Existing GPA Transcript Proof</a>
                    </div>
               @endisset
               <div id="gpa_proof_file" class="custom-file">
                    <input type="file" name="gpa-proof" id="gpa_proof" onchange="changeLabel('gpa_proof_label', 'gpa_proof'); changeUpdate();" class="custom-file-input @error('gpa-proof') is-invalid @enderror" style="cursor: pointer;">
                    <label class="custom-file-label" id="gpa_proof_label" for="gpa_proof">
                         @if(isset($academic_info))
                              Change existing GPA transcript proof picture file
                         @else
                              Choose GPA transcript proof picture file
                         @endif
                    </label>
                    <small class="file_size_notif" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
               </div>
               @error('gpa-proof')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="test-type" class="col-md-4 col-form-label text-md-left font-weight-bold">English Test Type</label>
          <div class="col-md-8">
               <div class="custom-control custom-radio">
                    <input type="radio" id="IELTS" name="test-type" onclick="clearOther(); changeUpdate();" class="custom-control-input" value="0" {{old('test-type') != null ? (old('test-type') == '0' ? 'checked' : '') : ($english_test != null ? ($english_test->test_type == 'IELTS' ? 'checked' : '') : '')}}>
                    <label class="custom-control-label" for="IELTS">IELTS</label>
               </div>
               <div class="custom-control custom-radio">
                    <input type="radio" id="TOEFL" name="test-type" onclick="clearOther(); changeUpdate();" class="custom-control-input" value="1" {{old('test-type') != null ? (old('test-type') == '1' ? 'checked' : '') : ($english_test != null ? ($english_test->test_type == 'TOEFL' ? 'checked' : '') : '')}}>
                    <label class="custom-control-label" for="TOEFL">TOEFL</label>
               </div>
               <div>
                    Other: <input id="other_test" class="col-md-6 ml-2 d-inline form-control" placeholder="Other Test Type" onkeypress="changeUpdate();" onclick="uncheckRB('IELTS', 'TOEFL');" type="text" name="other-test" value="{{old('other-test') != null ? old('other-test') : ''}}">
               </div>
               @error('test-type')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
               @error('other-test')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="score" class="col-md-4 col-form-label text-md-left font-weight-bold">English Test Score</label>
          <div class="col-md-4">
               <input id="score" class="col-md-12 form-control @error('score') is-invalid @enderror" type="number" name="score" step="0.1" min="0.0" onkeypress="changeUpdate();" onchange="changeUpdate();" value="{{old('score', $english_test != null ? $english_test->score : '')}}">
               @error('score')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="date" class="col-md-4 col-form-label text-md-left font-weight-bold">English Test Date of Occurence</label>
          <div class="col-md-8">
          <input id="date" class="col-md-12 form-control @error('test-date') is-invalid @enderror" type="text" placeholder="Format: YYYY-MM-DD" name="test-date" onkeypress="changeUpdate();" value="{{old('test-date', $english_test != null ? $english_test->test_date : '')}}">
          @error('test-date')
               <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="proof_path" class="col-md-4 col-form-label text-md-left font-weight-bold">English Test Proof</label>
          <div class="col-md-8">
               @isset($english_test)
                    <div>
                         <a target="_blank" href="/student/{{$filemtimes['e-test']}}/{{$ysid}}/image/english-test-result">See Existing English Test Result Proof</a>
                    </div>
               @endisset
                <div id="gpa_proof_file" class="custom-file">
                    <input type="file" name="proof-path" id="proof_path" onchange="changeLabel('proof_path_label', 'proof_path'); changeUpdate();" class="custom-file-input @error('proof-path') is-invalid @enderror" style="cursor: pointer;">
                    <label class="custom-file-label" id="proof_path_label" for="proof_path">
                         @if(isset($academic_info))
                              Change existing English test result proof picture file
                         @else
                              Choose English test result proof picture file
                         @endif
                    </label>
                    <small class="file_size_notif" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
                </div>
               @error('proof-path')
               <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
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

          function uncheckRB(first, second){
               document.getElementById(first).checked = false;
               document.getElementById(second).checked = false;
          }

          function clearOther(){
               document.getElementById('other_test').value = '';
          }

          function changeUpdate(){
               $('#next_btn').addClass('d-none');
               $('#submit_btn').removeClass('d-none');
          }
     </script>
@endpush