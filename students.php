<?php
require_once 'auth.php';
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");

$pk = 'studentid';
$table = 'students';
$edit = null;
$message = "";

// DELETE
if (isset($_POST['delete'])) {
    $id = (int)$_POST['studentid'];
    $delete = mysqli_prepare($conn, "DELETE FROM `students` WHERE `studentid` = ?");
    mysqli_stmt_bind_param($delete, "i", $id);
    if (mysqli_stmt_execute($delete)) { $message = "Record deleted successfully."; }
    else { $message = "Delete failed: " . mysqli_error($conn); }
}

// INSERT
if (isset($_POST['save'])) {
    $admissionnumber = trim($_POST['admissionnumber'] ?? '');
    $names = trim($_POST['names'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $dateofbirth = trim($_POST['dateofbirth'] ?? '');
    $classid = trim($_POST['classid'] ?? '');
    $phonenumber = trim($_POST['phonenumber'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO `students` (`admissionnumber`, `names`, `gender`, `dateofbirth`, `classid`, `phonenumber`, `address`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssiss", $admissionnumber, $names, $gender, $dateofbirth, $classid, $phonenumber, $address);
    if (mysqli_stmt_execute($stmt)) { $message = "Record inserted successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// UPDATE
if (isset($_POST['update'])) {
    $admissionnumber = trim($_POST['admissionnumber'] ?? '');
    $names = trim($_POST['names'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $dateofbirth = trim($_POST['dateofbirth'] ?? '');
    $classid = trim($_POST['classid'] ?? '');
    $phonenumber = trim($_POST['phonenumber'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $id = (int)($_POST["studentid"] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE `students` SET `admissionnumber` = ?, `names` = ?, `gender` = ?, `dateofbirth` = ?, `classid` = ?, `phonenumber` = ?, `address` = ? WHERE `studentid` = ?");
    mysqli_stmt_bind_param($stmt, "ssssissi", $admissionnumber, $names, $gender, $dateofbirth, $classid, $phonenumber, $address, $id);
    if (mysqli_stmt_execute($stmt)) { $message = "Record updated successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// Load selected record for UPDATE
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM `students` WHERE `studentid` = ?");
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
<title>Student Form Information</title>
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
<h1><u>Student Form Information</u></h1>
<?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
<form method="post" action="students.php">
<?php if ($edit) { ?><input type="hidden" name="studentid" value="<?php echo (int)$edit["studentid"]; ?>"><?php } ?>
<label>Admission number</label>
<input type="text" name="admissionnumber" value="<?php echo htmlspecialchars($edit["admissionnumber"] ?? ""); ?>" required><br><br>
<label>Names</label>
<input type="text" name="names" value="<?php echo htmlspecialchars($edit["names"] ?? ""); ?>" required><br><br>
<label>Gender</label>
<select name="gender" required>
<option value="female" <?php if (($edit["gender"] ?? "") == "female") echo "selected"; ?>>Female</option>
<option value="male" <?php if (($edit["gender"] ?? "") == "male") echo "selected"; ?>>Male</option>
</select><br><br>
<label>Date of birth</label>
<input type="date" name="dateofbirth" value="<?php echo htmlspecialchars($edit["dateofbirth"] ?? ""); ?>" required><br><br>
<label>Class ID</label>
<input type="number" name="classid" value="<?php echo htmlspecialchars($edit["classid"] ?? ""); ?>" required><br><br>
<label>Phone number</label>
<input type="text" name="phonenumber" value="<?php echo htmlspecialchars($edit["phonenumber"] ?? ""); ?>" required><br><br>
<label>Address</label>
<input type="text" name="address" value="<?php echo htmlspecialchars($edit["address"] ?? ""); ?>" required><br><br>
<?php if ($edit) { ?>
<button type="submit" name="update">Update</button>
<a href="students.php">Cancel</a>
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
<th>studentid</th>
<th>Admission number</th>
<th>Names</th>
<th>Gender</th>
<th>Date of birth</th>
<th>Class ID</th>
<th>Phone number</th>
<th>Address</th>
<th>Actions</th>
</tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM `students` ORDER BY `studentid` DESC");
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo (int)$row["studentid"]; ?></td>
<td><?php echo htmlspecialchars((string)$row["admissionnumber"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["names"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["gender"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["dateofbirth"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["classid"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["phonenumber"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["address"]); ?></td>
<td>
<a href="students.php?edit=<?php echo (int)$row["studentid"]; ?>"> <button>Edit</button></a>
<form method="post" action="students.php" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
<input type="hidden" name="studentid" value="<?php echo (int)$row["studentid"]; ?>">
<button type="submit" name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>