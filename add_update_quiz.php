<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add / Update Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .quiz-form {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .quiz-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .quiz-form label {
            display: block;
            margin-bottom: 10px;
        }
        
        .quiz-form input[type="text"],
        .quiz-form textarea,
        .quiz-form input[type="number"],
        .quiz-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "quizdb";

$quiz_id = null;
$quiz_name = "";
$description = "";
$num_questions = 0;

// Check if the quiz_id is passed
if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];
    
    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch quiz details for updating
    $sql = "SELECT * FROM quizzes WHERE quiz_id = $quiz_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quiz_name = $row["title"];
        $description = $row["description"];
        $num_questions = $row["num_questions"];
    }

    // Close connection
    $conn->close();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = $_POST["quiz_id"];
    $quiz_name = $_POST["quiz_name"];
    $description = $_POST["description"];
    $num_questions = $_POST["num_questions"];

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($quiz_id != null) {
        // Update existing quiz
        $sql = "UPDATE quizzes SET title='$quiz_name', description='$description', num_questions='$num_questions' WHERE quiz_id=$quiz_id";
    } else {
        // Add new quiz
        $sql = "INSERT INTO quizzes (title, description, num_questions) VALUES ('$quiz_name', '$description', $num_questions)";
    }

    if ($conn->query($sql) === TRUE) {
        // Redirect to add_questions.php with the quiz ID as a parameter
        
        header("Location: add_questions.php?quiz_id=$quiz_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
<body>
    <div class="quiz-form">
        <h2><?php echo ($quiz_id !== null ? "Update" : "Add"); ?> Quiz</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <label for="quiz_name">Quiz Name:</label>
            <input type="text" id="quiz_name" name="quiz_name" placeholder="Enter quiz name" required value="<?php echo $quiz_name; ?>">
            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter Quiz Description" required><?php echo $description; ?></textarea>
            
            <label for="num_questions">Number of questions:</label>
            <input type="number" id="num_questions" name="num_questions" placeholder="Enter number of questions" required min="1" value="<?php echo $num_questions; ?>">
            <br>

            <input type="submit" value="Add Questions">
        </form>
    </div>
</body>
</html>
