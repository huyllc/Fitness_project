<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <h3>Dear {{$enrollment->user->name}}</h3>
    <span>
        We are excited to inform you that your registration for our group fitness class has been successfully processed. Welcome to our vibrant community of health enthusiasts!
        Here are the details of your registration:
    </span>
    <ul>
        <li><b>Course Name:</b> {{$enrollment->course->title}}</li>
        <li><b>Trainer Name:</b> {{$enrollment->course->user->name}}</li>
        <li><b>Registration Date:</b> {{$enrollment->created_at}}</li>
        <li><b>Duration:</b> {{$enrollment->course->duration}} (Months)</li>
    </ul>
    <p>
        Your commitment to prioritizing your health and fitness journey is admirable, and we're thrilled to support you every step of the way.
        Before your first class, here are a few things to keep in mind:
    </p>
    <ul>
        <li><span>Please arrive at least 10 minutes before the start time of your first class to complete any necessary paperwork and familiarize yourself with the studio.</span></li>
        <li><span>Wear comfortable workout attire and bring a water bottle and towel.</span></li>
        <li><span>If you have any existing medical conditions or injuries, please inform your instructor before the class begins.</span></li>
    </ul>
</body>
</html>