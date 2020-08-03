@extends('student_side.csa_template.csa-template7')

@section('entity')
    Applicant's Declaration &mdash; CSA Application Form Page 6
@endsection

@section('form-action')
{{route('student.csa-form.csa-page7')}}
@endsection

@section('form-inputs')
    <div>
        <div class="font-weight-bold">
            I certify that the statements made by me on Compulsory Study Abroad Registration Application form are 
            true, complete, and correct to the best of my knowledge.
        </div>
        <div class="mt-3">
            <div class="font-weight-bold">
                I fully understand if I am to join the program, agree to:
            </div>
            <div>
                <ul class="list-group">
                    <li class="list-group-item">1. Follow the course of study and abide the rules of institutions in which I undertake to study;</li>
                    <li class="list-group-item">2. Act in such a manner that will not bring disrepute to myself, Binus University, home university, or my country of citizenship during my study abroad program;</li>
                    <li class="list-group-item">3. Abide the rules and regulations governing my visas;</li>
                    <li class="list-group-item">4. Release information contained in this application form to relevant authorities;</li>
                    <li class="list-group-item">5. Disburse any additional personal expenses not included in the cost of study abroad program that might occur during my study abroad program;</li>
                    <li class="list-group-item">6. That Binus University is not responsible for any aspects of my action during the period of programs;</li>
                    <li class="list-group-item">7. Be placed in anywhere whose quota is still available if submit this application form over the given deadline;</li>
                  </ul>
            </div>
            <div class="font-weight-bold mt-3 mb-2">
                I am also aware of any medical condition (disability, illness, or pregnancy) which hinder the completion of my study program within the time allowed for the program;
            </div>
        </div>
    </div>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="agree" name="agree">
        <label class="custom-control-label" for="agree">I agree to the Applicant's Declaration</label>
        @error('agree')
            <div class="alert text-danger p-0 font-weight-bold">^^^^ {{ $message }}</span>
        @enderror
    </div>
    <hr>
@endsection

@section('return-route')
{{route('student.csa-form.csa-page5')}}
@endsection

@section('confirm-value')
SUBMIT FORM
@endsection
