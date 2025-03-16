<!DOCTYPE html>
<html>
<head>
    <title>Comment Added</title>
</head>
<body>
    <p>Hello {{ $comment->task->author->name }}</p>
    <p>A new comment has been added to your task: <strong>{{ $comment->task->title }}</strong></p>
    <p>Comment: {{ $comment->comment }}</p>
</body>
</html>
