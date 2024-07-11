<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $message = "Login successful!";
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="dynamic-style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <select id="languageSelect">
            <option value="" disabled selected>Select Language</option>
            <option value="en">English</option>
            <option value="hi">Hindi</option>
            <option value="kn">Kannada</option>
            <option value="te">Telugu</option>
        </select>
        <form method="POST" action="login.php">
            <label id="usernameLabel">Username:</label>
            <input type="text" name="username" required><br>
            <label id="passwordLabel">Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        <button class="nav-button" onclick="window.location.href='register.php'">New user? Sign up</button>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
    <script>
        const translations = {
            en: {
                username: 'Username:',
                password: 'Password:'
            },
            hi: {
                username: 'उपयोगकर्ता नाम:',
                password: 'पासवर्ड:'
            },
            kn: {
                username: 'ಬಳಕೆದಾರ ಹೆಸರು:',
                password: 'ಪಾಸ್ವರ್ಡ್:'
            },
            te: {
                username: 'వాడుకరి పేరు:',
                password: 'పాస్వర్డ్:'
            }
        };

        document.getElementById('languageSelect').addEventListener('change', function() {
            const language = this.value;
            document.getElementById('usernameLabel').textContent = translations[language].username;
            document.getElementById('passwordLabel').textContent = translations[language].password;
        });
    </script>
</body>
</html>
