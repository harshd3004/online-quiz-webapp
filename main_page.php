<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .quiz-list {
            width: 100%;
            border-collapse: collapse;
        }
        .quiz-list th, .quiz-list td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .quiz-list th {
            background-color: #f2f2f2;
        }
        .quiz-item a {
            color: #007bff;
            text-decoration: none;
        }
        .quiz-item a:hover {
            text-decoration: underline;
        }

        .admin-btn {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }
        .admin-btn a {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "quizdb";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all quizzes from the database
$sql = "SELECT * FROM quizzes";
$result = $conn->query($sql);

$conn->close();
?>
<body>
    <div class="container">
        <h2>Quiz List</h2>
        <table class="quiz-list">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Num ofQuestions</th>
                    <th>Action</th>
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
                            <td><a href="take_quiz.php?quiz_id=<?php echo $row["quiz_id"]; ?>">Take Quiz</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5">No quizzes found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="admin-btn">
        <a href="admin_login.php">Admin</a>
    </div>
</body>
</html>