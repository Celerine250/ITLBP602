<?php
require_once 'auth.php';
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");

$pk = 'gradeid';
$table = 'grades';
$edit = null;
$message = "";

// DELETE
if (isset($_POST['delete'])) {
    $id = (int)$_POST['gradeid'];
    $delete = mysqli_prepare($conn, "DELETE FROM `grades` WHERE `gradeid` = ?");
    mysqli_stmt_bind_param($delete, "i", $id);
    if (mysqli_stmt_execute($delete)) { $message = "Record deleted successfully."; }
    else { $message = "Delete failed: " . mysqli_error($conn); }
}

// INSERT
if (isset($_POST['save'])) {
    $studentid = trim($_POST['studentid'] ?? '');
    $subjectid = trim($_POST['subjectid'] ?? '');
    $assessmenttype = trim($_POST['assessmenttype'] ?? '');
    $marks = trim($_POST['marks'] ?? '');
    $academicyear = trim($_POST['academicyear'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO `grades` (`studentid`, `subjectid`, `assessmenttype`, `marks`, `academicyear`) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisis", $studentid, $subjectid, $assessmenttype, $marks, $academicyear);
    if (mysqli_stmt_execute($stmt)) { $message = "Record inserted successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// UPDATE
if (isset($_POST['update'])) {
    $studentid = trim($_POST['studentid'] ?? '');
    $subjectid = trim($_POST['subjectid'] ?? '');
    $assessmenttype = trim($_POST['assessmenttype'] ?? '');
    $marks = trim($_POST['marks'] ?? '');
    $academicyear = trim($_POST['academicyear'] ?? '');
    $id = (int)($_POST["gradeid"] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE `grades` SET `studentid` = ?, `subjectid` = ?, `assessmenttype` = ?, `marks` = ?, `academicyear` = ? WHERE `gradeid` = ?");
    mysqli_stmt_bind_param($stmt, "iisisi", $studentid, $subjectid, $assessmenttype, $marks, $academicyear, $id);
    if (mysqli_stmt_execute($stmt)) { $message = "Record updated successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// Load selected record for UPDATE
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM `grades` WHERE `gradeid` = ?");
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
<title>Grade Form Information</title>
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
<h1><u>Grade Form Information</u></h1>
<?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
<form method="post" action="grade.php">
<?php if ($edit) { ?><input type="hidden" name="gradeid" value="<?php echo (int)$edit["gradeid"]; ?>"><?php } ?>
<label>Student ID</label>
<input type="number" name="studentid" value="<?php echo htmlspecialchars($edit["studentid"] ?? ""); ?>" required><br><br>
<label>Subject ID</label>
<input type="number" name="subjectid" value="<?php echo htmlspecialchars($edit["subjectid"] ?? ""); ?>" required><br><br>
<label>Assessment type</label>
<input type="text" name="assessmenttype" value="<?php echo htmlspecialchars($edit["assessmenttype"] ?? ""); ?>" required><br><br>
<label>Marks</label>
<input type="number" name="marks" value="<?php echo htmlspecialchars($edit["marks"] ?? ""); ?>" required><br><br>
<label>Academic year</label>
<input type="text" name="academicyear" value="<?php echo htmlspecialchars($edit["academicyear"] ?? ""); ?>" required><br><br>
<?php if ($edit) { ?>
<button type="submit" name="update">Update</button>
<a href="grade.php">Cancel</a>
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
<th>gradeid</th>
<th>Student ID</th>
<th>Subject ID</th>
<th>Assessment type</th>
<th>Marks</th>
<th>Academic year</th>
<th>Actions</th>
</tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM `grades` ORDER BY `gradeid` DESC");
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo (int)$row["gradeid"]; ?></td>
<td><?php echo htmlspecialchars((string)$row["studentid"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["subjectid"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["assessmenttype"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["marks"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["academicyear"]); ?></td>
<td>
<a href="grade.php?edit=<?php echo (int)$row["gradeid"]; ?>"><button>Edit</button></a>
<form method="post" action="grade.php" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
<input type="hidden" name="gradeid" value="<?php echo (int)$row["gradeid"]; ?>">
<button type="submit" name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>