<?php
require_once 'auth.php';
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");

$pk = 'attendanceid';
$table = 'attendance';
$edit = null;
$message = "";

// DELETE
if (isset($_POST['delete'])) {
    $id = (int)$_POST['attendanceid'];
    $delete = mysqli_prepare($conn, "DELETE FROM `attendance` WHERE `attendanceid` = ?");
    mysqli_stmt_bind_param($delete, "i", $id);
    if (mysqli_stmt_execute($delete)) { $message = "Record deleted successfully."; }
    else { $message = "Delete failed: " . mysqli_error($conn); }
}

// INSERT
if (isset($_POST['save'])) {
    $studentid = trim($_POST['studentid'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $attendancestatus = trim($_POST['attendancestatus'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO `attendance` (`studentid`, `date`, `attendancestatus`) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $studentid, $date, $attendancestatus);
    if (mysqli_stmt_execute($stmt)) { $message = "Record inserted successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// UPDATE
if (isset($_POST['update'])) {
    $studentid = trim($_POST['studentid'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $attendancestatus = trim($_POST['attendancestatus'] ?? '');
    $id = (int)($_POST["attendanceid"] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE `attendance` SET `studentid` = ?, `date` = ?, `attendancestatus` = ? WHERE `attendanceid` = ?");
    mysqli_stmt_bind_param($stmt, "issi", $studentid, $date, $attendancestatus, $id);
    if (mysqli_stmt_execute($stmt)) { $message = "Record updated successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// Load selected record for UPDATE
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM `attendance` WHERE `attendanceid` = ?");
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
<title>Attendance Information Form</title>
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
<h1><u>Attendance Information Form</u></h1>
<?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
<form method="post" action="attendance.php">
<?php if ($edit) { ?><input type="hidden" name="attendanceid" value="<?php echo (int)$edit["attendanceid"]; ?>"><?php } ?>
<label>Student ID</label>
<input type="number" name="studentid" value="<?php echo htmlspecialchars($edit["studentid"] ?? ""); ?>" required><br><br>
<label>Date</label>
<input type="date" name="date" value="<?php echo htmlspecialchars($edit["date"] ?? ""); ?>" required><br><br>
<label>Attendance status</label>
<input type="text" name="attendancestatus" value="<?php echo htmlspecialchars($edit["attendancestatus"] ?? ""); ?>" required><br><br>
<?php if ($edit) { ?>
<button type="submit" name="update">Update</button>
<a href="attendance.php">Cancel</a>
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
<th>attendanceid</th>
<th>Student ID</th>
<th>Date</th>
<th>Attendance status</th>
<th>Actions</th>
</tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM `attendance` ORDER BY `attendanceid` DESC");
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo (int)$row["attendanceid"]; ?></td>
<td><?php echo htmlspecialchars((string)$row["studentid"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["date"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["attendancestatus"]); ?></td>
<td>
<a href="attendance.php?edit=<?php echo (int)$row["attendanceid"]; ?>"><button>Edit</button></a>
<form method="post" action="attendance.php" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
<input type="hidden" name="attendanceid" value="<?php echo (int)$row["attendanceid"]; ?>">
<button type="submit" name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>