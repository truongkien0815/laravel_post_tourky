<!DOCTYPE html>
<html>
<head>
    <title>{{ $detail['subject'] }}</title>
</head>

<body>
<h1>{{ $detail['subject'] }}</h1>
<p>{{ $detail['message'] }}</p>
<br>
<hr>
<p>From: {{ $detail['name'] }}</p>
<p>Email: {{ $detail['email'] }}</p>
@if (isset($detail['phone']) && !empty($detail['phone']))
    <p>Phone: {{ $detail['phone'] }}</p>
@endif
</body>
</html>