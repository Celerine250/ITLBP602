
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "lol_sms");

if (!$conn) {
    die("Database connection failed");
}

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if  ($user && $user['password'] === $password)  {
        session_regenerate_id(true);
        $_SESSION['username'] = $user['username'];

        header("Location: view.php");
        exit;
    } else {
        $error = "Wrong username or password. Please try again or create an account.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .signup-link {
            margin-top: 20px;
            text-align: center;
        }

        .signup-link a {
            color: blue;
            font-weight: bold;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin: 10px;
        }
    </style>
</head>

<body>
<center>
<fieldset>

    <h1>School Management Login</h1>

    <?php if ($error != ""): ?>
        <p class="error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="post">

        <label>Username</label>
        <input type="text" name="username" required>
        <br><br>

        <label>Password</label>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit" name="login">Login</button>

    </form>
<div class="signup-link">
    <p>Don't have an account?</p>
    <a href="user.php">Sign Up Here</a>
</div>

</fieldset>
</center>
</body>
</html>
