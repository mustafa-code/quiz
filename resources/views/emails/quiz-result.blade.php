<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
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
            text-align: center;
        }
        .result-header {
            font-size: 24px;
            color: #4CAF50;
        }
        .result-details {
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="result-header">Quiz Results</h1>
        <p>Hello {{ $quizAttempt->tenantUser->name }},</p>
        <p>Thank you for participating in the quiz. Here are your results:</p>

        <div class="result-details">
            <p><strong>Quiz:</strong> {{ $quizAttempt->quiz->title }}</p>
            <p><strong>Your Score:</strong> {{ $quizAttempt->score }} / {{ $quizAttempt->quiz->questions()->count() }}</p>
            <p><strong>Percentage:</strong> {{ $quizAttempt->percentage }}%</p>
            <p><strong>Date Attempted:</strong> {{ $quizAttempt->completed_at }}</p>
        </div>

        <p>For detailed answers and more information, please visit our website.</p>
        <p>Thank you,</p>
        <p>{{ $quizAttempt->quiz->tenant->name }}</p>
    </div>
</body>
</html>
