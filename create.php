<?php
//SET HEADER

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Access');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

//including database dan make object

require 'database.php';
$db_connection = new Database();
$db = $db_connection->dbConnection();

// GET DATA FORM REQUEST
$data = json_decode(file_get_contents("php://input"));


//CREATE MESSAGE ARRAY AND SET EMPTY

$msg['message'] = '';

//CEk Jika Mendapatkan data dari request

if (isset($data->title) && isset($data->body) && isset($data->author)){

	if (!empty($data->title) && !empty($data->body) && !empty($data->author)) {

		$insert_query = "INSERT INTO posts (title,body,author) VALUES (:title,:body,:author)";

		$stmt = $db->prepare($insert_query);
		$stmt->bindValue(':title', htmlspecialchars(strip_tags($data->title)), PDO::PARAM_STR);
		$stmt->bindValue(':body', htmlspecialchars(strip_tags($data->body)),PDO::PARAM_STR);
		$stmt->bindValue(':author', htmlspecialchars(strip_tags($data->author)),PDO::PARAM_STR);

		if($stmt->execute()){
			$msg['message'] = 'Data berhasil di masukkan';
		}else{
			$msg['message'] = 'Data tidak berhasil dimasukkan';
		}
	} else {
		$msg['message'] = 'OPPS! empty field detected, Please fill all the fields';
	} 
} else {
	$msg['message'] = "Please fill all the fields | title, body, author";
}

echo json_encode($msg);

?>