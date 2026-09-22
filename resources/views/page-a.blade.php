<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Page A</title>
</head>
<body>
<h1>Hello, {{ $user->username }}!</h1>

<p>
    Your unique link (valid until {{ $link->expires_at->toDayDateTimeString() }}):<br>
    <a href="{{ route('page-a.show', $link->token) }}">{{ route('page-a.show', $link->token) }}</a>
</p>

<form method="POST" action="{{ route('page-a.regenerate', $link->token) }}">
    @csrf
    <button type="submit">Regenerate link</button>
</form>

<form method="POST" action="{{ route('page-a.deactivate', $link->token) }}">
    @csrf
    <button type="submit">Deactivate link</button>
</form>
</body>
</html>
