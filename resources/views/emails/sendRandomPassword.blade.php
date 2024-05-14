@component('mail::message')
    <h1 class="text-primary">Registration in the SP 1.0 System</h1>
    <p>Dear {{ $user->name }}, your registration has been completed in the SP 1.0 system.</p>
    <p>Here are the details for your first access:</p>
    <ul>
        <li>Your login: {{ $user->email }}</li>
        <li>Your password: {{ $password }} </li>
    </ul>
    <p class="alert" style="background-color: #ffcccb; padding: 10px; border-radius: 5px;">
        <strong>Attention:</strong> This is a system-generated password. Please change it as soon as possible.
    </p>

    <div class="card-footer text-muted">
        <p>If you did not request this registration, please ignore this email.</p>
        <p>Best regards, The SP 1.0 Team</p>
    </div>
@endcomponent
