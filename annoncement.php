<?php
require_once 'auth.php';
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");

$pk = 'announcementid';
$table = 'announcements';
$edit = null;
$message = "";

// DELETE
if (isset($_POST['delete'])) {
    $id = (int)$_POST['announcementid'];
    $delete = mysqli_prepare($conn, "DELETE FROM `announcements` WHERE `announcementid` = ?");
    mysqli_stmt_bind_param($delete, "i", $id);
    if (mysqli_stmt_execute($delete)) { $message = "Record deleted successfully."; }
    else { $message = "Delete failed: " . mysqli_error($conn); }
}

// INSERT
if (isset($_POST['save'])) {
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $publicationdate = trim($_POST['publicationdate'] ?? '');
    $postedby = trim($_POST['postedby'] ?? '');
    $stmt = mysqli_prepare($conn, "INSERT INTO `announcements` (`title`, `message`, `publicationdate`, `postedby`) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $title, $message, $publicationdate, $postedby);
    if (mysqli_stmt_execute($stmt)) { $message = "Record inserted successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// UPDATE
if (isset($_POST['update'])) {
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $publicationdate = trim($_POST['publicationdate'] ?? '');
    $postedby = trim($_POST['postedby'] ?? '');
    $id = (int)($_POST["announcementid"] ?? 0);
    $stmt = mysqli_prepare($conn, "UPDATE `announcements` SET `title` = ?, `message` = ?, `publicationdate` = ?, `postedby` = ? WHERE `announcementid` = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $message, $publicationdate, $postedby, $id);
    if (mysqli_stmt_execute($stmt)) { $message = "Record updated successfully."; }
    else { $message = "Operation failed: " . mysqli_error($conn); }
}

// Load selected record for UPDATE
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM `announcements` WHERE `announcementid` = ?");
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
<title>Announcement Information Form</title>
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
<h1><u>Announcement Information Form</u></h1>
<?php if ($message != "") echo "<p>" . htmlspecialchars($message) . "</p>"; ?>
<form method="post" action="annoncement.php">
<?php if ($edit) { ?><input type="hidden" name="announcementid" value="<?php echo (int)$edit["announcementid"]; ?>"><?php } ?>
<label>Title</label>
<input type="text" name="title" value="<?php echo htmlspecialchars($edit["title"] ?? ""); ?>" required><br><br>
<label>Message</label>
<input type="text" name="message" value="<?php echo htmlspecialchars($edit["message"] ?? ""); ?>" required><br><br>
<label>Publication date</label>
<input type="date" name="publicationdate" value="<?php echo htmlspecialchars($edit["publicationdate"] ?? ""); ?>" required><br><br>
<label>Posted by</label>
<input type="text" name="postedby" value="<?php echo htmlspecialchars($edit["postedby"] ?? ""); ?>" required><br><br>
<?php if ($edit) { ?>
<button type="submit" name="update">Update</button>
<a href="annoncement.php">Cancel</a>
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
<th>announcementid</th>
<th>Title</th>
<th>Message</th>
<th>Publication date</th>
<th>Posted by</th>
<th>Actions</th>
</tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM `announcements` ORDER BY `announcementid` DESC");
while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo (int)$row["announcementid"]; ?></td>
<td><?php echo htmlspecialchars((string)$row["title"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["message"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["publicationdate"]); ?></td>
<td><?php echo htmlspecialchars((string)$row["postedby"]); ?></td>
<td>
<a href="annoncement.php?edit=<?php echo (int)$row["announcementid"]; ?>"><button>Edit</button></a>
<form method="post" action="annoncement.php" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
<input type="hidden" name="announcementid" value="<?php echo (int)$row["announcementid"]; ?>">
<button type="submit" name="delete">Delete</button>
</form>
</td>
</tr>
<?php } ?>
</table>
</body>
</html>