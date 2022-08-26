<?php

//check_login.php

include('Db.php');

$object = new Db;

$data = array();

if($object->is_login())
{
	$object->query = "
	SELECT * FROM user_cpmvj 
	WHERE user_id = '".$_SESSION['user_id']."'
	";

	$result = $object->get_result();

	foreach($result as $row)
	{
		$data['user_name'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
		$data['image'] = $object->base_url . 'images/' . $row['user_image'];
	}
}

echo json_encode($data);


?>