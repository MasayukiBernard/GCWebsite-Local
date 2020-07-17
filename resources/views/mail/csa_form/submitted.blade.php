@component('mail::message')
# Hello there {{$user_name}},

You have submitted your CSA Application Form in the academic year stated below:<br>

@component('mail::panel')
<b>{{$academic_year->starting_year}} / {{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd Semester" : "Even Semester"}}</b><br>
@endcomponent

Please regularly check your email up for reply from us about your nomination status to partner university!

@component('mail::button', ['url' => config('app.url')])
View CSA Application Status
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
