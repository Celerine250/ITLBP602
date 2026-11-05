<?php
require_once 'auth.php';
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");

$pk = 'userid';
$table = 'users';
$edit = null;
$message = "";

// DELETE
if (isset($_POST['delete'])) {
    $id = (int)$_POST['userid'];
    $delete = mysqli_prepare($conn, "DELETE FROM `users` WHERE `userid` = ?");
    mysqli_stmt_bind_param($delete, "i", $id);
    if (mysqli_stmt_execute($delete)) { $message = "Record deleted successfully."; }
    else { $message = "Delete failed: " . mysqli_error($conn); }
}

// INSERT
if (isset($_POST['save'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO `users` (`username`, `password`, `role`) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
    if (mysqli_stmt_execute($stmt)) { $message = "Record inserted successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// UPDATE
if (isset($_POST['update'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $id = (int)($_POST["userid"] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE `users` SET `username` = ?, `password` = ?, `role` = ? WHERE `userid` = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $username, $password, $role, $id);
    if (mysqli_stmt_execute($stmt)) { $message = "Record updated successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// Load selected record for UPDATE
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM `users` WHERE `userid` = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultEdit = mysqli_stmt_get_result($stmt);
    $edit = mysqli_fetch_assoc($resultEdit);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Form</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="top-nav">
<a href="view.php">View Records</a>
<a href="students.php">Students</a><a href="class.php">Classes</a>
<a href="subject.php">Subjects</a><a href="grade.php">Grades</a>
<a href="attendance.php">Attendance</a><a href="annoncement.php">Announcements</a>
<a href="users.php">Users</a><a href="logout.php">Logout</a>
</nav>
<center>
<fieldset>
<h1><u>User Form</u></h1>
<?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
<form method="post" action="users.php">
<?php if ($edit) { ?><input type="hidden" name="userid" value="<?php echo (int)$edit["userid"]; ?>"><?php } ?>
<label>Username</label>
<input type="text" name="username" value="<?php echo htmlspecialchars($edit["username"] ?? ""); ?>" required><br><br>
<label>Password</label>
<input type="password" name="password" value="<?php echo htmlspecialchars($edit["password"] ?? ""); ?>" required><br><br>
<label>Role</label>
<input type="text" name="role" value="<?php echo htmlspecialchars($edit["role"] ?? ""); ?>" required><br><br>
<?php if ($edit) { ?>
<button type="submit" name="update">Update</button>
<a href="users.php">Cancel</a>
<?php } else { ?>
<button type="submit" name="save">Save</button>
<button type="reset">Cancel</button>
<?php } ?>
</form>
</fieldset>
</center>
<h2>Saved Records</h2>
<table border="1" cellpadding="8">
<tr>
<th>userid</th>
<th>Username</th>
<th>Password</th>
<th>Role</th>
<th>Actions</th>
</tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM `users` ORDER BY `userid` DESC");
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo (int)$row["userid"]; ?></td>
<td><?php echo htmlspecialchars((string)$row["username"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["password"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["role"]); ?></td>
<td>
<a href="users.php?edit=<?php echo (int)$row["userid"]; ?>"> <button>Edit</button></a>
<form method="post" action="users.php" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
<input type="hidden" name="userid" value="<?php echo (int)$row["userid"]; ?>">
<button type="submit" name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>