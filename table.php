<?php
    $pdo = new PDO("mysql:host=localhost;dbname=iegorenkova;charset=utf8", "iegorenkova", "neto1897",[
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    // Создаем новую таблицу
    if (!empty($_POST['create_table']) && !empty($_POST['table_name'])) {
            $sqlCreateTable = "CREATE TABLE {$_POST['table_name']} (id int(11) NOT NULL AUTO_INCREMENT, name VARCHAR(50) NOT NULL, PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $stmtCreateTable = $pdo->prepare($sqlCreateTable);
            $stmtCreateTable->execute();
    }
    // Добавляем новое поле
    if (!empty($_GET['table']) && !empty($_POST['add']) && empty($_POST['name_field']) && !empty($_POST['name_field_new']) && !empty($_POST['typeofdata'])) {
            $sqlAddField = "ALTER TABLE {$_GET['table']} ADD {$_POST['name_field_new']} {$_POST['typeofdata']}";
            $stmtAddField = $pdo->prepare($sqlAddField);
            $stmtAddField->execute();
    }
    // Изменяем поле
    if (!empty($_GET['table']) && !empty($_POST['change']) && !empty($_POST['name_field']) && !empty($_POST['typeofdata'])) {
            if (!empty($_POST['name_field_new'])) {
                    // Изменяем имя поля и тип данных
                    $sqlChange = "ALTER TABLE {$_GET['table']} CHANGE {$_POST['name_field']} {$_POST['name_field_new']} {$_POST['typeofdata']}";
            } else {
                  // Изменяем только тип данных
                    $sqlChange = "ALTER TABLE {$_GET['table']} MODIFY {$_POST['name_field']} {$_POST['typeofdata']}";
            }
                    $stmtChange = $pdo->prepare($sqlChange);
                    $stmtChange->execute();
    }
    // Удаляем поле
    if (!empty($_GET['table']) && !empty($_POST['delete']) && !empty($_POST['name_field']) && empty($_POST['name_field_new']) && empty($_POST['typeofdata'])) {
            $sqlDelete = "ALTER TABLE {$_GET['table']} DROP COLUMN {$_POST['name_field']}";
            $stmtDelete = $pdo->prepare($sqlDelete);
            $stmtDelete->execute();
    }
    // Показываем все таблицы
    $sqlTables = "SHOW TABLES";
    $stmtTables = $pdo->query($sqlTables);
    // Показываем таблицу
    if (!empty($_GET['table'])) {
            $sqlTable = "DESCRIBE {$_GET['table']}";
            $stmtTable = $pdo->prepare($sqlTable);
            $stmtTable->execute();
    }
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
     <meta charset="utf-8">
     <title>Таблицы и базы данных</title>
     <link rel="stylesheet" href=" ./style.css">
  </head>
  <body>
    <header>
      <h1 class="title">Таблицы БД</h1>
    </header>
    <section>
      <div class="tables">
        <h4>Доступные таблицы</h4>
		<ul class="show-tables">
		    <?php foreach ($stmtTables as $rowTables) { ?>
		    <li>
			  <a class="table-name" href="?table=<?php echo htmlspecialchars($rowTables[0]); ?>">
			    <?php echo htmlspecialchars($rowTables[0]); ?>
			  </a>
		    </li>
			    <?php } ?>
		</ul>
		<form class="create-table" method="POST">
		  <h4>Новая таблица БД</h4>
			<input class="table-new" type="text" name="table_name" placeholder="имя таблицы">
			<input type="submit" name="create_table" value="Создать таблицу">
		</form>
      </div>

        <?php if (!empty($_GET['table'])) { ?>
	    <form class="field-operation" method="POST">
	      <table class="table">
	        <tr>
	          <th></th>
	           <th>Field</th>
	           <th>Type</th>
	           <th>Null</th>
	           <th>Key</th>
	           <th>Default</th>
	           <th>Extra</th>
	        </tr>

	        <?php while ($rowTable = $stmtTable->fetch(PDO::FETCH_ASSOC)) { ?>
	        <tr>
		      <td>
		        <input type="radio" name="name_field" value="<?php echo htmlspecialchars($rowTable['Field']); ?>" value="">
		      </td>	
		      <td><?php echo htmlspecialchars($rowTable['Field']); ?></td>
		      <td><?php echo htmlspecialchars($rowTable['Type']); ?></td>
		      <td><?php echo htmlspecialchars($rowTable['Null']); ?></td>
		      <td><?php echo htmlspecialchars($rowTable['Key']); ?></td>
		      <td><?php echo htmlspecialchars($rowTable['Default']); ?></td>
		      <td><?php echo htmlspecialchars($rowTable['Extra']); ?></td>				
	        </tr>
		        <?php } ?>
	      </table>
	      <div class="field-operation-bar">
	        <input class="name-field-new" type="text" name="name_field_new" placeholder="имя поля">
	        <input class="typeofdata" type="text" name="typeofdata" placeholder="тип данных">
	        <input class="add" type="submit" name="add" value="добавить">
	        <input class="change" type="submit" name="change" value="изменить">
	        <input class="delete" type="submit" name="delete" value="удалить">				
	      </div>
	        <input class="reset" type="reset">
	   </form>
	          <?php } ?>
            
          <div class="wrap">
            <a href=" ./index.php" class="logo">&laquo; Перейти на главную</a>
          </div>      
	</section>
  </body>
</html>
