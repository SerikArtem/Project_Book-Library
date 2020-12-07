<?php
include("php/connect_mssql_db.php");
if(empty($_GET["abon_book"])){
  header("location:abonents.php");
}
$result = sqlsrv_query($conn,"exec getAbonentByAbon_book {$_GET['abon_book']};");
  if (!$result){
        header("location:../404.html");
        exit();
  }
  $undef=0;     
  while($row = sqlsrv_fetch_array($result)){
  $id = $row[0];
    $passport = $row[1];
    $name = iconv("windows-1251","UTF-8",$row[3]);
    $date = $row[5]->format('Y-m-d');
    $surname = iconv("windows-1251","UTF-8",$row[2]);
    $patronymic = iconv("windows-1251","UTF-8",$row[4]);
    $undef=1;
  }
  if($undef==0){
    echo "Нет такого фильма!!!";
    exit();
  } 
  $result = sqlsrv_query($conn,"exec getBookForAbonnentByAbon_book {$_GET['abon_book']};");
  if (!$result){
        header("location:../404.html");
        exit();
      }
  $books="<tr><td> <strong>Удалить </strong></td><td><strong> Название </strong></td></tr>";
  while($row = sqlsrv_fetch_array($result)){
    $books.='<tr><td style="width:50px"><button onclick="deleteBook('.$row[1].','.$id.')" ><i class="icon-remove"></button></td><td>'.iconv("windows-1251","UTF-8",$row[0]).'</td></tr>';
  }
  $books.=" <tr>
                            <td><button onclick='addBook($id)' class='btn btn-success' > <span>Добавить</span> </button></td>
                            <td><select id='addBook'/>";
$result = sqlsrv_query($conn,"exec getBooks;");
  if (!$result){
        header("location:../404.html");
        exit();
      }
      $allBooks="";
      $i=0; 
  while($row = sqlsrv_fetch_array($result)){
    $books.="<option>".iconv("windows-1251","UTF-8",$row[2])."</option>";
  }
  $books.="</select></td></tr>";							
?>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/style2.css" rel="stylesheet" media="screen">
    <script type="text/javascript">
    function isEmpty(a){
       if (a !== "" && a !== "0" && a !== 0 && a !== null && a !== false && a !== "undefined") return false;
      return true
    }
    function goToPage(){
      var a=$("#inputIcon").val();
      if (!isEmpty(a)) document.location.href="../result.php?name="+a;
    }
    function delItem(item){
      $(item).remove();
    }
    function deleteBook(id_book,id_abon_book){
          $.post('php/deleteBookFromAbonent.php', {"id_book": id_book,"id_abon_book": id_abon_book}, function(data) {
            $("#editBook").empty();
            $("#editBook").append(data);
          });
        }
    function addBook(id){
      var name = $("#addBook").val();
      $.post('php/addBookForAbonent.php', {"name":name, "id":id}, function(data) {
        $("#editBook").empty();
        $("#editBook").append(data);
      });
    }
    </script>
  </head>
  <body>
    <div class="container" style="width:940px;">
      
      <div class="span6" style="width:100%;margin-left:0px;">
          <div class="span6" style="width:100%; margin-bottom:20px; margin-left:0px;">
              <div class="block_content">
                <div class="content-top">
                  <div class="content-top-article">
                    Редактирование абонента
                  </div>
                </div>
                <div class="content-middle">
                  <div class="content-table" >
                    <div id="formAddFilm" style="margin-top:20px;">
                      <form action="php/updateAbonent.php" method="post">
                      <div style="width:400px;float:left;">
                        <table>
                          <tr>
                            <td>Паспорт</td>
                            <td ><input type="text" name="passport" value="<?php echo $passport; ?>" required/></td>
                          </tr>
                           <tr>
                            <td>Фамилия</td>
                            <td ><input type="text" name="surname" value="<?php echo $surname; ?>" required/></td>
                          </tr>
                           <tr>
                            <td>Имя</td>
                            <td ><input type="text" name="name" value="<?php echo $name; ?>" required/></td>
                          </tr>
                          <tr>
                            <td>Отчество</td>
                            <td ><input type="text" name="patronymic" value="<?php echo $patronymic; ?>" required/>
                            </td>
                          </tr>
                          <tr>
                            <td>Дата рождения</td>
                            <td ><input type="text" name="birthday" value="<?php echo $date; ?>" pattern="[0-9]{4}-(([1][0-2])|([0][1-9]))-(([3][0-1])|([0-2][1-9]))" required/></td>
                          </tr>
                        <tr>
                          <td ><input type="hidden" name="id" value="<?php echo $id; ?>" required/></td>
                        </tr>
                       </table>
                       <div style="width:100%;text-align: center;margin-top:20px;"><button class='btn btn-success' style="width: 250px;"><span>Применить</span></button></div>
                      </div>
                      </form> 
                      <div style="width:400px;float:left;">
                        <strong>Редактировать книги</strong>
                        <br>
                        <table id="editBook" style="margin:0;margin:10px 0;" class='table-h'>
                          
                          <? echo $books ?>
                         
                        </table>
                        </div>
                        <div style="clear:both;"></div>
                      </div>
                    </div>

                  </div>
                  <div  class="content-bottom">
                </div>
              </div>
          </div>  <!--span6-->
      </div>  <!--span6--> 
    </div>  <!--container-->
  </body>
</html>