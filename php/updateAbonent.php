<?php
if(!empty($_POST['passport']) && !empty($_POST['surname']) && !empty($_POST['name']) && !empty($_POST['patronymic']) && !empty($_POST['birthday']) && !empty($_POST['id'])){
	$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
	$patronymic = "'".iconv("UTF-8","windows-1251", $_POST['patronymic'])."'";
	$surname = "'".iconv("UTF-8","windows-1251", $_POST['surname'])."'";
	$date = "'".$_POST['birthday']."'";
	$id="'".$_POST['id']."'";
	$passport = "'".iconv("UTF-8","windows-1251", $_POST['passport'])."'";
	include("connect_mssql_db.php");
	 $result = sqlsrv_query($conn,"exec updateAbonent $id,$passport, $surname, $name, $patronymic, $date;");
	  if(!$result)echo "404";
	  else {
	  $location='document.location.href="../abonents.php"</script>';
	  }
	}
	else echo "error";
	?>
	<html>
<head>
<script>
<?php echo $location?>
</script>
</head>
</html>