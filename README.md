# 🧠 Online Quiz Web Application

This is a PHP-based online quiz system that allows users to take quizzes and view results, while admins can log in, add questions, and manage quizzes.

> ⚠️ Note: This project was built in 2024 using **XAMPP** (Apache + MySQL). It is currently not live and may require a local server to run properly.

---

## 🚀 Features

- Admin login for quiz management
- Add, update, and manage quiz questions
- Take quizzes and get scored instantly
- View quiz results
- Basic session and form handling in PHP

---

## 🛠️ Tech Stack

- **Backend:** PHP
- **Database:** MySQL 

---

## 📊 Database Schema

This project uses a MySQL database with three main tables:

### `quizzes`
| Column        | Type         | Description               |
|---------------|--------------|---------------------------|
| quiz_id       | INT (PK)     | Unique quiz identifier    |
| title         | VARCHAR(255) | Title of the quiz         |
| description   | TEXT         | Description of the quiz   |
| num_questions | INT          | Total number of questions |

### `questions`
| Column        | Type     | Description                |
|---------------|----------|----------------------------|
| question_id   | INT (PK) | Unique question ID         |
| question_text | TEXT     | The question itself        |
| quiz_id       | INT (FK) | Linked quiz ID             |

### `options`
| Column         | Type     | Description                          |
|----------------|----------|--------------------------------------|
| option_id      | INT (PK) | Unique option ID                     |
| question_id    | INT (FK) | Linked question                      |
| option_1–4     | TEXT     | The four choices                     |
| correct_option | ENUM     | Correct option (e.g., `option_2`)    |

---

## 🗂️ File Overview

| File                | Description                            |
|---------------------|----------------------------------------|
| `admin_login.php`   | Admin login interface                  |
| `dashboard.php`     | Admin dashboard                        |
| `add_questions.php` | Add new quiz questions                 |
| `add_update_quiz.php` | Add or update entire quizzes        |
| `main_page.php`     | Main landing page for users            |
| `take_quiz.php`     | Quiz taking page                       |
| `result.php`        | Displays quiz result                   |

---

## 🧪 Setup Instructions

1. Install [XAMPP](https://www.apachefriends.org/)
2. Clone or download this repository into your `htdocs/` folder
3. Use the schema above to recreate the database in phpMyAdmin
4. Start Apache & MySQL from XAMPP Control Panel
5. Open your browser and navigate to:  
   `http://localhost/your-project-folder/`

---

## 📎 Notes

- The `.sql` export of the database is not included — please use the schema provided above
- This was a student project built to learn PHP and MySQL
