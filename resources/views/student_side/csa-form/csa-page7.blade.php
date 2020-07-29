@extends('student_side.csa_template.csa-template4')

@section('entity')
    Applicant's Declaration
@endsection

@section('form-action')
{{route('student.csa-form.csa-page7')}}
@endsection


@section('form-inputs')
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
         <input type="checkbox" name="checkbox" value="1" id="agree" onclick="terms_changed(this)"> I agree to the Applicant Declaration<br>

         <div class="form-group row">
            <div class="col-md-4 offset-md-4">
                <a class="btn btn-secondary" href={{route('student.csa-form.csa-page6')}} role="button">Prev</a>
                <button type="submit" class="btn btn-primary" id="submit_button" href="{{route('student.csa-form.after-page7')}}" disabled>Submit</button>
            </div>
        </div>
@endsection

@push('scripts')
<script>
    function terms_changed(termsCheckBox){
    if(termsCheckBox.checked){
        document.getElementById("submit_button").disabled = false;
    } else{
        document.getElementById("submit_button").disabled = true;
    }
}
</script>
@endpush

