@extends('student_side.csa_template.csa-template3')

@section('entity')
    Your Achievement
@endsection

@section('form-action')
{{route('student.csa_form.csa-page4', ['csa_id' => 1])}}
@endsection

@section('return-route')
    {{route('student.csa_form.csa-page2', ['csa_id' => 1])}}
@endsection

@section('form-inputs')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12 w-auto">
         <div class="row pt-4">
          <div class="col-md-1">
          <a class="font-weight-bold">No</a>
          </div>
          <div class="col-md-3">
          <a class="font-weight-bold">Achievement</a>
          </div>
          <div class="col-md-1">
          <a class="font-weight-bold">Year</a>
          </div>
          <div class="col-md-2">
          <a class="font-weight-bold">Institution</a>
          </div>
          <div class="col-md-2">
          <a class="font-weight-bold">Detail</a>
          </div>
          <div class="col-md-3">
          <a class="font-weight-bold">Proof Document</a>
          </div>
         </div>
           @csrf
           @for($i = 0; $i < 5; $i++)
           
            <div class="form-group row">
               <div class="col-md-1">
                <label for="achievement[]">{{ __($i + 1) }}</label>
               </div>
               <div class="col-md-3">
                    <textarea class="col-md-11 form-control @error('achievement[]') is-invalid @enderror" rows="8" name="achievement[]"></textarea>
                    <span class="col-md-1" style="color:red; font-weight:bold">
                        @if($errors->has('achievement[]'))
                           {{       $errors->first('achievement[]')}}
                        @endif
                    </span>
               </div>
               <div class="col-md-1">
                    <input id="year[]" class="col-md-11 form-control @error('year[]') is-invalid @enderror" type="text" name="year[]" autofocus>
                    <span class="col-md-1" style="color:red; font-weight:bold">
                        @if($errors->has('year[]'))
                           {{       $errors->first('year[]')}}
                        @endif
                    </span>
               </div>
               <div class="col-md-2">
                    <input id="institution[]" class="col-md-11 form-control @error('institution[]') is-invalid @enderror" type="text" name="institution[]" autofocus>
                    <span class="col-md-1" style="color:red; font-weight:bold">
                        @if($errors->has('institution[]'))
                           {{       $errors->first('institution[]')}}
                        @endif
                    </span>
               </div>
               <div class="col-md-2">
                    <input id="other_details[]" class="col-md-11 form-control @error('other_details[]') is-invalid @enderror" type="text" name="other_details[]" autofocus>
                    <span class="col-md-1" style="color:red; font-weight:bold">
                        @if($errors->has('other_details[]'))
                           {{       $errors->first('other_details[]')}}
                        @endif
                    </span>
               </div>
               <div class="col-md-3">
                     <input id="proof_path[]" class="col-md-11 form-control @error('proof_path[]') is-invalid @enderror" type="file" name="proof_path[]">
                     <span class="col-md-1" style="color:red; font-weight:bold">
                          @if($errors->has('proof_path[]'))
                             {{       $errors->first('proof_path[]')}}
                          @endif
                     </span>
               </div>
            </div>
           @endfor
           <div class="form-group row">
                <span class="col-md-9" style="color:black">
                        Note: Only if applicable and available during university period. Please attach the copy of proof for the achievement(certificate/etc)
                </span>
           </div>
      </div>
    </div>
</div>
@endsection


