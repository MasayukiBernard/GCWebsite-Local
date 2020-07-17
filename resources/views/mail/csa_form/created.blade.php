@component('mail::message')
# Hello there {{$user_name}},

You have created a new CSA Application Form in the academic year stated below:<br>

@component('mail::panel')
<b>{{$academic_year->starting_year}} / {{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd Semester" : "Even Semester"}}</b><br>
@endcomponent

Please fill in you application as soon as possible to speed up your nomination process to partner university!

@component('mail::button', ['url' => config('app.url')])
View CSA Application Status
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
