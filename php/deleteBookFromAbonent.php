<?php
if(!empty($_POST['id_book']) && !empty($_POST["id_abon_book"])){
include("connect_mssql_db.php");

 $result = sqlsrv_query($conn,"exec delBookFromAbonent {$_POST['id_abon_book']}, {$_POST['id_book']};");
 if ($result){
  	  $result = sqlsrv_query($conn,"exec getBookForAbonnentByAbon_book {$_POST['id_abon_book']};");
	  if (!$result){
	        echo "ошибка получения доступных жанров для фильма";
	        exit();
	      }
	
	  $books="<tr><td> <strong>Удалить </strong></td><td><strong> Название </strong></td></tr>";
	  while($row = sqlsrv_fetch_array($result)){
	  	$item = iconv("windows-1251","UTF-8",$row[0]);
	    $books.='<tr><td style="width:50px"><button onclick="deleteBook('.$row[1].','.$_POST["id_abon_book"].')" ><i class="icon-remove"></button></td><td>'.$item.'</td></tr>';
	  }
	  $books.=" <tr>
	                            <td><button onclick='addBook({$_POST['id_abon_book']})' class='btn btn-success' > <span>Добавить</span> </button></td>
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