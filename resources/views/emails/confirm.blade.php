<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Confirmation</title>
</head>
<body>
    <h1>Thanks for signing up {{ $fullname }} dear!</h1>
    
    <p>
        We just need you to <a href='{{ route('auth.confirm.email',[$token]) }}'>confirm your email address</a>!
    </p>
</body>
</html>