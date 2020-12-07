<?php
$serverName = "ARTIOM-PC\SQLEXPRESS"; //если instance и port стандартные, то можно не указывать
$connectionInfo = array("UID" => "sa", "PWD" => "sa", "Database"=>"Library_Book");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
//if(!$conn)echo("fgf");
?>