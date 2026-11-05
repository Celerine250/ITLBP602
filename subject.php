<?php
require_once 'auth.php';
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");

$pk = 'subjectid';
$table = 'subjects';
$edit = null;
$message = "";

// DELETE
if (isset($_POST['delete'])) {
    $id = (int)$_POST['subjectid'];
    $delete = mysqli_prepare($conn, "DELETE FROM `subjects` WHERE `subjectid` = ?");
    mysqli_stmt_bind_param($delete, "i", $id);
    if (mysqli_stmt_execute($delete)) { $message = "Record deleted successfully."; }
    else { $message = "Delete failed: " . mysqli_error($conn); }
}

// INSERT
if (isset($_POST['save'])) {
    $subjectname = trim($_POST['subjectname'] ?? '');
    $subjectcode = trim($_POST['subjectcode'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO `subjects` (`subjectname`, `subjectcode`) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $subjectname, $subjectcode);
    if (mysqli_stmt_execute($stmt)) { $message = "Record inserted successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// UPDATE
if (isset($_POST['update'])) {
    $subjectname = trim($_POST['subjectname'] ?? '');
    $subjectcode = trim($_POST['subjectcode'] ?? '');
    $id = (int)($_POST["subjectid"] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE `subjects` SET `subjectname` = ?, `subjectcode` = ? WHERE `subjectid` = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $subjectname, $subjectcode, $id);
    if (mysqli_stmt_execute($stmt)) { $message = "Record updated successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// Load selected record for UPDATE
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM `subjects` WHERE `subjectid` = ?");
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
<title>Subject Form Information</title>
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
<h1><u>Subject Form Information</u></h1>
<?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
<form method="post" action="subject.php">
<?php if ($edit) { ?><input type="hidden" name="subjectid" value="<?php echo (int)$edit["subjectid"]; ?>"><?php } ?>
<label>Subject name</label>
<input type="text" name="subjectname" value="<?php echo htmlspecialchars($edit["subjectname"] ?? ""); ?>" required><br><br>
<label>Subject code</label>
<input type="text" name="subjectcode" value="<?php echo htmlspecialchars($edit["subjectcode"] ?? ""); ?>" required><br><br>
<?php if ($edit) { ?>
<button type="submit" name="update">Update</button>
<a href="subject.php">Cancel</a>
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
<th>subjectid</th>
<th>Subject name</th>
<th>Subject code</th>
<th>Actions</th>
</tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM `subjects` ORDER BY `subjectid` DESC");
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo (int)$row["subjectid"]; ?></td>
<td><?php echo htmlspecialchars((string)$row["subjectname"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["subjectcode"]); ?></td>
<td>
<a href="subject.php?edit=<?php echo (int)$row["subjectid"]; ?>"> <button>Edit</button></a>
<form method="post" action="subject.php" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
<input type="hidden" name="subjectid" value="<?php echo (int)$row["subjectid"]; ?>">
<button type="submit" name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>