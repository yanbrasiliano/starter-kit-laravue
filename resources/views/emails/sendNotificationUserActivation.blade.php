@component('mail::message')
    <h1>Activation of User in the SP 1.0 System</h1>

    <p>Dear {{ $user->name }}, your registration has been activated in the system.</p>
    You can now access it to register your projects, programs, or extension courses.
    To access, follow the instructions below:<br>
    <br>
    <ul>
        <li>System link: <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></li>
        <li>Your login: {{ $user->email }}</li>
        <li>Use the password you created during registration!</li>
    </ul>
    <br><br>

    <p>Best regards, The SP 1.0 Team</p>
@endcomponent
