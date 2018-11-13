<?php
    require_once 'src/core.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);      
        //Выводим список таблиц текущей базы данных
        $sql = "SHOW tables in " . $dbname;
        foreach ($conn->query($sql) as $row) {
           echo "<h2><a href='catalog.php?table=".$row[0]."'>".$row[0] . "</a></h2><br>";   
        }
     
        echo "<hr>";
        
        if(!empty($_GET) && isset($_GET['table'])) {      
            $get_table = $_GET['table'];            
            foreach ($conn->query("SHOW COLUMNS FROM " . $get_table) as $row) {
                echo "<a href='catalog.php?field=".$row[0]."'>".$row[0] . "</a> | " . $row[1];               
                echo "<a href='catalog.php?action=edit&table=".$get_table."&field=".$row[0]."'>  | edit</a>";  
                echo "<a href='catalog.php?action=delete&table=".$get_table."&field=".$row[0]."'>  | del</a>";                             
                echo "<br>";  
                echo "<hr>";
            }   
        
        if(!empty($_GET) && isset($_GET['table']) && isset($_GET['field']) && isset($_GET['name']) && $_GET['action'] == 'edit') {        
            $table = $_GET['table'];
            $field = $_GET['field'];
            $name = $_GET['name'];
            $conn->query("ALTER TABLE `$table` CHANGE `$field` `$name`");        
        }
        if(!empty($_GET) && isset($_GET['table']) && isset($_GET['field']) && isset($_GET['code']) && $_GET['action'] == 'edit') {        
            $table = $_GET['table'];
            $field = $_GET['field'];
            $code = $_GET['code'];
            $conn->query("ALTER TABLE `$table` MODIFY `$field` `$code`");        
        }
        if(!empty($_GET) && isset($_GET['table']) && isset($_GET['field']) && $_GET['action'] == 'delete') {        
            $table = $_GET['table'];
            $field = $_GET['field'];      
            $conn->query("ALTER TABLE `$table` DROP `$field`");        
            echo "Поле " . $_GET['field'] . " успешно удалено. ";        
        }
        }  
    }
    catch(PDOException $e) {
        echo 'Ошибка:' . $e->getMessage() . "<br>";
    }      

    // Закрыть подключение
    $conn = null;        
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Список таблиц</title>
    <style type="text/css">	
      h2 {
        margin: 20px;
        text-align: center; 
        color: navy;
	  }   
      h3 {
        margin: 20px;
        text-align: left;        
	  }    
      a {
        text-decoration: none;
      }
	</style>     
  </head>
  <body>
    <h3><a href="index.php">&laquo; НАЗАД</a></h3> 
  </body>
</html>
