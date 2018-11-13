<?php   
    // Подключение к MySQL
    $servername = 'localhost';
    $username = 'iegorenkova';
    $password = 'neto1897';
    $dbname = 'iegorenkova';

    // Создание соединения и исключения
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Установить режим ошибки PDO в исключение
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
           echo 'Подключение к БД не получилось' . $e->getMessage() . "<br>";
        }  
?>		
