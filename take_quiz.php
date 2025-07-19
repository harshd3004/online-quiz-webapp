<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <style>
        .question-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 0px 50px 20px 50px;
        }

        .question-input {
            width: calc(100% - 22px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .option-input {
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 20px;
        }

        .submit-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message-box {
            background-color: red;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 400px;
        }
    </style>
</head>
<body>

<?php

// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "quizdb";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if quiz_id is provided
if(isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];

    // Fetch questions for the quiz from the questions table
    $sql_questions = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
    $result_questions = $conn->query($sql_questions);

    if($result_questions->num_rows > 0) {
        ?>
        <h2>Quiz Questions</h2>
        <form action="result.php" method="POST">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <?php
            // Display each question
            $question_counter = 1;
            while($question_row = $result_questions->fetch_assoc()) {
                ?>
                <div class="question-container">
                    <label for="question_<?php echo $question_row['question_id']; ?>"><b>Question <?php echo $question_counter; ?>:</b></label>
                    <p><?php echo $question_row['question_text']; ?></p>
                    <?php
                        // Fetch options for the question
                        $question_id = $question_row['question_id'];
                        $sql_options = "SELECT * FROM options WHERE question_id = $question_id";
                        $result_options = $conn->query($sql_options);

                        if($result_options->num_rows > 0) {
                            // Display each option as radio buttons
                            while($option_row = $result_options->fetch_assoc()) {
                                ?>
                                <input type="radio" name="answer_<?php echo $question_row['question_id']; ?>" value="<?php echo $option_row['option_1']; ?>"> <?php echo $option_row['option_1']; ?><br>
                                <input type="radio" name="answer_<?php echo $question_row['question_id']; ?>" value="<?php echo $option_row['option_2']; ?>"> <?php echo $option_row['option_2']; ?><br>
                                <input type="radio" name="answer_<?php echo $question_row['question_id']; ?>" value="<?php echo $option_row['option_3']; ?>"> <?php echo $option_row['option_3']; ?><br>
                                <input type="radio" name="answer_<?php echo $question_row['question_id']; ?>" value="<?php echo $option_row['option_4']; ?>"> <?php echo $option_row['option_4']; ?><br>
                                <input type="hidden" name="correct_answer_<?php echo $option_row['question_id']; ?>" value="<?php echo $option_row['correct_option']; ?>">
                                <?php
                            }
                        } else {
                            echo "<center><div class='message-box'> No options found for this question.</div></center>";
                        }
                    ?>
                </div>
                <?php
                $question_counter++;
            }
            ?>
            <input type="submit" class="submit-button" value="Submit">
        </form>
        <?php
    } else {
        echo "<center><div class='message-box'> No questions found for this quiz.</div></center>";
    }
} else {
    echo "<center><div class='message-box'> Quiz ID not provided.</div></center>";
}

// Close database connection
$conn->close();
?>

    
</body>
</html>
