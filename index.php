<?php
include "databases.php";
session_start();
?>
<html>
<style>
@import 'style_front.css';
</style>
<form method="POST">
	<input type="text" name="sort_object" placeholder="Город/Все">
</form>
<form method="POST" action="export.php">
	<input type= "submit" name="export_file" value="Export *.csv" />
</form>
<table class="table">
	<thead>
	<title>TestTask</title>
		<tr>
			<th>ID</th>
			<th>TITLE</th>
			<th>DESCRIPTION</th>
			<th>WIDTH</th>
			<th>HEIGHT</th>
		</tr>
	</thead>
</html>

<?php

include "title_array.php";
include "description_array.php";

$record = 500000;
$page = isset($_GET['page']) ? $_GET['page']: 1;
$limit = 25;
$offset = $limit * ($page - 1);
$total_pages = round(num: $record / $limit, precision: 0);

#______Очистка БД______
#$cut = "TRUNCATE TABLE `test-task`";
#mysqli_query($link, $cut);
#____________________

$connect = mysqli_query($link, "SELECT * FROM `test-task`");
$values = mysqli_query($link, "SELECT COUNT (*) FROM `test-task`");

#Создаёт строчку и записывает в таблицу
if($values < $record){
	for($i = 1; $i <= ($record - $values) ; $i++){
		$rand_title = array_rand($input_title, 1);
		$title = $input_title[$rand_title];
		$rand_description = array_rand($input_description, 1);
		$description = $input_description[$rand_description];
		$width = rand(1,50);
		$height = rand(1,50);
		$insert = "INSERT INTO `test-task` (`id`,`title`,`description`,`width`,`height`) VALUES ('$i','$title','$description','$width','$height')";
		mysqli_query($link, $insert);
		}
}

if(isset($_POST['sort_object'])){
	$_SESSION['sort_object1'] = [];
	$_SESSION['sort_object1'] = $_POST['sort_object'];
}

$text_sort = $_SESSION['sort_object1'];#То что ввели
$connect_new = mysqli_query($link,"SELECT * FROM `test-task` LIMIT $limit OFFSET $offset");
$sort = Null;
if($text_sort != Null){
	$sort = mysqli_query($link, "SELECT * FROM `test-task` WHERE title = '$text_sort' LIMIT $limit OFFSET $offset");#Таблица после сортировки
} else {
	$sort = mysqli_query($link,"SELECT * FROM `test-task` LIMIT $limit OFFSET $offset");
}

$sort_all = "Все";

if($text_sort == $sort_all){
	$check_sort = $connect_new;#Если  запрос и вывод "все" = вывод всей таблицы
} elseif(isset($text_sort) && !empty($text_sort) && $sort != Null){
	$check_sort = $sort;#Проверка не пустой ли запрос = вывод по ключу
} else {
	$check_sort = $sort;
}?>
<html>
	<tbody>
		<?php 
			while($result = mysqli_fetch_assoc($check_sort)){
		echo '
			<tr>
				<td>'.$result["id"].'</td>
				<td>'.$result["title"].'</td>
				<td>'.$result["description"].'</td>
				<td>'.$result["width"].'</td>
				<td>'.$result["height"].'</td>
			</tr>
			';
		}?>
	</tbody>
</table>
</html>
<?php
include "pagination.php";
mysqli_close($link);
?>


