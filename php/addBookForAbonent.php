<?php
if(!empty($_POST['id']) && !empty($_POST["name"])){
include("connect_mssql_db.php");
 $name = "'".iconv("UTF-8","windows-1251", $_POST['name'])."'";
 $result = sqlsrv_query($conn,"exec addBookForAbonent {$_POST['id']}, $name;");
 if ($result){
  	  $result = sqlsrv_query($conn,"exec getBookForAbonnentByAbon_book {$_POST['id']};");
	  if (!$result){
	        echo "ошибка получения доступных жанров для фильма";
	        exit();
	      }

	  $books="<tr><td> <strong>Удалить </strong></td><td><strong> Название </strong></td></tr>";
	  while($row = sqlsrv_fetch_array($result)){
	  	$item = iconv("windows-1251","UTF-8",$row[0]);
	    $books.='<tr><td style="width:50px"><button onclick="deleteBook('.$row[1].','.$_POST["id"].')" ><i class="icon-remove"></button></td><td>'.$item.'</td></tr>';
	  }
	  $books.=" <tr>
	                            <td><button onclick='addBook({$_POST['id']})' class='btn btn-success' > <span>Добавить</span> </button></td>
	                            <td><select id='addBook'>";
	  $result = sqlsrv_query($conn,"exec getBooks;");
	  if (!$result){
	        echo "ошибка получения всех жанров";
	        exit();
	      }
	      $i=0; 
	  while($row = sqlsrv_fetch_array($result)){
	    $books.="<option>".iconv("windows-1251","UTF-8",$row[2])."</option>";
	  }
	  $books.="</select></td></tr>";
	  echo $books;
	}

  sqlsrv_close($conn);
}
else echo "error";
?>
