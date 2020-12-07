<?php 
	include("/php/connect_mssql_db.php");
	$result = sqlsrv_query($conn,"exec getBooks;");
  	if (!$result){
        echo "error query getBooks";
        exit();
    }
	$content = "<table class='table-h'>
                        <tr>
                          <td colspan='2'> Действия </td>
                          <td> Автор </td>
                          <td> Название </td>
                          <td> Издательство </td>
                          <td> Год издания </td>
                        </tr>";
  $i=0;                          
  while($row = sqlsrv_fetch_array($result)){
        $row[1] = iconv("windows-1251","UTF-8",$row[1]);
        $row[2] = iconv("windows-1251","UTF-8",$row[2]);
        $row[3] = iconv("windows-1251","UTF-8",$row[3]);
        $content .= '<tr id="row'.$i.'">
                            <td style="width:50px"><button onclick="updateBook(\''.$row[0].'\',\''.$i.'\')"><i class="icon-pencil"></button></td>
                            <td style="width:50px"><button onclick="deleteBook(\''.$row[0].'\')"><i class="icon-remove"></button></td>
                            <td>'.$row[1].'</td>
                            <td>'.$row[2].'</td>
                            <td>'.$row[3].'</td>
                            <td>'.$row[4]->format('Y-m-d').'</td>
                          </tr>';
        ++$i;                  
  }
  $content.="<tr>
                <td colspan='2'><button class='btn btn-success' onclick='addBook()'> <span>Добавить</span> </button></td>
                <td><input type='text' id='addAuthor' placeholder='Автор'/></td>
                <td><input type='text' id='addName' placeholder='Название.'/></td>
                <td><input type='text' id='addPublish' placeholder='Издательство'/></td>
                <td><input type='text' id='addDate' placeholder='Год издания'/></td>
             </tr>   
          </table>";
?>
<html>
<head>
<title></title>
<meta name="" content="">

<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/style2.css" rel="stylesheet" media="screen">
</head>
<script>
	function output(){
		document.location.replace("index.html");
	}
	function books(){
		document.location.href = "books.php";
	}
	function abonents(){
		document.location.href = "abonents.php";
	}

	function isEmpty(a){
       if (a !== "" && a !== "0" && a !== 0 && a !== null && a !== false && a !== "undefined") return false;
      return true
    }
	function isValidDate(date){
          return /[0-9]{4}-(([1][0-2])|([0][1-9]))-(([3][0-1])|([0-2][1-9]))/img.test(date);
    }
	function addBook(){
      var author = $("#addAuthor").val();
      var name = $("#addName").val();
      var publish = $("#addPublish").val();
      var date = $("#addDate").val();
      if(!isEmpty(name) && isValidDate(date) && !isEmpty(author) && !isEmpty(publish)){
        $.post("php/addBook.php",{"author":author,"name":name,"publish":publish,"date":date},function(data){
          if(data!="error") document.location.href="books.php";
          else alert("Ошибка добавления");
        })
      }
      else alert("Заполните корректно поля!!!");
    }
	function deleteBook(id){
      $.post("php/deleteBook.php",{"id":id},function(data){
            if(data!="error") {alert(data);document.location.href="books_.php";}
            else alert("не удалось вызвать процедуру");
        });
    }
	function updateBook(id,i){
       var elem = $("#row"+i).children();
       var author = elem[2].innerText;
       var name = elem[3].innerText;
       var publish = elem[4].innerText;
       var date = elem[5].innerText;
            $(elem[0]).replaceWith('<td style="width:50px"><button onclick="saveBook('+id+','+i+')"><i class="icon-ok"></button></td>');
            $(elem[2]).replaceWith('<td><input id="author'+i+'" type="text" value="'+author+'"/></td>');
            $(elem[3]).replaceWith('<td><input id="name'+i+'" type="text" value="'+name+'"/></td>');
            $(elem[4]).replaceWith('<td><input id="publish'+i+'" type="text" value="'+publish+'"/></td>');
            $(elem[5]).replaceWith('<td><input id="date'+i+'" type="text" value="'+date+'"/></td>');
    }
	function saveBook(id,i){
       var author = $("#author"+i).val();
       var name = $("#name"+i).val();
       var publish = $("#publish"+i).val();
       var date = $("#date"+i).val();
      if(!isEmpty(author) && isValidDate(date) && !isEmpty(publish) && !isEmpty(name)){
       $.post("php/updateBook.php",{"author":author,"name":name,"publish":publish,"date":date,"id":id},function(data){
          if(data!="error") document.location.href="books.php";
            else alert("Ошибка добавления");
        })
      }
      else alert("Заполните корректно поля!!!");
    }
</script>
<body>
	<div style="position: absolute; left: 212px;"><button style="width: 250px; height: 35px; font-size: 20px;" class='btn btn-success' onclick='books();'><span>Таблица книг</span></button></div>
	<div style="position: absolute; left: 470px;"><button style="width: 250px; height: 35px; font-size: 20px;" class='btn btn-success' onclick='abonents();'><span>Таблица абонентов</span></button></div>
	<div style="position: absolute; left: 1003px; top: 20px;"><button style="width: 150px; height: 35px; font-size: 20px;" class='btn btn-success' onclick='output();'><span>ВЫХОД</span></button></div><br/><br/><br/><br/>

	<div class="span6" style="width:942px;margin-left:192px;">
          <div class="block_content" >
                <div class="content-top" >
                  <div class="content-top-article">
                    Книги
                  </div>
                </div>
                <div class="content-middle" >
                  <div class="content-table" style="margin-left: 138px;">
                    <div style="">
                      <?php echo $content ?>
                    </div>
				</div>
			</div>
			<div class="content-bottom"></div>
		</div>		
</body>
</html>