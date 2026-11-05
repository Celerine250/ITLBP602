<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="top-nav"><a href="view.php">View Records</a>
<a href="students.php">Students</a><a href="class.php">Classes</a>
<a href="subject.php">Subjects</a><a href="logout.php">Logout</a></nav>
   
    <center>
        <fieldset>
            <h1><u><i><u>create new user form</u></i></u></h1>
        <form action="" method="post">
            <label for="">username</label>
            <input type="text"name="username" required><br><br>
             <label for="">password</label>
            <input type="password"name="password" required><br><br>
             <label for="">role</label>
            <input type="text"name="role"required><br><br>
            <input type="submit" value="send"name="save">
       </fieldset>
     </form>
       <?php
    if (isset($_POST['save'])) {
        $a=$_POST['username'];
        $b=$_POST['password'];
        $c=$_POST['role'];
        $conn=mysqli_connect("localhost","root","","lol_sms");
        $kwinjir=mysqli_query($conn,"insert into users values ('','$a','$b','$c')");
        if ($kwinjir) {
            header ('Location: view.php');
        }
        else{
            echo "no";
        }
    }
    ?>
    </center>
</body>
</html>