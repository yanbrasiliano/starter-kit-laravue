<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deletion Notification</title>
    <style>
        .text-primary {
            color: #007bff;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 1rem;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>

<body>
    <h1 class="text-primary">Account Deletion Notification - SP 1.0 System</h1>

    <p>Dear {{ $user }},</p>

    <p>We hope this message finds you well. We are writing to inform you that, after careful consideration, your account
        in the SP 1.0 system has been deleted.</p>

    <p>This decision was made based on the following reason: {{ $reason }}</p>

    <p>We are available to clarify any questions you may have.<br> We appreciate the time you spent using the SP 1.0
        system and hope you had a positive experience with us.</p>

    <p>
        This is an automated email, please do not reply. If you have any questions or need assistance, please contact
        the system administration.
    </p>

    <div class="card-footer text-muted">
        <p>Best regards,</p>
        <p>The SP 1.0 Team</p>
    </div>
</body>

</html>
