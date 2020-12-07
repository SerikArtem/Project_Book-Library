<?php
	if(!empty($_POST['passport']) && !empty($_POST['surname']) && !empty($_POST['name']) && !empty($_POST['patronymic']) && !empty($_POST['date_of_birth']) && !empty($_POST['books'])){
		$name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
		$surname = "'".iconv("UTF-8","windows-1251", $_POST['surname'])."'";
		$patronymic = "'".iconv("UTF-8","windows-1251", $_POST['patronymic'])."'";
		$books="";
		for($i=0;$i<count($_POST['books']);++$i){
			$books.=iconv("UTF-8","windows-1251", $_POST['books'][$i]).',';
		}
		$books=substr($books,0,strlen($books)-1)."'";
		include("connect_mssql_db.php");
		$result = sqlsrv_query($conn,"exec addAbonent $passport,$surname, $name,$patronymic,{$_POST['date_of_birth']} $books;");
		if(!$result) {
			echo "404";
			exit();
		}			
	}
	else echo "ошибка добавления";
?>