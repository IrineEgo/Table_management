<?php
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
    
    $pdo = new PDO("mysql:host=localhost;dbname=iegorenkova;charset=utf8", "iegorenkova", "neto1897",[
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);    
         
    // Создаем новую таблицу
    $sql = "DROP TABLE IF EXISTS `Artists`";
    $pdo->exec($sql);   
    
    $sql = "CREATE TABLE IF NOT EXISTS `Artists`(
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    text VARCHAR(150) NOT NULL,
    creation INT(4) NOT NULL
    )";
    $pdo->exec($sql);
     
    // Начинаем транзакцию
    $pdo->beginTransaction();
    // Вставляем записи
    $pdo->exec("INSERT INTO Artists (firstname, lastname, text, creation)
    VALUES ('Винсент', 'Ван Гог', 'Лодки в Сен-Мари', '1888')");
    $pdo->exec("INSERT INTO Artists (firstname, lastname, text, creation)
    VALUES ('Уильям', 'Тернер', 'Дождь, пар и скорость', '1844')");
    $pdo->exec("INSERT INTO Artists (firstname, lastname, text, creation)
    VALUES ('Густав', 'Кайботт', 'Парижская улица в дождливую погоду', '1877')");
    $pdo->exec("INSERT INTO Artists (firstname, lastname, text, creation)
    VALUES ('Эдгар', 'Дега', 'Оркестр в Опере', '1870')"); 
    $pdo->exec("INSERT INTO Artists (firstname, lastname, text, creation)
    VALUES ('Густав', 'Климт', 'Березовая роща I', '1902')");   

    //Фиксируем транзакцию
    $pdo->commit(); {
        //echo 'Успешно созданы новые записи' . "<br>";
    }
     
    // Выбираем данные
    $stmt = $pdo->prepare("SELECT * FROM Artists");
    $stmt->execute();
    // Устанавливаем результирующий массив в ассоциативный
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title class="title">Таблицы и базы данных</title>
	<link rel="stylesheet" href=" ./style.css">
  </head>
  <body>

    <header>
      <h1 class="title">Новая таблица в БД</h1>
    </header>         
    <section>
      <h2>Художники и их полотна</h2>
        <table class="table-index">
            <tr>
                <th>№</th>
                <th>Имя художника</th>
                <th>Фамилия художника</th>
                <th>Название картины</th>
                <th>Год создания картины</th>
            </tr>
            <?php foreach ($stmt as $row): ?>
                <tr>
                    <?php foreach ($row as $field): ?>
                    <td><?php echo $field ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="wrap">
          <a href=" ./table.php" class="logo">Список таблиц текущей базы данных &raquo; </a>
        </div>  
      </section>
  </body>
</html>
