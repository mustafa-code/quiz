<!DOCTYPE html>
<html>
<head>
    <title>Quiz Reminder</title>
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
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Quiz Reminder: Your Quiz is Starting Soon!</h2>
        <p>Hello there!</p>
        <p>This is a reminder that the quiz you've subscribed to is about to begin. Don't miss the chance to test your knowledge and compete with others!</p>
        
        <h3>Quiz Details:</h3>
        <p><strong>Quiz Name:</strong> {{ $quiz->title }}</p>
        <p><strong>Start Time:</strong> {{ $startTime }}</p>

        <p>To access the quiz, click on the link below:</p>
        <a href="{{ $quizLink }}" class="button">Join the Quiz</a>

        <p>Good luck, and we hope you enjoy the quiz!</p>

        <p>Best regards,<br>{{ $tenantName }}</p>
    </div>
</body>
</html>
