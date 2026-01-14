<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject ?? $subjectLine ?? config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color:#f8fafc; color:#0f172a; padding:24px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; margin:0 auto; background-color:#ffffff; border-radius:12px; padding:24px;">
        <tr>
            <td>
                <p style="font-size:16px; margin:0 0 16px;">مرحباً {{ $recipientEmail }},</p>
                <p style="font-size:15px; line-height:1.6; white-space:pre-line;">{{ $body }}</p>
                <p style="font-size:14px; color:#475569; margin-top:32px;">
                    أطيب التحيات،<br>
                    {{ config('app.name') }}
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
