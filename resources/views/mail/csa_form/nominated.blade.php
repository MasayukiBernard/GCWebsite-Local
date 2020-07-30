@component('mail::message')
# Hello there {{$user_name}},

We are happy to inform you that you have been nominated to the partner university stated below:<br>

@component('mail::panel')
<b>{{$partner_name}} - {{$partner_location}}</b><br>
<b>{{$academic_year->starting_year}} / {{$academic_year->ending_year}} - {{$academic_year->odd_semester ? "Odd Semester" : "Even Semester"}}</b><br>
@endcomponent

Please be prepared to manage application processes required by the partner university!

@component('mail::button', ['url' => config('app.url')])
View CSA Application Status
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
