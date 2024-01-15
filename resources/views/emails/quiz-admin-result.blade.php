<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Attempt Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
        }
        .header {
            font-size: 20px;
            color: #333;
        }
        .details {
            margin-top: 20px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="header">Quiz Attempt Notification</h1>
        <p>Dear {{ $user->name }},</p>
        <p>This is to inform you that a client has recently completed a quiz on your platform.</p>

        <div class="details">
            <p><strong>Client Name:</strong> {{ $quizAttempt->tenantUser->name }}</p>
            <p><strong>Quiz Title:</strong> {{ $quizAttempt->quiz->title }}</p>
            <p><strong>Date and Time of Attempt:</strong> {{ $quizAttempt->started_at }}</p>
            <p><strong>Client Score:</strong> {{ $quizAttempt->score }}  / {{ $quizAttempt->quiz->questions()->count() }}</p>
        </div>

        <p>To view more details about this attempt, please log in to your dashboard.</p>

        <div class="footer">
            <p>Thank you for using our platform.</p>
            <p>Best regards,<br>{{ $quizAttempt->quiz->tenant->name }}</p>
        </div>
    </div>
</body>
</html>
