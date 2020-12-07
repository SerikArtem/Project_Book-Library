<?php
if(!empty($_POST['passport']) && !empty($_POST['surname']) && !empty($_POST['name']) && !empty($_POST['patronymic']) && !empty($_POST['date_of_birth']) && !empty($_POST['books'])){
$passport = "'".$_POST['passport']."'";
$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
$surname = "'".iconv("UTF-8","windows-1251", $_POST['surname'])."'";
$patronymic = "'".iconv("UTF-8","windows-1251", $_POST['patronymic'])."'";
$date="'".$_POST['date_of_birth']."'";
$books="'";
for($i=0;$i<count($_POST['books']);++$i){
$books.=iconv("UTF-8","windows-1251", $_POST['books'][$i]).',';
}
$books=substr($books,0,strlen($books)-1)."'";
include("connect_mssql_db.php");
$result = sqlsrv_query($conn,"exec addAbonent $passport,$surname,$name,$patronymic,$date,$books;");
if($result){
$location='document.location.href="../abonents.php"</script>';
}
else {
//echo "error";
echo '<script type="text/javascript">alert("Ошибка!");</script>';
exit();
}
}
else echo "ошибка добавления";
?>
<html>
<head>
<script>
<?php echo $location?>
</script>
</head>
</html>