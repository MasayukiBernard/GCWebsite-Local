@extends('student_side.csa_template.csa-template2')

@section('entity')
    Academic Information
@endsection

@section('form-action')
{{route('student.csa-form.after-page2')}}
@endsection

@section('return-route')
    {{route('student.csa-form.csa-page1')}}
@endsection

@section('form-inputs')

          <div class="form-group row pt-4">
               <label for="campus" class="col-md-4 col-form-label text-md-left">Campus</label>

               <div class="col-md-8">
                   <input id="campus" class="col-md-6 form-control @error('campus') is-invalid @enderror" type="text" name="campus"  value="{{old('campus', $academic_info->campus)}}">
                    @error('campus')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>

           <div class="form-group row">
               <label for="study_level" class="col-md-4 col-form-label text-md-left">Level of Study</label>
               <div class="col-md-8">
                    <input id="study_level" class="col-md-6 form-control @error('study_level') is-invalid @enderror" type="text" name="study_level" value="Undergraduate" disabled autofocus>
                    @error('study_level')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>

           <div class="form-group row">
               <label for="class" class="col-md-4 col-form-label text-md-left">Class</label>

               <div class="col-md-8">
                    <input id="class" class="col-md-6 form-control @error('study_level') is-invalid @enderror" type="text" name="class" value="Global Class" disabled autofocus>
                    @error('class')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>

           <div class="form-group row">
               <label for="major" class="col-md-4 col-form-label text-md-left">Major</label>

               <div class="col-md-8">
                    <select class="col-md-6 form-control @error('major') is-invalid @enderror" name="major">
                    <option value="" selected='selected'> - Select Major - </option>

                         @if(isset($majors))
                         @foreach($majors as $major)
                         <option value="{{$major->id}}" {{$academic_info->major_id == $major->id ? 'selected' : ""}}> {{$major->name}} </option>
                         @endforeach
                         @endif

                         </select>
                         @error('major')
                              <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
               </div>
           </div>

           <div class="form-group row">
               <label for="semester" class="col-md-4 col-form-label text-md-left">Semester</label>

               <div class="col-md-8">
                   <input id="semester" class="col-md-6 form-control @error('semester') is-invalid @enderror" type="number" name="semester" min="0" max="20" value="{{old('semester', $academic_info->semester)}}" autofocus >
                    @error('semester')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>

           <div class="form-group row">
               <label for="gpa" class="col-md-4 col-form-label text-md-left">GPA</label>

               <div class="col-md-8">
                   <input id="gpa" class="col-md-6 form-control @error('gpa') is-invalid @enderror" type="number" name="gpa" placeholder="1.0" step="0.01" min="0.00" max="4.00" value="{{old('gpa', $academic_info->gpa)}}" autofocus>
                    @error('gpa')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
                <label for="gpa_proof_path" class="col-md-4 col-form-label text-md-left">GPA Proof</label>
                <div class="col-md-8">
                     <input id="gpa_proof_path" class="col-md-6 form-control @error('gpa_proof_path') is-invalid @enderror" type="file" name="gpa_proof_path">
                     @error('gpa_proof_path')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
           </div>
           <div class="form-group row">
                <label for="test_type" class="col-md-4 col-form-label text-md-left">IELTS/TOEFL/Another test type</label>
                <div class="col-md-8">
                    <select class="col-md-6 form-control @error('test_type') is-invalid @enderror" name="test_type">
                    <option value="" selected='selected'> - Select Test Type - </option>
                         @if(isset($testtype))
                         @foreach($testtype as $test)
                         <option value="{{$test->test_type}}" {{$english_test->test_type == $test->test_type ? 'selected' : ""}}> {{$test->test_type}} </option>
                         @endforeach
                         @endif

                         </select>
                         @error('test_type')
                         <div class="alert alert-danger">{{ $message }}</div>
                         @enderror
                </div>
           </div>

           <div class="form-group row">
                <label for="score" class="col-md-4 col-form-label text-md-left">IELTS/TOEFL/Another test score</label>
                <div class="col-md-8">
                   <input id="score" class="col-md-6 form-control @error('score') is-invalid @enderror" type="number" name="score" placeholder="1.0" step="0.1" min="0.0" value="{{old('score', $english_test->score)}}" autofocus>
                    @error('score')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>

           <div class="form-group row">
                <label for="date" class="col-md-4 col-form-label text-md-left">IELTS/TOEFL/Another date</label>
                <div class="col-md-8">
                   <input id="date" class="col-md-6 form-control @error('date') is-invalid @enderror" type="date" name="date" value="{{old('date', $english_test->test_date)}}" autofocus>
                    @error('date')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
           </div>
           <div class="form-group row">
                <label for="proof_path" class="col-md-4 col-form-label text-md-left">IELTS/TOEFL/Another test proof</label>
                <div class="col-md-8">
                     <input id="proof_path" class="col-md-6 form-control @error('proof_path') is-invalid @enderror" type="file" name="proof_path">
                     @error('proof_path')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
           </div>
           <br>
           <h3 class="font-weight-bold">Passport Information</h3>
           <div class="form-group row">
               <label for="pass_num" class="col-md-4 col-form-label text-md-left">Passport Number</label>

               <div class="col-md-8">
                   <input id="pass_num" class="col-md-6 form-control @error('pass_num') is-invalid @enderror" type="text" name="pass_num" value="{{old('pass_num', $passport->pass_num)}}" autofocus>
                    @error('pass_num')
                     <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>
           </div>
           <div class="form-group row">
               <label for="pass_expiry" class="col-md-4 col-form-label text-md-left">Passport Expiration Date</label>

               <div class="col-md-8">
                   <input id="pass_expiry" class="col-md-6 form-control @error('pass_expiry') is-invalid @enderror" type="date" name="pass_expiry" value="{{old('pass_expiry', $passport->pass_expiry)}}" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('pass_expiry'))
                           {{       $errors->first('pass_expiry')}}
                        @endif
                        Minimum 6 months after CSA Completion
                   </span>
               </div>
           </div>
           <div class="form-group row">
                <label for="pass_proof_path" class="col-md-4 col-form-label text-md-left">Passport Attachment</label>
                <div class="col-md-8">
                     <input id="pass_proof_path" class="col-md-6 form-control @error('pass_proof_path') is-invalid @enderror" type="file" name="pass_proof_path">
                     @error('pass_proof_path')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
          </div>

@endsection

@section('confirm-value')
Next
@endsection