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

<form method="POST" action="{{ route('page-a.play', $link->token) }}">
    @csrf
    <button type="submit">Imfeelinglucky</button>
</form>

<p><a href="{{ route('page-a.history', $link->token) }}">History</a></p>

@if (session('result'))
    <h2>Result</h2>
    <p>
        Number: {{ session('result')['number'] }}.
        {{ session('result')['is_win'] ? 'Win' : 'Lose' }}.
        Amount: {{ session('result')['win_amount'] }}
    </p>
@endif

@isset($history)
    <h2>History (last 3)</h2>
    @forelse ($history as $result)
        <p>Number: {{ $result->number }} — {{ $result->is_win ? 'Win' : 'Lose' }} — {{ $result->win_amount }}</p>
    @empty
        <p>No games yet.</p>
    @endforelse
@endisset
</body>
</html>
