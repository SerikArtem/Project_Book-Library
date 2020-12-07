<?php
	include("/php/connect_mssql_db.php");
	$result = sqlsrv_query($conn,"exec getAbonents;");
  	if (!$result){
        header("location:../404.html");
        exit();
    }
	$content = "<table class='table-h' style='margin:0px;'>
                        <tr>
                          <td colspan='2'><strong>Действия</strong></td>
						  <td><strong>Номер<br>абонентской книжки</strong></td>
                          <td><strong>Паспорт</strong></td>
                          <td><strong>Фамилия</strong></td>
                          <td><strong>Имя</strong></td>
                          <td><strong>Отчество</strong></td>
                          <td><strong>Дата рождения</strong></td>
                          <td ><strong>Дата выдачи<br>книжки</strong></td>
                          <td><strong>Количество книг</strong></td>
                        </tr>";    
  while($row = sqlsrv_fetch_array($result)){
        $row[2] = iconv("windows-1251","UTF-8",$row[2]);
        $row[3] = iconv("windows-1251","UTF-8",$row[3]);
        $row[4] = iconv("windows-1251","UTF-8",$row[4]);
        $content .= '<tr>
                            <td style="width:50px"><button onclick="edit('.$row[0].')"><i class="icon-pencil"></button></td>
                            <td style="width:50px"><button onclick="deleteCinema('.$row[1].')"><i class="icon-remove"></button></td>
                            <td class="fontSize">'.$row[0].'</td>
                            <td class="fontSize">'.$row[1].'</td>
                            <td class="fontSize">'.$row[2].'</td>
                            <td class="fontSize">'.$row[3].'</td>
							<td class="fontSize">'.$row[4].'</td>
                            <td class="fontSize">'.$row[5]->format('Y-m-d').'</td>
							<td class="fontSize">'.$row[6]->format('Y-m-d').'</td>
                            <td class="fontSize">'.$row[7].'</td>
                          </tr>';
  }
  $content.="</table>";	
  $result = sqlsrv_query($conn,"exec getBooks;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $books="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $books[$i]="<option>".iconv("windows-1251","UTF-8",$row[2])."</option>";
    ++$i;
  }
?>
<html>
<head>
<title></title>
<meta name="" content="">

<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/style2.css" rel="stylesheet" media="screen">
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

function fadeInAddForm(){
      $("#formAddFilm").fadeIn('fast', function() {
        $("#show").empty();
        $("#show").append('<a onclick="fadeOutAddForm()" style="color:white;">Скрыть</a>');
      });

    }
    function fadeOutAddForm(){
      $("#formAddFilm").fadeOut('fast', function() {
        $("#show").empty();
        $("#show").append('<a onclick="fadeInAddForm()" style="color:white;">Добавить</a>');
      });
    }
	function delItem(item){
      $(item).remove();
    }  
	countItem=0;
	function addInput(a){
              var g="<tr id='item"+countItem+"'><td></td><td><div class='control-group' ><div class='controls'><div class='input-append' style='margin-bottom:0px;'><select name='books[]' required style='height:30px; width:181px;'><option></option><?php for($i=0;$i<count($books);++$i)echo $books[$i];?>
                </select><button type='button' class='add-on btn' onclick=\"delItem('#item"+countItem+"')\" style='height:29.5px'><i class='icon-remove'></i></button></div></div></div></td></tr>";
                $(a).after(g);
              ++countItem;
        }
	function deleteCinema(passport){
    	$.post("php/deleteAbonent.php",{"passport":passport},function(data){
            if(data!="error") {alert(data); document.location.href="abonents.php";}
            else alert("Ошибка удаления");
        });
    }
	function edit(abon_book){
      document.location.href = "editabonent.php?abon_book="+abon_book;
    } 
</script>
</head>

<body>
	<div style="position: absolute; left: 212px;"><button style="width: 250px; height: 35px; font-size: 20px;" class='btn btn-success' onclick='books();'><span>Таблица книг</span></button></div>
	<div style="position: absolute; left: 470px;"><button style="width: 250px; height: 35px; font-size: 20px;" class='btn btn-success' onclick='abonents();'><span>Таблица абонентов</span></button></div>
	<div style="position: absolute; left: 1003px; top: 20px;"><button style="width: 150px; height: 35px; font-size: 20px;" class='btn btn-success' onclick='output();'><span>ВЫХОД</span></button></div><br/><br/><br/><br/>

 <div class="container" style="width:940px;">
      <div class="span6" style="width:100%;margin-left:0px;">
          <div class="span6" style="width:100%; margin-bottom:20px; margin-left:0px;">
              <div class="block_content">
                <div class="content-top">
                  <div class="content-top-article">
                    Абоненты
                  </div>
                </div>
                <div class="content-middle">
                  <div class="content-table" >
                    <div style="">
                      <?php echo $content ?>
                    </div>
                    
                    <div id="formAddFilm" style="margin-top:20px;display:none;">
                      <form enctype="multipart/form-data" action="php/addAbonent.php" method="post">
                      <div style="width:400px;float:left;">
                        <table>
                          <tr>
                            <td>Паспорт</td>
                            <td ><input type="text" name="passport" value='<?php echo $_GET["passport"]; ?>' required/></td>
                          </tr>
                           <tr>
                            <td>Фамилия</td>
                            <td ><input type="text" name="surname" value='<?php echo $_GET["surname"]; ?>' required/></td>
                          </tr>
                           <tr>
                            <td>Имя</td>
                            <td ><input type="text" name="name" value='<?php echo $_GET["name"]; ?>' required/></td>
                          </tr>
                          <tr>
                            <td>Отчество</td>
                            <td ><input type="text" name="patronymic" value='<?php echo $_GET["patronymic"]; ?>' required/></td>
                          </tr>
                          <tr>
                            <td>Дата рождения</td>
                            <td ><input type="text" name="date_of_birth" pattern="[0-9]{4}-(([1][0-2])|([0][1-9]))-(([3][0-1])|([0-2][1-9]))" required/></td>
                          </tr>
                       </table>
                      </div> 
                      <div style="width:400px;float:left;">
                        <table>
                        <tr id="add_book">
                          <td>Взять книгу</td>
                             <td>
                               <div class="control-group" >
                                  <div class="controls">
                                    <div class="input-append" style="margin-bottom:0px;">
                                      <select name="books[]" required style="height:30px; width:181px;">
                                        <option><?php echo $_GET["books"]; ?></option>
                                        <?php for($i=0;$i<count($books);++$i)echo $books[$i];?>
                                      </select>
                                      <button type="button" class="add-on btn" onclick="addInput('#add_book')" style="height:29.5px"><i class="icon-plus"></i></button>
                                      </div>
                                    </div>
                                  </div>
                            </td>
                          </tr> 
                          </table>
                        </div>
                        <div style="clear:both;"></div>
                        <div style="width:100%;text-align: center;margin-top:20px;"><button class='btn btn-success' onclick='' style="width: 250px;"><span>Добавить</span></button></div> 
                      </div>
                     </form>
                     <div id="show" style="width:100px;background-color:#51a351;text-align:center;color:white;margin-top:20px;"><a onclick="fadeInAddForm()" style="color:white;">Добавить</a></div>
                    </div>

                  </div>
                  <div  class="content-bottom">
                </div>
              </div>
          </div>  <!--span6-->
      </div>  <!--span6--> 
      <div id="go_to_top" class="go_to_top" title="Наверх" style=" right: 133px; bottom: 115px;"><a href="#"><img src="../img/go_to_top_small.png"></a></div>
    </div>  <!--container-->
	
</body>
</html>