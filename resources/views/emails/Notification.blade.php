<!DOCTYPE html>
<html>
<head>
    <title>Doctor.Booking</title>
</head>
<body>
<h1>{{$mailData['title'] }}</h1>
<p>{{ $mailData['body'] }}</p>
<a href="{{url($mailData['url'])}}">Click here</a>
<p>Please view appointment</p>
<p>Thank you</p>
</body>
</html>
