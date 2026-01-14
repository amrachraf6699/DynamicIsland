<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رد على رسالتك</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8fafc; padding:20px">

    <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:12px;padding:20px">
        <h2 style="color:#1e293b;margin-bottom:10px">
            مرحبًا {{ $contact->name }}
        </h2>

        <p style="color:#475569;font-size:14px">
            شكرًا لتواصلك معنا بخصوص:
            <strong>{{ $contact->subject }}</strong>
        </p>

        <hr style="margin:16px 0">

        <h4 style="margin-bottom:8px;color:#0f172a">الرد:</h4>

        <div style="background:#f1f5f9;border-radius:10px;padding:15px;font-size:14px;color:#0f172a">
            {!! $replyMessage !!}
        </div>

        <p style="margin-top:20px;font-size:13px;color:#64748b">
            مع خالص التحية،<br>
            {{ $brand['name'] ?? config('app.name') }}
        </p>
    </div>

</body>
</html>
