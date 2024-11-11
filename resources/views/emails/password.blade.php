@component('mail::message')
    <h1 class="text-primary">Hello {{ $name }}!</h1>
    <p>A password change request was sent from the SP 1.0 System.</p>

    <p style="text-align: center;">
        <a href="{{ $link }}" class="btn">Change my password</a>
    </p>

    <div class="card-footer text-muted">
        <p>If you did not request this email, please ignore it.</p>
        <p>Your password will not be changed until you access the link above.</p>
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
