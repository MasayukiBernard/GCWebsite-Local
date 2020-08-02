
@extends('student_side.csa_template.csa-template2a')

@section('entity')
     Passport &mdash; CSA Application Form Page 2a
@endsection

@section('form-action')
{{route('student.csa-form.after-page2a')}}
@endsection

@section('return-route')
{{route('student.csa-form.csa-page2')}}
@endsection

@section('form-inputs')
     <hr>
     <div class="form-group row">
          <label for="pass_num" class="col-md-4 col-form-label text-md-left font-weight-bold">Passport Number</label>
          <div class="col-md-8">
               <input id="pass_num" class="col-md-2 form-control @error('pass-num') is-invalid @enderror" type="text" minlength="1" maxlength="9" name="pass-num" onkeypress="changeUpdate();" value="{{old('pass-num', $passport != null ? $passport->pass_num : '')}}" autocomplete="off">
               @error('pass-num')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="pass_expiry" class="col-md-4 col-form-label text-md-left font-weight-bold">Passport Expiration Date</label>
          <div class="col-md-8">
               <input id="pass_expiry" class="col-md-4 form-control @error('pass-expiry') is-invalid @enderror" type="text" minlength="10" maxlength="10" placeholder="Format: YYYY-MM-DD" name="pass-expiry" onkeypress="changeUpdate();" value="{{old('pass-expiry', $passport != null ? $passport->pass_expiry : '')}}" autocomplete="off">
               <small class="form-text text-muted m-0">Minimum 6 months after CSA Completion</small>
               @error('pass-expiry')
                    <div class="alert alert-danger">{{ $message }}</div>
               @enderror
          </div>
     </div>
     <hr>
     <div class="form-group row">
          <label for="pass_num" class="col-md-4 col-form-label text-md-left font-weight-bold">Passport Proof</label>
          <div class="col-md-8">
               @isset($passport)
                    <div>
                         <a target="_blank" href="/student/{{$filemtime}}/{{$ysid}}/image/passport">See Existing Passport Proof</a>
                    </div>
               @endisset
               <div id="pass_proof_file" class="custom-file">
                    <input type="file" name="pass-proof-path" id="pass_proof_path" onchange="changeLabel('pass_proof_path_label', 'pass_proof_path'); changeUpdate();" class="custom-file-input @error('pass-proof-path') is-invalid @enderror" style="cursor: pointer;">
                    <label class="custom-file-label" id="pass_proof_path_label" for="pass_proof_path">
                         @if(isset($passport))
                              Change existing passport proof picture file
                         @else
                              Choose passport proof picture file
                         @endif
                    </label>
                    <small class="file_size_notif" class="form-text text-muted m-0">Maximum uploaded file size is 2 Megabytes.</small>
               </div>
               @error('pass-proof-path')
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

          function changeUpdate(){
               $('#next_btn').addClass('d-none');
               $('#submit_btn').removeClass('d-none');
          }
     </script>
@endpush