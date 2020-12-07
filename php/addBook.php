<?php
if(!empty($_POST['author']) && !empty($_POST['name']) && !empty($_POST['publish']) && !empty($_POST['date']))
{

$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
$date = "'".iconv("UTF-8","windows-1251", $_POST['date'])."'";
$author = "'".iconv("UTF-8","windows-1251", $_POST['author'])."'";
$publish = "'".iconv("UTF-8","windows-1251", $_POST['publish'])."'";

include("connect_mssql_db.php");

  $result = sqlsrv_query($conn,"exec addBook $author,$name,$publish,$date;");
  if (!$result){
        echo "error";
  }
  else echo "true";
sqlsrv_close($conn);
}
?>