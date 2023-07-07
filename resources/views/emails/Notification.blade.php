<!DOCTYPE html>
<html>
<head>
    <title>Doctor.Booking</title>
</head>
<body>
<h1>{{$mailData['title'] }}</h1>
<p>{{ $mailData['body'] }}</p>
<a href="{{url($mailData['url'])}}">Click tại đây.</a>
<p>Vui lòng xem chi tiết tại website.</p>
<p>Cảm ơn!</p>
</body>
</html>
