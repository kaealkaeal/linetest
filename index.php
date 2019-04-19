<?php
session_start();
require_once('session.php');
$Username = $_SESSION["Username"];
if(!isset($_SESSION["year"]) && !isset($_SESSION["semester"])){
include 'year_semester.php';
}
$year = $_SESSION["year"];
$term = $_SESSION["semester"];

if($Username != "KOHMAHASANOOK_S" && $Username != "MEETAE_B" && $Username != "KAIDEE_S"){
include 'authen.php';
}
include 'connect.php';
$sql = "select * from group_by where account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
$group = $row['group_file'];
}
$sql = "select count(account_name_fri) as total from send_data where account_name_fri = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_data = $row['total'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Workload Management</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="img/logo_icon.ico">
  <style>
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -1px;
}
</style>
</head>
<body style="background-color:lavender;">
<nav class="navbar navbar-default">
<div class="container-fluid">
<div class="navbar-header">
      <a class="navbar-brand" href="index.php">Workload Management</a>
    </div>
    <ul class="nav navbar-nav">
          <li><a href="export.php">ค้นหาและส่งออกงาน</a></li>
          <li><a href="history.php">ประวัติการส่งงาน</a></li>

        </ul>
	<ul class="nav navbar-nav navbar-right">
    <li><a href="receive_file.php"><span class="glyphicon glyphicon-file"></span> งานที่ได้รับ <span class="label label-danger"><?php echo $total_data; ?></span></a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php
            echo $Username;
            $name = $_SESSION["Name"];
            $surename = $_SESSION["Surename"];
            $query1 = "SELECT * FROM user WHERE account_name = '$Username'";
            $result1 = mysqli_query($conn, $query1);
            $row = mysqli_fetch_array($result1);
            if($Username != $row["account_name"]){
              $sql  = "INSERT INTO user (Name, Surename,account_name) VALUES ('$name','$surename','$Username');";
              mysqli_query($conn, $sql);
            }

      ?>  <span class="caret"></span></a><ul class="dropdown-menu">
          <li><a href="profile.php">โปรไฟล์</a></li>
          <?php
          if (isset($_SESSION["demo"])) {
              ?>
          <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> ออกจากระบบ</a></li>
          <?php
          }
          else{
            ?>
    <li><a href="logouts.php"><span class="glyphicon glyphicon-log-in"></span> ออกจากระบบ</a></li>
            <?php
            }
            ?>

        </ul></li>

    </ul>
  </div>
</nav>
<div class="container">

 <div class="row">


 <div class="col-sm-12"><p align="right"><b>ปีการศึกษา <a href="2.php?year=<?php echo $year; ?>&term=<?php echo $term; ?>&o=m" ><button class="btn btn-success btn-sm"><</button></a>
  <?php echo $year; ?>
  <a href="2.php?year=<?php echo $year; ?>&term=<?php echo $term; ?>&o=p" ><button class="btn btn-success btn-sm">></button></a>

  <?php $term; ?>
  เทอม <a href="2.php?year=<?php echo $year; ?>&term=1" ><button class="btn btn-<?php if($term==1){echo "primary";}else{echo "info";}?> btn-sm">1</button></a>
  <a href="2.php?year=<?php echo $year; ?>&term=2" ><button class="btn btn-<?php if($term==2){echo "primary";}else{echo "info";}?> btn-sm">2</button></a>
  <a href="2.php?year=<?php echo $year; ?>&term=3" ><button class="btn btn-<?php if($term==3){echo "primary";}else{echo "info";}?> btn-sm">3</button></a></b></p>
<br>
</div></div>
<?php
$sql = "select count(category) as total from group_by where finish = 0 and category = '' and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_nothing = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 1 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_teach = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 1 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_teach2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 2 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_workcon = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 2 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_workcon2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 3 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_seminar = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 3 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_seminar2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 4 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_writing = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 4 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_writing2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 5 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_research = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 5 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_research2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 6 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_service = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 6 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_service2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 7 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_job = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 7 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_job2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 8 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_other = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 8 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_other2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 9 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_student = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 9 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_student2 = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 1 and category = 10 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_examine = $row['total'];
}
$sql = "select count(finish) as total from group_by where finish = 0 and category = 10 and accept = 1 and year = '$year' and semester = '$term' and account_name = '$Username'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  $total_examine2 = $row['total'];
}


?>
<div class="row">
<div class="form-group">
  <div class="col-sm-3">
<li class="list-group-item">
  งานสอน
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_teach_2.php" style="color:white;"><?php echo $total_teach2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_teach_1.php" style="color:white;"><?php echo $total_teach;?></a></span>
</li>
</div>
<div class="col-sm-3">
<li class="list-group-item">
  งานที่ปรึกษา
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_workcon_2.php" style="color:white;"><?php echo $total_workcon2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_workcon_1.php" style="color:white;"><?php echo $total_workcon;?></a></span>
</li>
</div>
<div class="col-sm-3">
<li class="list-group-item">
  งานสัมมนาวิชาการ
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_seminar_2.php" style="color:white;"><?php echo $total_seminar2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_seminar_1.php" style="color:white;"><?php echo $total_seminar;?></a></span>
</li>
</div>
<div class="col-sm-3">
<li class="list-group-item">
  การเขียนตำราหนังสือ
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_writing_2.php" style="color:white;"><?php echo $total_writing2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_writing_1.php" style="color:white;"><?php echo $total_writing;?></a></span>
</li>
</div>

</div>
</div>
<div class="row">
<div class="form-group">
  <div class="col-sm-3">
  <li class="list-group-item">
    งานวิจัย
    <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_research_2.php" style="color:white;"><?php echo $total_research2;?></a></span>
    <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_research_1.php" style="color:white;"><?php echo $total_research;?></a></span>
  </li>
  </div>
  <div class="col-sm-3">
<li class="list-group-item">
  งานบริการ
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_service_2.php" style="color:white;"><?php echo $total_service2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_service_1.php" style="color:white;"><?php echo $total_service;?></a></span>
</li>
</div>
<div class="col-sm-3">
<li class="list-group-item">
  งานบริหาร
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_job_2.php" style="color:white;"><?php echo $total_job2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_job_1.php" style="color:white;"><?php echo $total_job;?></a></span>
</li>
</div>
<div class="col-sm-3">
<li class="list-group-item">
  งานลักษณะอื่น
  <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_other_2.php" style="color:white;"><?php echo $total_other2;?></a></span>
  <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_other_1.php" style="color:white;"><?php echo $total_other;?></a></span>
</li>
</div>
</div>
</div>
<div class="row">
<div class="form-group">
  <div class="col-sm-3">
  <li class="list-group-item">
    งานกิจการนักศึกษา
    <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_student_2.php" style="color:white;"><?php echo $total_student2;?></a></span>
    <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_student_1.php" style="color:white;"><?php echo $total_student;?></a></span>
  </li>
  </div>
  <div class="col-sm-3">
  <li class="list-group-item">
    งานกรรมการคุมสอบ
    <span class="badge" style="background-color:#FF3333" title='กรอกยังไม่ครบ'><a href="show_examine_2.php" style="color:white;"><?php echo $total_examine2;?></a></span>
    <span class="badge" style="background-color:#00CC33" title='กรอกครบแล้ว'><a href="show_examine_1.php" style="color:white;"><?php echo $total_examine;?></a></span>
  </li>
  </div>
<div class="col-sm-3">
<li class="list-group-item">
  ยังไม่ได้แยกประเภทภาระงาน
  <span class="badge" style="background-color:#00CCFF" title='ยังไม่ได้แยกประเภทภาระงาน'><a href="show_nothing.php" style="color:white;"><?php echo $total_nothing;?></a></span>

</li>
</div>

</div>
</div>

<br>


<?php
if(isset($_FILES['fileToUpload'])){
  if($_POST['keyword']=='' && $_POST['gg']==''){
    echo '';
}else {
for($i=0; $i<count($_FILES['fileToUpload']['name']); $i++){

$name = $_FILES['fileToUpload']['name'][$i];
$size = $_FILES['fileToUpload']['size'][$i];
$type = $_FILES['fileToUpload']['type'][$i];
$tmp = $_FILES['fileToUpload']['tmp_name'][$i];
$file_group =1;
$fileToUpload = 'upload/'.$name;
move_uploaded_file($tmp,$fileToUpload);
$group_file = $group +1;
if($name !=''){
$add = "INSERT into temp (file_name,account_name,group_file) values ('$name','$Username','$group_file')";
mysqli_query($conn,$add);
}

}
$adds = "INSERT into group_by (keyword, category,account_name,group_file, year, semester, accept, finish) values ('".$_POST['keyword']."','','$Username','$group_file','$year','$term','1','0')";
mysqli_query($conn,$adds);
}
}
?>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <?php if(!isset($_POST['import']) || !isset($_POST['next0'])){
            echo "<b>ชื่อหัวข้อหรืออัพโหลดไฟล์</b>";
          }if(isset($_POST['next0'])){echo "<b> > เลือกประเภทภาระงาน</b>";}

            ?>

        </div>
        <div class="panel-body">
      <?php
if(!isset($_POST['import']) && !isset($_POST['next0'])){
       ?>
<center>
  <p style="color:red">* กรอกชื่อหัวข้อหรืออัพโหลดไฟล์ อย่างใดอย่างหนึ่ง หรือทั้งสองอย่างก็ได้</p> <br>
    <form method="post" enctype="multipart/form-data" id="importFrm">
    <input class="form-control" type="text" name="keyword" placeholder="หัวข้อ" style="width: 300px;"> <br>
       <div class="input-group" style="width: 300px;">
              <label class="input-group-btn">
                  <span class="btn btn-default">
                      <span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"> <input type="file" name="fileToUpload[]" id="fileToUpload" style="display: none;" multiple>

                  </span>
              </label>

            <input type="text" class="form-control" name="gg" placeholder="เลือกไฟล์ที่ต้องการ" readonly>

        </div><br>


    <center><input type="submit" class="btn btn-success" name="import" value="ยืนยัน"></center>
    </form>
</center>
<?php }?>
<?php

 ?>
<br><form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

<?php
if(isset($_POST['import'])){

  if($_POST['keyword']=='' && $_POST['gg']==''){
    echo '<script type="text/javascript">';
    echo 'alert("กรุณากรอกชื่อหัวข้อหรืออัพโหลดไฟล์ อย่างใดอย่างหนึ่งก่อนกดยืนยัน");';
    echo 'window.location.href = "index.php"';

    echo '</script>';
  }else{
$sql = "select * from group_by where keyword = '".$_POST['keyword']."' and account_name = '$Username' and group_file = '$group_file' and accept ='1' and finish ='0' and year ='$year' and semester='$term' and category =''";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
  if($row['keyword']!=''){
echo "<center><label>ชื่อหัวข้อ : ".$row["keyword"]."</label></center><br>";
}else {
  echo "<center><label>ชื่อหัวข้อ : ไม่มีชื่อหัวข้อ [".$group_file."]</label></center><br>";
}
}
  echo "<center><label>ชื่อไฟล์ : </label>";
$sql = "select * from temp where account_name = '$Username' and group_file = '$group_file'";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {

echo "<button type='button' class='btn btn-xs'><a href='upload/".$row["file_name"]."' target='_blank'>".$row["file_name"]."</a></button>&nbsp;&nbsp;&nbsp;";

}
echo "<br><br><button class='btn btn-success' name='next0' type='submit'>เลือกประเภทภาระงาน</button> <a href='index.php'><button class='btn btn-danger' type='submit'>ยังไม่แยกประเภทภาระงาน</button></a></center>";
}}
if(isset($_POST['next0'])){
   echo "<p style='color:green'>* เลือกประเภทของภาระงาน</p> <div class='container'><div class='dropdown'>
<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>ประเภทของภาระงาน
<span class='caret'></span></button>
<ul class='dropdown-menu'>

<li class='dropdown-submenu'>
  <a class='test' href='#'>งานสอน <span class='caret'></span></a>
  <ul class='dropdown-menu'>

      <li><a tabindex='-1' href='#'><b>ระดับการศึกษา</b></a></li>
      <li class='dropdown-submenu'>
      <a class='test' href='#' value='1'>ปริญญาตรี<span class='caret'></span></a>
      <ul class='dropdown-menu'>
        <li class='dropdown-submenu'>
            <li><a tabindex='-1' href='#'><b>ประเภทการสอน</b></a></li>
            <li><a tabindex='-1' href='run_teach_e1_c1.php'>งานผลิตบัณฑิตในความรับผิดชอบของคณะวิทยาศาสตร์</a></li>
            <li><a tabindex='-1' href='run_teach_e1_c2.php'>งานผลิตบัณฑิตนอกคณะฯ ภายในมหาวิทยาลัยศิลปากร</a></li>

          <ul class='dropdown-menu'>
          </ul>
        </li>
      </ul>
    </li>
        <li class='dropdown-submenu'>
          <a class='test' href='#'>ปริญญาโท<span class='caret'></span></a>
          <ul class='dropdown-menu'>
            <li class='dropdown-submenu'>
                <li><a tabindex='-1' href='#'><b>ประเภทการสอน</b></a></li>
                <li><a tabindex='-1' href='run_teach_e2_c1.php'>งานผลิตบัณฑิตในความรับผิดชอบของคณะวิทยาศาสตร์</a></li>
                <li><a tabindex='-1' href='run_teach_e2_c2.php'>งานผลิตบัณฑิตนอกคณะฯ ภายในมหาวิทยาลัยศิลปากร</a></li>

              <ul class='dropdown-menu'>
              </ul>
            </li>
          </ul>
        </li>
            <li class='dropdown-submenu'>
              <a class='test' href='#'>ปริญญาเอก<span class='caret'></span></a>
              <ul class='dropdown-menu'>
                <li class='dropdown-submenu'>
                    <li><a tabindex='-1' href='#'><b>ประเภทการสอน</b></a></li>
                    <li><a tabindex='-1' href='run_teach_e3_c1.php'>งานผลิตบัณฑิตในความรับผิดชอบของคณะวิทยาศาสตร์</a></li>
                    <li><a tabindex='-1' href='run_teach_e3_c2.php'>งานผลิตบัณฑิตนอกคณะฯ ภายในมหาวิทยาลัยศิลปากร</a></li>

                  <ul class='dropdown-menu'>
                  </ul>
                </li>
      </ul>
    </li>
  </ul>
</li>
<li class='dropdown-submenu'>
  <a class='test' href='#'>งานที่ปรึกษา <span class='caret'></span></a>
  <ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทของงานที่ปรึกษา</b></a></li>

<li><a tabindex='-1' href='run_consult.php'>ให้การปรึกษา</a></li>

<li class='dropdown-submenu'>
<a class='test' href='#'>ควบคุมงานวิจัย<span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ระดับการศึกษา</b></a></li>
<li class='dropdown-submenu'>
<a class='test' href='#'>ปริญญาตรี<span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>การควบคุม</b></a></li>
<li><a tabindex='-1' href='run_control_research_e1_p1.php'>ผู้ควบคุมหลักเพียงคนเดียว</a></li>
<li><a tabindex='-1' href='run_control_research_e1_p2.php'>ผู้ควบคุมหลักร่วมกับอาจารย์อีกหนึ่งท่าน</a></li>
<li><a tabindex='-1' href='run_control_research_e1_p3.php'>ผู้ควบคุมหลักร่วมกับอาจารย์อีกสองท่าน</a></li>
<li><a tabindex='-1' href='run_control_research_e1_p4.php'>ผู้ควบคุมร่วมกับอาจารย์อีกหนึ่งท่าน</a></li>
<li><a tabindex='-1' href='run_control_research_e1_p5.php'>ผู้ควบคุมร่วมกับอาจารย์อีกสองท่าน</a></li>
</ul>
</li>
<li class='dropdown-submenu'>
<a class='test' href='#'>ปริญญาโท<span class='caret'></span></a>
<ul class='dropdown-menu'>
  <li><a tabindex='-1' href='#'><b>การควบคุม</b></a></li>
  <li><a tabindex='-1' href='run_control_research_e2_p1.php'>ผู้ควบคุมหลักเพียงคนเดียว</a></li>
  <li><a tabindex='-1' href='run_control_research_e2_p2.php'>ผู้ควบคุมหลักร่วมกับอาจารย์อีกหนึ่งท่าน</a></li>
  <li><a tabindex='-1' href='run_control_research_e2_p3.php'>ผู้ควบคุมหลักร่วมกับอาจารย์อีกสองท่าน</a></li>
  <li><a tabindex='-1' href='run_control_research_e2_p4.php'>ผู้ควบคุมร่วมกับอาจารย์อีกหนึ่งท่าน</a></li>
  <li><a tabindex='-1' href='run_control_research_e2_p5.php'>ผู้ควบคุมร่วมกับอาจารย์อีกสองท่าน</a></li>
</ul>
</li>
  <li class='dropdown-submenu'>
    <a class='test' href='#'>ปริญญาเอก<span class='caret'></span></a>
    <ul class='dropdown-menu'>
      <li><a tabindex='-1' href='#'><b>การควบคุม</b></a></li>
      <li><a tabindex='-1' href='run_control_research_e3_p1.php'>ผู้ควบคุมหลักเพียงคนเดียว</a></li>
      <li><a tabindex='-1' href='run_control_research_e3_p2.php'>ผู้ควบคุมหลักร่วมกับอาจารย์อีกหนึ่งท่าน</a></li>
      <li><a tabindex='-1' href='run_control_research_e3_p3.php'>ผู้ควบคุมหลักร่วมกับอาจารย์อีกสองท่าน</a></li>
      <li><a tabindex='-1' href='run_control_research_e3_p4.php'>ผู้ควบคุมร่วมกับอาจารย์อีกหนึ่งท่าน</a></li>
      <li><a tabindex='-1' href='run_control_research_e3_p5.php'>ผู้ควบคุมร่วมกับอาจารย์อีกสองท่าน</a></li>
    </ul>
    </li>


</ul>
</li>
<li class='dropdown-submenu'>
<a class='test' href='#'>กรรมการสอบ<span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ระดับการศึกษา</b></a></li>
<li class='dropdown-submenu'>
<a class='test' href='#'>ปริญญาตรี<span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
<li><a tabindex='-1' href='run_exam_referee_e1_p1.php'>ประธานการสอบ</a></li>
<li><a tabindex='-1' href='run_exam_referee_e1_p2.php'>กรรมการสอบ</a></li>
</ul>
</li>
<li class='dropdown-submenu'>
<a class='test' href='#'>ปริญญาโท<span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
<li><a tabindex='-1' href='run_exam_referee_e2_p1.php'>ประธานการสอบ</a></li>
<li><a tabindex='-1' href='run_exam_referee_e2_p2.php'>กรรมการสอบ</a></li>
</ul>
</li>
<li class='dropdown-submenu'>
<a class='test' href='#'>ปริญญาเอก<span class='caret'></span></a>
<ul class='dropdown-menu'>
  <li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
  <li><a tabindex='-1' href='run_exam_referee_e3_p1.php'>ประธานการสอบ</a></li>
  <li><a tabindex='-1' href='run_exam_referee_e3_p2.php'>กรรมการสอบ</a></li>
</ul>
</li>
</ul>
</li>
  </ul>
</li>

<li class='dropdown-submenu'>
  <a class='test' href='#'>งานสัมมนาวิชาการ <span class='caret'></span></a>
  <ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทของงานสัมมนาวิชาการ</b></a></li>
<li><a tabindex='-1' href='run_seminar_1.php'>วิทยากรในการสัมมนาวิชาการตามตารางสอน</a></li>
<li><a tabindex='-1' href='run_seminar_2.php'>ผู้ประสานงานในการสัมมนาตามตารางสอน</a></li>
<li><a tabindex='-1' href='run_seminar_3.php'>อาจารย์ที่ปรึกษาสัมมนาวิชาการตามตารางสอน</a></li>
<li><a tabindex='-1' href='run_seminar_4.php'>กรรมการสอบและให้คะแนนในการสัมมนา</a></li>
<li><a tabindex='-1' href='run_seminar_5.php'>อาจารย์ร่วมฟังสัมมนาและซักถามปัญหา</a></li>
  </ul>
  </li>


<li><a tabindex='-1' href='writing.php'>งานการเขียนตำรา/หนังสือ</a></li>


<li class='dropdown-submenu'>
<a class='test' href='#'>งานวิจัย <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทของงานวิจัย</b></a></li>
<li><a tabindex='-1' href='run_chief_1.php'>เป็นหัวหน้าโครงงานวิจัยหรือผู้ร่วมวิจัยที่อยู่ในฐานข้อมูลของคณะฯ</a></li>
<li class='dropdown-submenu'>
<a class='test' href='#'>มีผลงานตีพิมพ์เผยแพร่ การนำไปใช้ประโยชน์ <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทของบทความ</b></a></li>
<li><a tabindex='-1' href='run_publish_1.php'>ISI / สิทธิบัตร</a></li>
<li><a tabindex='-1' href='run_publish_2.php'>ระดับนานาชาติ / อนุสิทธิบัตร</a></li>
<li><a tabindex='-1' href='run_publish_3.php'>ระดับชาติ</a></li>
<li><a tabindex='-1' href='run_publish_4.php'>Proceeding ระดับนานาชาติ</a></li>
<li><a tabindex='-1' href='run_publish_5.php'>Proceeding ระดับชาติ</a></li>
<li><a tabindex='-1' href='run_publish_6.php'>มีการนำผลงานมาใช้ประโยชน์ระดับนานาชาติ</a></li>
<li><a tabindex='-1' href='run_publish_7.php'>มีการนำผลงานมาใช้ประโยชน์ระดับชาติ</a></li>
</ul>
</li>
</ul>
</li>

<li class='dropdown-submenu'>
<a class='test' href='#'>งานบริการ <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>งานบริการอะไร</b></a></li>
<li class='dropdown-submenu'>
<a class='test' href='#'>งานบริการทางวิชาการแก่ชุมชนในความรับผิดชอบของคณะวิทยาศาสตร์ <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทงานบริการ</b></a></li>
<li><a tabindex='-1' href='run_service_w1_c1.php'>การจัดอบรมสัมมนา / นิทรรศการ</a></li>
<li><a tabindex='-1' href='run_service_w1_c2.php'>การรับเชิญเป็นวิทยากร</a></li>
<li><a tabindex='-1' href='run_service_w1_c3.php'>งานพิจารณาผลงานทางวิชาการในลักษณะอื่นๆ</a></li>
<li><a tabindex='-1' href='run_service_w1_c4.php'>งานบริการทางวิชาการแก่ชุมชนลักษณะอื่นๆ ตามที่ได้รับมอบหมาย</a></li>
<li><a tabindex='-1' href='run_service_w1_c5.php'>งานที่ปรึกษาให้แก่หน่วยงานภายนอก</a></li>
<li><a tabindex='-1' href='run_service_w1_c6.php'>งานพิจารณาผลงานทางวิชาการเพื่อขอกำหนดตำแหน่งทางวิชาการ</a></li>

</ul>
</li>
<li class='dropdown-submenu'>
<a class='test' href='#'>งานบริการทางวิชาการแก่ชุมชนนอกคณะวิทยาศาสตร์ <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทงานบริการ</b></a></li>
<li><a tabindex='-1' href='run_service_w2_c1.php'>การจัดอบรมสัมมนา / นิทรรศการ</a></li>
<li><a tabindex='-1' href='run_service_w2_c2.php'>การรับเชิญเป็นวิทยากร</a></li>
<li><a tabindex='-1' href='run_service_w2_c3.php'>งานพิจารณาผลงานทางวิชาการในลักษณะอื่นๆ</a></li>
<li><a tabindex='-1' href='run_service_w2_c4.php'>งานบริการทางวิชาการแก่ชุมชนลักษณะอื่นๆ ตามที่ได้รับมอบหมาย</a></li>
<li><a tabindex='-1' href='run_service_w2_c5.php'>งานที่ปรึกษาให้แก่หน่วยงานภายนอก</a></li>
<li><a tabindex='-1' href='run_service_w2_c6.php'>งานพิจารณาผลงานทางวิชาการเพื่อขอกำหนดตำแหน่งทางวิชาการ</a></li>
</ul>
</li>
</ul>
</li>


<li class='dropdown-submenu'>
<a class='test' href='#'>งานบริหาร <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ประเภทของตำแหน่ง</b></a></li>
<li><a tabindex='-1' href='run_job_p1.php'>ตำแหน่งทางบริหาร</a></li>
<li><a tabindex='-1' href='run_job_p2.php'>ตำแหน่งบริหารลักษณะอื่นๆ ตามที่ได้รับมอบหมาย</a></li>
</ul>
</li>

<li class='dropdown-submenu'>
<a class='test' href='#'>งานในลักษณะอื่นๆ ตามที่ได้รับมอบหมายจากผู้บังคับบัญชา <span class='caret'></span></a>
<ul class='dropdown-menu'>
  <li><a tabindex='-1' href='#'><b>ประเภทของงานในลักษณะอื่นๆ</b></a></li>
  <li class='dropdown-submenu'>
    <a class='test' href='#'>งานราชการอื่นๆ <span class='caret'></span></a>
    <ul class='dropdown-menu'>
      <li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
      <li><a tabindex='-1' href='run_other_c1_p1.php'>คณะกรรมการการวิจัยฯ</a></li>
      <li><a tabindex='-1' href='run_other_c1_p2.php'>คณะกรรมการประจำคณะฯ</a></li>
      <li><a tabindex='-1' href='run_other_c1_p3.php'>คณะกรรมการวิชาการฯ</a></li>
      <li><a tabindex='-1' href='run_other_c1_p4.php'>คณะกรรมการบัณฑิตศึกษาฯ</a></li>
      <li><a tabindex='-1' href='run_other_c1_p5.php'>กรรมการหนังสือที่ระลึกคณะวิทยาศาสตร์ครบรอบ 50 ปี</a></li>
      <li><a tabindex='-1' href='run_other_c1_p6.php'>กรรมการสอบสัมภาษณ์ต่างๆ</a></li>
    </ul>
  </li>
<li><a tabindex='-1' href='run_other_c2.php'>บริหารหลักสูตร</a></li>
<li class='dropdown-submenu'>
<a class='test' href='#'>เหรัญญิก <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
<li><a tabindex='-1' href='run_other_c3_p1.php'>เหรัญญิก</a></li>
<li><a tabindex='-1' href='run_other_c3_p2.php'>วัสดุภาค</a></li>
</ul>
</li>
<li class='dropdown-submenu'>
<a class='test' href='#'>งานอื่นๆ <span class='caret'></span></a>
<ul class='dropdown-menu'>
<li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
<li><a tabindex='-1' href='run_other_c4_p1.php'>ประธานห้องข้อสอบ</a></li>
<li><a tabindex='-1' href='run_other_c4_p2.php'>กรรมการห้องข้อสอบ</a></li>
</ul>
</li>

</ul>
</li>


<li class='dropdown-submenu'>
<a class='test' href='#'>งานกิจการนักศึกษา <span class='caret'></span></a>
<ul class='dropdown-menu'>
  <li><a tabindex='-1' href='#'><b>ตำแหน่ง</b></a></li>
  <li><a tabindex='-1' href='run_student_1.php'>คณะกรรมการฝ่ายกิจการนักศึกษาของคณะฯ</a></li>
  <li><a tabindex='-1' href='run_student_2.php'>อาจารย์ที่ปรึกษาหอพัก</a></li>
  <li><a tabindex='-1' href='run_student_3.php'>อาจารย์ที่ปรึกษาชมรม</a></li>
</ul>
</li>


<li class='dropdown-submenu'>
  <a class='test' href='#'>งานกรรมการคุมสอบ <span class='caret'></span></a>
  <ul class='dropdown-menu'>
    <li><a tabindex='-1' href='#'><b>การสอบ</b></a></li>
    <li><a tabindex='-1' href='run_examine_1.php'>สอบกลางภาค</a></li>
    <li><a tabindex='-1' href='run_examine_2.php'>สอบปลายภาค</a></li>
  </ul>
</li>




      </ul>
    </li>
  </ul>
</li>
</ul>
</div></div>"; }
?>
</form>
  </div>

  </div>

</div></div></div>
  <script>
  $(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
      $(this).next('ul').toggle();
      e.stopPropagation();
      e.preventDefault();
    });
  });
  </script>

  <script>
    $(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
      var input = $(this),
          numFiles = input.get(0).files ? input.get(0).files.length : 1,
          label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });

  });
  </script>
</body>
</html>
