<?php 

// SET HEADER

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Credential: true');
header('Content-Type: application/json; charset=UTF-8');

//including database

require 'database.php';
$db_connection = new Database();
$db = $db_connection->dbConnection();

// CEK GET ID PARAMETER OR NOT

if (isset($_GET['id'])) {
	// IF HAS ID PARAMETER

	$post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT,[
			'options' => [
					'default' => 'all_posts',
					'min_range' => 1
			]
	]);
}

else {
	$post_id = 'all_posts';
}

//MAKE SQL QUERY 
//IF GET POST ID, THEN SHOW POSTS BY ID OTHERWISE SHOW ALL POSTS

$sql = is_numeric($post_id) ? "SELECT * FROM posts WHERE id='$post_id'" : "SELECT * FROM posts ";

$stmt = $db->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0 ) {
	# CREATE POST ARRAY

	$posts_array = [];

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$post_data = [
			'id' => $row['id'],
            'title' => $row['title'],
            'body' => html_entity_decode($row['body']),
            'author' => $row['author']
		];

		array_push($posts_array, $post_data);
	}

	echo json_encode($posts_array);
}

else {

	echo json_encode(['message'=>'NO post FOUND']);
}