<?php
if(!empty($_POST['id']))
{
include("connect_mssql_db.php");
 
  $result = sqlsrv_query($conn,"exec deleteBook {$_POST['id']};");
  if (!$result){
        echo "error";
  }
  else {
  	 while($row = sqlsrv_fetch_array($result)){
	 	if($row[0]==1000) echo "Не возможно удалить книгу. Кто-то должен книгу!";
			
	 } 
	 echo " OK!";
  };
sqlsrv_close($conn);
}
?>