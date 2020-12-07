<?php
if(!empty($_POST['author']) && !empty($_POST['name']) && !empty($_POST['publish']) && !empty($_POST['date'])  && !empty($_POST['id']))
{
$author = "'".iconv("UTF-8","windows-1251", $_POST['author'])."'";
$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
$date = "'".iconv("UTF-8","windows-1251", $_POST['date'])."'";
$publish = "'".iconv("UTF-8","windows-1251", $_POST['publish'])."'";
$id = "'".iconv("UTF-8","windows-1251", $_POST['id'])."'";

include("connect_mssql_db.php");

  $result = sqlsrv_query($conn,"exec updateBook $author,$name,$publish,$date,$id;");
  if (!$result){
        echo "error";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>