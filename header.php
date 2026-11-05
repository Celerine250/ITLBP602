<?php
$pageTitle=$pageTitle ?? 'School Management System';
$current=basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($pageTitle) ?> | School Management</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
  <a class="brand" href="view.php"><span class="brand-mark">S</span><span>School<span class="brand-light">Manager</span></span></a>
  <nav class="top-nav">
    <a href="view.php" class="<?= $current==='view.php'?'active':'' ?>">Dashboard</a>
    <a href="students.php">Students</a>
    <a href="class.php">Classes</a>
    <a href="subject.php">Subjects</a>
    <a href="grade.php">Grades</a>
    <a href="attendance.php">Attendance</a>
    <a href="annoncement.php">Announcements</a>
    <a href="users.php">Users</a>
    <a class="logout-link" href="logout.php">Logout</a>
  </nav>
</header>
<main class="container">
