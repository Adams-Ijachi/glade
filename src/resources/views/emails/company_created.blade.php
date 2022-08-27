@component('mail::message')
    # Company Created

    A company has been created. Please find the details below.


    Company: {{ $company->name }}
    Email: {{ $company->user->email }}




    Thanks
    {{ config('app.name') }}
@endcomponent

