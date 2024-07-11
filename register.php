<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="dynamic-style.css">
    <style>
        /* Additional style for spoken labels */
        .spoken-label {
            position: absolute;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .form-field:hover .spoken-label {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <div class="language-dropdown">
            <label for="languageSelect">Select Language:</label>
            <select id="languageSelect">
                <option value="en">English</option>
                <option value="hi">Hindi</option>
                <option value="kn">Kannada</option>
                <option value="te">Telugu</option>
            </select>
        </div>
        <form method="POST" action="register.php">
            <div class="form-field" data-spoken-label-en="Username:" data-spoken-label-hi="उपयोगकर्ता नाम:" data-spoken-label-kn="ಬಳಕೆದಾರ ಹೆಸರು:" data-spoken-label-te="వాడుకరి పేరు:">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <span class="spoken-label">Username</span>
            </div>
            <div class="form-field" data-spoken-label-en="Email:" data-spoken-label-hi="ईमेल:" data-spoken-label-kn="ಇಮೇಲ್:" data-spoken-label-te="ఇమెయిల్:">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <span class="spoken-label">Email</span>
            </div>
            <div class="form-field" data-spoken-label-en="Password:" data-spoken-label-hi="पासवर्ड:" data-spoken-label-kn="ಪಾಸ್ವರ್ಡ್:" data-spoken-label-te="పాస్వర్డ్:">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span class="spoken-label">Password</span>
            </div>
            <button type="submit">Register</button>
        </form>
        <br>
        <button class="nav-button" onclick="window.location.href='login.php'">Already a user? Sign in</button>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
    <script>
        const translations = {
            en: 'data-spoken-label-en',
            hi: 'data-spoken-label-hi',
            kn: 'data-spoken-label-kn',
            te: 'data-spoken-label-te'
        };

        const formFields = document.querySelectorAll('.form-field');

        formFields.forEach(field => {
            field.addEventListener('mouseover', function() {
                const language = document.getElementById('languageSelect').value;
                const spokenLabel = this.getAttribute(translations[language]);
                const spokenLabelElem = this.querySelector('.spoken-label');
                if (spokenLabelElem) {
                    spokenLabelElem.textContent = spokenLabel;
                }
            });
        });

        document.getElementById('languageSelect').addEventListener('change', function() {
            const language = this.value;
            formFields.forEach(field => {
                const spokenLabel = field.getAttribute(translations[language]);
                const spokenLabelElem = field.querySelector('.spoken-label');
                if (spokenLabelElem) {
                    spokenLabelElem.textContent = spokenLabel;
                }
            });
        });
    </script>
</body>
</html>
