<!DOCTYPE html>
<html>
<head>
    <title>Check out this post</title>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->description }}</p>
    <a href="{{ url('/posts', $post->id) }}">View Post</a>
</body>
</html>
