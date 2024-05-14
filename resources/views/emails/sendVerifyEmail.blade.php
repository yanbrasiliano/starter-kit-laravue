@component('mail::message')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <h1 class="text-primary">System Registration Confirmation</h1>
    <p>Dear {{ $user->name }}, thank you for registering with the SP 1.0 system.</p>
    <p>You need to confirm your email address and wait for an administrator to approve your registration.</p>
    <p>Click the link below to validate your email address:</p>
    <br>

    <p style="text-align: center;">
        <a class="btn" href="{{ $link }}" target="_blank">Confirm Email</a>
    </p>

    <br>
    <p>If you do not complete the email validation, your account will not be activated and you will not be able to access
        the system. This link is valid for 48 hours.</p>

    <div class="card-footer text-muted">
        <p>If you did not request this registration, please ignore this email.</p>
        <p>Best regards,</p>
        <p>The SP 1.0 Team</p>
    </div>

    <style>
        .btn {
            background-color: #EC7000;
            border: none;
            color: #fff;
            padding: 1em 1em;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.5s ease;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
@endcomponent
