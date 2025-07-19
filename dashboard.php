<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        .options {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .option {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .option:hover {
            background-color: #45a049;
        }
        .quiz-list {
            margin: 20px auto;
            width: 90%;
            border-collapse: collapse;
        }

        .quiz-list th,
        .quiz-list td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .quiz-list th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }

        .quiz-list .quiz-item td {
            font-weight: normal;
        }

        .quiz-list a {
            text-decoration: none;
            color: #007bff;
        }

        .quiz-list a:hover {
            text-decoration: underline;
            color: #0056b3;
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

// Fetch all quizzes from the database
$sql = "SELECT * FROM quizzes";
$result = $conn->query($sql);

// Check if the delete button is clicked
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];
    
    // Delete options associated with the questions of the quiz
    $sql_delete_options = "DELETE FROM options WHERE question_id IN (SELECT question_id FROM questions WHERE quiz_id = $quiz_id)";
    if ($conn->query($sql_delete_options) === TRUE) {
        // Delete questions associated with the quiz
        $sql_delete_questions = "DELETE FROM questions WHERE quiz_id = $quiz_id";
        if ($conn->query($sql_delete_questions) === TRUE) {
            // Delete the quiz itself
            $sql_delete_quiz = "DELETE FROM quizzes WHERE quiz_id = $quiz_id";
            if ($conn->query($sql_delete_quiz) === TRUE) {
                echo "<div class='message-box'>Quiz deleted successfully</div>";
            } else {
                echo "<div class='message-box'>Error deleting quiz: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='message-box'>Error deleting questions: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='message-box'>Error deleting options: " . $conn->error . "</div>";
    }
}


$conn->close();
?>
<body>
    <div class="container">
        <h2>Welcome to Admin Dashboard</h2>
        <div class="options">
            <a href="add_update_quiz.php" class="option">Add Quiz</a>
        </div>
    </div>
    <table class="quiz-list">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Questions</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr class="quiz-item">
                    <td><?php echo $row["title"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["num_questions"]; ?></td>
                    <td><a href="add_update_quiz.php?quiz_id=<?php echo $row["quiz_id"]; ?>">Update</a></td>
                    <td><a href="?action=delete&quiz_id=<?php echo $row["quiz_id"]; ?>">Delete</a></td>
                </tr>
                <?php
            }
        } else {
            echo '<tr><td colspan="5">No quizzes found</td></tr>';
        }
        ?>
    </tbody>
</table>

</body>
</html>
