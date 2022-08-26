<?php

//search_user.php

if(isset($_POST["query"]))
{
	include('Db.php');

	$object = new Db;

	$data = array();

	$t_data = array(
		':user_id'		=>	$_SESSION['user_id'],
		':query'		=>	'%'.trim($_POST["query"]).'%'
	);

	$object->query = "
	SELECT user_id, user_first_name, user_last_name, user_image, user_status 
	FROM user_cpmvj 
	WHERE NOT user_id = :user_id 
	AND (user_first_name LIKE :query OR user_last_name LIKE :query)
	";

	$object->execute($t_data);

	$result = $object->statement_result();

	foreach($result as $row)
	{
		$t_data1 = array(
			':user_id_1'		=>	$_SESSION['user_id'],
			':user_id_2'		=>	$row["user_id"]
		);

		$object->query = "
		SELECT chat_request_id FROM chat_request_cpmvj 
		WHERE (chat_request_sender_id = :user_id_1 AND chat_request_receiver_id = :user_id_2) 
		OR (chat_request_sender_id = :user_id_2 AND chat_request_receiver_id = :user_id_1) 
		";

		$object->execute($t_data1);

		if($object->row_count() == 0)
		{

			$data[] = array(
				'uc'		=>	$object->convert_data($row["user_id"]),
				'un'		=>	$row["user_first_name"] . ' ' . $row["user_last_name"],
				'ui'		=>	$row["user_image"],
				'us'		=>	$row["user_status"]
			);

		}
	}

	echo json_encode($data);
}

?>