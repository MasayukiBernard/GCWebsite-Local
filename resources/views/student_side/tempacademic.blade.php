@extends('layouts.app3')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
      
        <div class="col-md-12">
         <h3 class="font-weight-bold">Your Academic Information</h3>
         <form method="post" action="/tempacademic" id="form1" enctype="multipart/form-data">
          @csrf
           <div class="form-group row pt-4">
               <label for="campus" class="col-md-4 col-form-label text-md-left">{{ __('Campus') }}</label>

               <div class="col-md-8">
                   <input id="campus" class="col-md-6 form-control @error('campus') is-invalid @enderror" type="text" name="campus" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('campus'))
                           {{       $errors->first('campus')}}
                        @endif
                   </span>
               </div>
           </div>

           <div class="form-group row">
               <label for="study_level" class="col-md-4 col-form-label text-md-left">{{ __('Level Study') }}</label>

               <div class="col-md-8">
                    <input id="study_level" class="col-md-6 form-control @error('study_level') is-invalid @enderror" type="text" name="study_level" value="Undergraduate" disabled autofocus>
                    <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('study_level'))
                           {{       $errors->first('study_level')}}
                        @endif
                    </span>
               </div>
           </div>

           <div class="form-group row">
               <label for="class" class="col-md-4 col-form-label text-md-left">{{ __('Class') }}</label>

               <div class="col-md-8">
                    <input id="class" class="col-md-6 form-control @error('study_level') is-invalid @enderror" type="text" name="class" value="Global Class" disabled autofocus>
                    <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('class'))
                           {{       $errors->first('class')}}
                        @endif
                    </span>
               </div>
           </div>

           <div class="form-group row">
               <label for="major" class="col-md-4 col-form-label text-md-left">{{ __('Major') }}</label>

               <div class="col-md-8">
                    <select class="col-md-6 form-control @error('major') is-invalid @enderror" name="major">
                    <option value="" selected='selected'> - Select Major - </option>
                         @if(isset($majors))
                         @foreach($majors as $ft)
                         <option value={{$ft->name}}> {{$ft->name}} </option>
                         @endforeach
                         @endif

                         </select>
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('major'))
                              {{       $errors->first('major')}}
                         @endif
                         </span>
               </div>
           </div>

           <div class="form-group row">
               <label for="semester" class="col-md-4 col-form-label text-md-left">{{ __('Semester') }}</label>

               <div class="col-md-8">
                   <input id="semester" class="col-md-6 form-control @error('semester') is-invalid @enderror" type="number" name="semester" min="0" max="20" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('semester'))
                           {{       $errors->first('semester')}}
                        @endif
                   </span>
               </div>
           </div>

           <div class="form-group row">
               <label for="gpa" class="col-md-4 col-form-label text-md-left">{{ __('GPA') }}</label>

               <div class="col-md-8">
                   <input id="gpa" class="col-md-6 form-control @error('gpa') is-invalid @enderror" type="number" name="gpa" placeholder="1.0" step="0.01" min="0.00" max="4.00" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('gpa'))
                           {{       $errors->first('gpa')}}
                        @endif
                        Minimum 2.00 from 4.00
                   </span>
               </div>
           </div>
           <div class="form-group row">
                <label for="gpa_proof_path" class="col-md-4 col-form-label text-md-left">{{ __('GPA proof') }}</label>
                <div class="col-md-8">
                     <input id="gpa_proof_path" class="col-md-6 form-control @error('gpa_proof_path') is-invalid @enderror" type="file" name="gpa_proof_path">
                     <span class="col-md-9" style="color:red; font-weight:bold">
                          @if($errors->has('gpa_proof_path'))
                             {{       $errors->first('gpa_proof_path')}}
                          @endif
                     </span>
                </div>
           </div>
           <div class="form-group row">
                <label for="test_type" class="col-md-4 col-form-label text-md-left">{{ __('IELTS/TOEFL/Another test type') }}</label>
                <div class="col-md-8">
                    <select class="col-md-6 form-control @error('test_type') is-invalid @enderror" name="test_type">
                    <option value="" selected='selected'> - Select Test Type - </option>
                         @if(isset($testtype))
                         @foreach($testtype as $ft)
                         <option value={{$ft->test_type}}> {{$ft->test_type}} </option>
                         @endforeach
                         @endif

                         </select>
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('test_type'))
                              {{       $errors->first('test_type')}}
                         @endif
                         </span>
                </div>
           </div>

           <div class="form-group row">
                <label for="score" class="col-md-4 col-form-label text-md-left">{{ __('IELTS/TOEFL/Another test score') }}</label>
                <div class="col-md-8">
                   <input id="score" class="col-md-6 form-control @error('score') is-invalid @enderror" type="number" name="score" placeholder="1.0" step="0.1" min="0.0" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('score'))
                           {{       $errors->first('score')}}
                        @endif
                   </span>
                </div>
           </div>

           <div class="form-group row">
                <label for="date" class="col-md-4 col-form-label text-md-left">{{ __('IELTS/TOEFL/Another date') }}</label>
                <div class="col-md-8">
                   <input id="date" class="col-md-6 form-control @error('date') is-invalid @enderror" type="date" name="date" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('date'))
                           {{       $errors->first('date')}}
                        @endif
                   </span>
                </div>
           </div>
           <div class="form-group row">
                <label for="proof_path" class="col-md-4 col-form-label text-md-left">{{ __('IELTS/TOEFL/Another test proof') }}</label>
                <div class="col-md-8">
                     <input id="proof_path" class="col-md-6 form-control @error('proof_path') is-invalid @enderror" type="file" name="proof_path">
                     <span class="col-md-9" style="color:red; font-weight:bold">
                          @if($errors->has('proof_path'))
                             {{       $errors->first('proof_path')}}
                          @endif
                     </span>
                </div>
           </div>
           <h3 class="font-weight-bold">Passport Information</h3>
           <div class="form-group row">
               <label for="pass_num" class="col-md-4 col-form-label text-md-left">{{ __('Passport Number') }}</label>

               <div class="col-md-8">
                   <input id="pass_num" class="col-md-6 form-control @error('pass_num') is-invalid @enderror" type="text" name="pass_num" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('pass_num'))
                           {{       $errors->first('pass_num')}}
                        @endif
                   </span>
               </div>
           </div>
           <div class="form-group row">
               <label for="pass_expiry" class="col-md-4 col-form-label text-md-left">{{ __('Passport Expiration Date') }}</label>

               <div class="col-md-8">
                   <input id="pass_expiry" class="col-md-6 form-control @error('pass_expiry') is-invalid @enderror" type="date" name="pass_expiry" autofocus>
                   <span class="col-md-9" style="color:red; font-weight:bold">
                        @if($errors->has('pass_expiry'))
                           {{       $errors->first('pass_expiry')}}
                        @endif
                        Minimum 6 months after CSA Completion
                   </span>
               </div>
           </div>
           <div class="form-group row">
                <label for="pass_proof_path" class="col-md-4 col-form-label text-md-left">{{ __('Passport Picture Attachment') }}</label>
                <div class="col-md-8">
                     <input id="pass_proof_path" class="col-md-6 form-control @error('pass_proof_path') is-invalid @enderror" type="file" name="pass_proof_path">
                     <span class="col-md-9" style="color:red; font-weight:bold">
                          @if($errors->has('pass_proof_path'))
                             {{       $errors->first('pass_proof_path')}}
                          @endif
                     </span>
                </div>
           </div>
         </form>
           <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/homepage' type="button px-2" class="btn btn-primary">Back</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempachievements' type="button px-2" class="btn btn-primary next">Next &raquo;</button>
		           </div>
	            </div>
           </div>
        </div>

    </div>
</div>
@endsection
