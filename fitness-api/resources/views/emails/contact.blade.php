<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/email_styles.css') }}">
</head>
<body>
    <div class="container">
        <h1>Contact from {{ $contactData['name'] }}</h1>
        <p><strong>Phone Number:</strong> {{ $contactData['phone'] }}</p>
        <div class="message">
            <p><strong>Message:</strong></p>
            <p>{{ $contactData['message'] }}</p>
        </div>
    </div>
</body>
</html>
