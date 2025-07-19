<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .result-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
        }
        .result {
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h2>Quiz Result</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve selected answers and correct answers from the form submission
            $selected_answers = [];
            $correct_answers = [];
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'answer_') === 0) {
                    $question_id = substr($key, strlen('answer_')); // Extract question ID from input name
                    $selected_answers[$question_id] = $value; 
                } elseif (strpos($key, 'correct_answer_') === 0) {
                    $question_id = substr($key, strlen('correct_answer_')); // Extract question ID from input name
                    $correct_answers[$question_id] = $value; 
                }
            }

            // Compare selected and correct answers to calculate marks
            $marks = 0;
            $total =0;
            foreach ($selected_answers as $question_id => $selected_option) {
                if (isset($correct_answers[$question_id]) && $correct_answers[$question_id] == $selected_option) {
                    $marks++;
                }
                $total++;
            }
            $percent = ($marks / $total) * 100;

            // Display result
            echo "<div class='result'>";
            echo "<p>Marks Obtained : $marks</p>";
            echo "<p>Total Marks : $total</p>";
            echo "<p>Percentage : $percent %</p>";
            echo "</div>";
        } else {
            echo "<p>No data submitted.</p>";
        }
        ?>
    </div>
</body>
</html>
