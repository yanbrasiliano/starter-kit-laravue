@component('mail::message')
<h1 style="color:#EC7000; font-size:22px; font-weight:bold; margin-bottom:16px;">
    Hello {{ $name }}!
</h1>

<p style="font-size:16px; margin-bottom:20px;">
    A password change request has been submitted through the Starterkit Laravue system.
</p>

<p style="text-align:center; margin: 32px 0;">
    <a href="{{ $link }}" style="
            background-color:#E65100;
            color:#ffffff;
            padding:12px 20px;
            text-decoration:none;
            border-radius:8px;
            font-size:15px;
            display:inline-block;
        ">
        Reset my password
    </a>
</p>

<p style="color:#555; font-size:14px; margin-top:20px;">
    If you did not request this email, simply ignore it.
</p>

<p style="color:#555; font-size:14px;">
    Your password will only be changed after accessing the link above.
</p>

<p style="margin-top:24px; font-size:14px; color:#333;">
    Sincerely,<br>
    Starterkit Laravue Team
</p>
@endcomponent
