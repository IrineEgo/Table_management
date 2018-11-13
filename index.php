<?php
    require_once 'src/core.php';

    // Создание соединения и исключения
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);            
        // Создаем новую таблицу
        $sql = "CREATE TABLE IF NOT EXISTS Artists (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        text VARCHAR(150) NOT NULL,
        creation INT(4) NOT NULL
        )";
        $conn->exec($sql);
            //echo 'Таблица создана успешно' . "<br>";
        }
        catch(PDOException $e) {
           echo 'Создать таблицу не удалось:' . $e->getMessage() . "<br>";
        }
       
        if(!empty($_GET) && isset($_GET['action']) && $_GET['action'] == 'add') {       
            // Начинаем транзакцию
            $conn->beginTransaction();
            // Вставляем записи
            $conn->exec("INSERT INTO Artists (firstname, lastname, text, creation)
            VALUES ('Винсент', 'Ван Гог', 'Лодки в Сен-Мари', '1888')");
            $conn->exec("INSERT INTO Artists (firstname, lastname, text, creation)
            VALUES ('Уильям', 'Тернер', 'Дождь, пар и скорость', '1844')");
            $conn->exec("INSERT INTO Artists (firstname, lastname, text, creation)
            VALUES ('Густав', 'Кайботт', 'Парижская улица в дождливую погоду', '1877')");
            $conn->exec("INSERT INTO Artists (firstname, lastname, text, creation)
            VALUES ('Эдгар', 'Дега', 'Оркестр в Опере', '1870')"); 
            $conn->exec("INSERT INTO Artists (firstname, lastname, text, creation)
            VALUES ('Густав', 'Климт', 'Березовая роща I', '1902')");   
      
            // Зафиксировать транзакцию
            $conn->commit(); {
                echo 'Успешно созданы новые записи' . "<br>";
            }
        }
        
        /*// Удаление столбца таблицы reg_date
        $sql = "ALTER TABLE GreatArtists DROP COLUMN reg_date";
        $conn->exec($sql);
            echo 'Столбец успешно удален' . "<br>"; */ 
            
        /*// Изменяем тип поля creation с YEAR на INT
        $sql = "ALTER TABLE GreatArtists MODIFY creation INT(4) NOT NULL";
        $conn->exec($sql);
            echo 'Тип поля успешно изменен' . "<br>"; */ 
        
        /*// Удаление таблицы
        $sql = "DROP TABLE GreatArtists";
        $conn->exec($sql);
            echo 'Таблица успешно удалена' . "<br>"; */         
       
        // Выбираем данные
        $stmt = $conn->prepare("SELECT * FROM Artists");
        $stmt->execute();
        // Устанавливаем результирующий массив в ассоциативный
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
    // Закрыть подключение
    $conn = null;
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Таблицы и базы данных</title>
    <style type="text/css">	
      .wrap {
      	margin: 20px auto;
		width: 60%;
      }
      h2 {
		color: navy;
	  }
      h3 {
        margin: 20px;
        text-align: right;        
	  }
      a {
        text-decoration: none; 
 		color: maroon;       
      }
	  table {
        border-spacing: 0;
        border-collapse: collapse;
      }
	  table td, table th {
        border: 1px solid lightgrey;
        padding: 5px;
      }	  
      tr:first-child {
        background: whitesmoke;
		font-weight: bold;
      }
	</style> 
  </head>
  <body>
    <h3><a href="catalog.php">Список таблиц текущей базы данных &raquo; </a></h3><hr>
    <div class="wrap">
      <h1>Управление таблицами и базами данных</h1>
      <h2>Художники и их полотна</h2>
      <section>
        <table>
            <tr>
                <td>№</td>
                <td>Имя художника</td>
                <td>Фамилия художника</td>
                <td>Название картины</td>
                <td>Год создания картины</td>
            </tr>
            <?php foreach ($stmt as $row): ?>
                <tr>
                    <?php foreach ($row as $field): ?>
                    <td><?php echo $field ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
      </section>
    </div>
  </body>
</html>
