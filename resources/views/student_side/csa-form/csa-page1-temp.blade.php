<@extends('layouts.app3')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
         <h3 class="font-weight-bold">Special Personal Information</h3>
         <form method="post" action="/tempcondition" id="form5" enctype="multipart/form-data">
          @csrf
 
           <div class="form-group row pt-4 px-2">
               <label for="med_condition" class="col-md-6 col-form-label text-md-left">{{ __('Do you have any disability or medical condition that host university should be aware of?') }}</label>

                <div class="col-md-6">
                    <input type="radio" name="med_condition" value=1>{{ __('YES') }}
                    <input type="radio" name="med_condition" value=0>{{ __('NO') }}
                    <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('med_condition'))
                              {{       $errors->first('med_condition')}}
                         @endif
                    </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="allergy" class="col-md-6 col-form-label text-md-left">{{ __('Do you have any allergy?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="allergy" value=1>{{ __('YES') }}
                    <input type="radio" name="allergy" value=0>{{ __('NO') }}
                    <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('allergy'))
                              {{       $errors->first('allergy')}}
                         @endif
                    </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="special_diet" class="col-md-6 col-form-label text-md-left">{{ __('Do you have any special dietary requirement(e.g. vegetarian food/halal food only?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="special_diet" value=1>{{ __('YES') }}
                    <input type="radio" name="special_diet" value=0>{{ __('NO') }}
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('special_diet'))
                              {{       $errors->first('special_diet')}}
                         @endif
                         </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="convicted_crime" class="col-md-6 col-form-label text-md-left">{{ __('Have you ever been convicted of a crime offense?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="convicted_crime" value=1>{{ __('YES') }}
                    <input type="radio" name="convicted_crime" value=0>{{ __('NO') }}
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('convicted_crime'))
                              {{       $errors->first('convicted_crime')}}
                         @endif
                         </span>
                </div>
           </div>
           <div class="form-group row px-2">
                <label for="test_type" class="col-md-6 col-form-label text-md-left">{{ __('Do you foresee any other difficulty that may affect the completion of your study?') }}</label>
                <div class="col-md-6">
                    <input type="radio" name="future_diffs" value=1>{{ __('YES') }}
                    <input type="radio" name="future_diffs" value=0>{{ __('NO') }}
                         <span class="col-md-9" style="color:red; font-weight:bold">
                         @if($errors->has('future_diffs'))
                              {{       $errors->first('future_diffs')}}
                         @endif
                         </span>
                </div>
           </div>
           <div class="form-group row px-2">
               <label for="reasons" class="col-md-6 col-form-label text-md-left">{{ __('Reason') }}</label>

               <div class="col-md-6">
               <textarea class="col-md-9 form-control @error('reasons') is-invalid @enderror" rows="16" name="reasons">
               </textarea>
               <span class="col-md-9" style="color:red; font-weight:bold">
                     @if($errors->has('reasons'))
                     {{       $errors->first('reasons')}}
                     @endif
               </span>
               </div>
           </div>
           <div class="form-group row">
                <span class="col-md-9" style="color:black">
                        Note: You no need to fill reason if you answer no for all special conditions
                </span>
           </div>
         </form>
           <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempemergency' type="button px-2" class="btn btn-primary previous">&laquo; Previous</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempdeclaration' type="button px-2" class="btn btn-primary next">Next &raquo;</button>
		           </div>
	            </div>
           </div>
        </div>
    </div>
</div>
@endsection

           <div class="form-group row">
            	<div class="col-md-4 offset-md-4">
		           <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempdestination' type="button px-2" class="btn btn-primary previous">&laquo; Previous</button>
		           </div>
                   <div class="btn-group px-2" role="group" aria-label="Basic example">
		             <button onclick=location.href='/tempcondition' type="button px-2" class="btn btn-primary next">Next &raquo;</button>
		           </div>
	            </div>
           </div>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
       <h3 class="font-weight-bold">Applicant's Declaration</h3>
       <form method="post" action="/formcompleted" id="form6" enctype="multipart/form-data" onsubmit="return checkForm(this);">

        @csrf
        <a style="font-size:20px">
         I certify that the statements made by me on Study Abroad Registration Application Form are true, complete, and correct to the best of my knowledge.<br>
         I fully understand if I am to join the program, agree to:<br>
         1. Follow the course of study and abide the rules of institutions in which I undertake to study;<br>
         2. Act in such a manner that will not bring disrepute to myself, Binus University, home university, or my country of citizenship during my study abroad program;<br>
         3. Abide the rules and regulations governing my visas;<br>
         4. Release information contained in this application form to relevant authorities;<br>
         5. Disburse any additional personal expenses not included in the cost of study abroad program that might occur during my study abroad program;<br>
         6. That Binus University is not responsible for any aspects of my action during the period of programs;<br>
         7. Be placed in anywhere whose quota is still available if submit this application form over the given deadline;<br>
         I am also aware of any medical condition (disability, illness, or pregnancy) which might want to completing my study program within the time allowed for the program;<br></a>
         <input type="checkbox" name="checkbox" value="check" id="agree" /> I agree to the Applicant Declaration<br>
         <button type="submit" class="btn btn-primary" name="submit">Submit</button>
       </form>
        
      </div>
    </div>
</div>