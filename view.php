<?php require_once 'auth.php'; 
$conn = mysqli_connect("localhost", "root", "", "lol_sms");
$counts=[];
//foreach(['students'=>'Students','classes'=>'Classes','subjects'=>'Subjects','grades'=>'Grades','attendance'=>'Attendance','announcements'=>'Announcements','users'=>'Users'] as $table=>$label) {
   // $res=$conn->query("SELECT COUNT(*) AS total FROM `$table`"); $counts[$table]=['label'=>$label,'total'=>(int)$res->fetch_assoc()['total']];
//}

?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>School Management</title>
<link rel="stylesheet" href="style.css"></head><body>
<h1>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
<div class="stats-grid"><?php foreach($counts as $key=>$item): ?><a class="stat-card" href="<?= h($key==='announcements'?'annoncement.php':$key.'.php') ?>"><span class="stat-label"><?= h($item['label']) ?></span><strong><?= $item['total'] ?></strong><span class="stat-foot">Manage records <b>→</b></span></a><?php endforeach; ?></div>
<section class="panel"><div class="panel-heading"><div><h2>Quick access</h2><p>Choose a section to manage school information.</p></div></div><div class="quick-grid">
<a href="students.php"><span>♙</span><b>Students</b><small>Student profiles and class allocation</small></a>
<a href="class.php"><span>▦</span><b>Classes</b><small>Class names and academic years</small></a>
<a href="subject.php"><span>▤</span><b>Subjects</b><small>Subject names and codes</small></a>
<a href="grade.php"><span>％</span><b>Grades</b><small>Assessment results and marks</small></a>
<a href="attendance.php"><span>✓</span><b>Attendance</b><small>Daily student attendance</small></a>
<a href="annoncement.php"><span>◉</span><b>Announcements</b><small>School notices and messages</small></a>
<a href="users.php"><span>♙</span><b>Users</b><small>System accounts and roles</small></a>
</div></section>
<p>Choose a form from the menu above.</p></body></html>