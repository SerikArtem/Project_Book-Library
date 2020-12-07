<?php
if(!empty($_POST['passport'])){
include("connect_mssql_db.php");
  $result = sqlsrv_query($conn,"exec deleteAbonent {$_POST['passport']};");
  if (!$result)echo "error";
  else {
  	 while($row = sqlsrv_fetch_array($result)){
	 	if($row[0]==1000) echo "Не возможно удалить абонента, который должен книги!";
			
	 } 
	 echo " OK!";
  };
  sqlsrv_close($conn);
}
else echo "error";
?>