<?php

include "databases.php";
session_start();
if(isset($_POST['export_file'])){
	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=DataTestTask1.csv");
	$output = fopen("php://output", "w");
	fputcsv($output, array('id', 'title', 'description', 'width', 'height'));
	if(isset($_POST['sort_object'])){
		$_SESSION['sort_object1'] = [];
		$_SESSION['sort_object1'] = $_POST['sort_object'];
	}
	$text_sort = $_SESSION['sort_object1'];
	$sort_all = "Все";
	if($text_sort == $sort_all){
		$sql = "SELECT * FROM `test-task`";
	} elseif($text_sort != Null){
		$sql = "SELECT * FROM `test-task` WHERE title = '$text_sort'";
	}
	$export = mysqli_query($link, $sql);
	while($row = mysqli_fetch_assoc($export)){
		fputcsv($output, $row);
	}
	fclose($output);
}?>
