@extends('layouts.app3')

@section('content')


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

@endsection

<!--<form action="#" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have agree to the Applicant Declaration'); return false; }">-->

