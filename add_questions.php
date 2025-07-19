<?php

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "quizdb";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$quiz_id = null;
$numQuestions=0;
if(isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];

    // Query to get the number of questions for the specified quiz
    $sql = "SELECT num_questions FROM quizzes WHERE quiz_id = $quiz_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $numQuestions = $row["num_questions"];
    } else {
        // header("Location: dashboard.php");
        echo "Quiz not found";
        exit();
    }
} 
else{
    // header("Location: dashboard.php");
    echo "quiz id not passed";
}


// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = $_POST["quiz_id"];
    $numQuestions = $_POST["num_questions"];
    for($i = 1; $i <= $numQuestions; $i++) {
        // Insert question
        $question_text = $_POST["question_$i"];
        $question_insert_sql = "INSERT INTO questions (question_text, quiz_id) VALUES ('$question_text', $quiz_id)";
        $conn->query($question_insert_sql);
        $question_id = $conn->insert_id; 

        // Insert options
        $option_1 = $_POST["option_{$i}_1"];
        $option_2 = $_POST["option_{$i}_2"];
        $option_3 = $_POST["option_{$i}_3"];
        $option_4 = $_POST["option_{$i}_4"];
        $correct_option_num = $_POST["correct_option_{$i}"];
        $correct_option = $_POST["option_{$i}_{$correct_option_num}"];
        $option_insert_sql = "INSERT INTO options (question_id, option_1, option_2, option_3, option_4, correct_option) VALUES ($question_id, '$option_1', '$option_2', '$option_3', '$option_4', '$correct_option')";

        $conn->query($option_insert_sql);
    }

    header("Location: dashboard.php");
    $conn->close();

    exit();
}


// Function to generate input fields for questions and options
function generateInputFields($numQuestions) {
    $html = '';
    
    // Loop to generate input fields for each question
    for($i = 1; $i <= $numQuestions; $i++) {
        $html .="<div class='question-container'>";
        $html .= "<label for='question_$i'><b>Question $i:</b></label>";
        $html .= "<input type='text' id='question_$i' class='question-input' name='question_$i' placeholder='Enter question $i' required>";
        
        for($j = 1; $j <= 4; $j++) {
            $html .= "<label for='option_{$i}_$j'>Option $j: </label>";
            $html .= "<input type='radio' name='correct_option_$i' value='$j' required>";
            $html .= "<input type='text' id='option_{$i}_$j' class='option-input' name='option_{$i}_$j' placeholder='Enter option $j' required>";
            
        }
        $html .= "</div>";
    }
    
    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions</title>
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
    </style>

</head>
<body>
    <h2>Add Questions to Quiz</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <input type="hidden" name="num_questions" value="<?php echo $numQuestions ?>">
        
        <?php
        echo generateInputFields($numQuestions);
        ?>
        
        <center><input type="submit" value="Submit" class="submit-button"></center>
    </form>
</body>
</html>