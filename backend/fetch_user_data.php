<?php

//fetch_user_data.php

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
		$data['ufn'] = $row['user_first_name'];
		$data['uln'] = $row['user_last_name'];
		$data['ue'] = $row['user_email'];
		$data['up'] = $row['user_password'];
		$data['ui'] = $row['user_image'];
		$data['image'] = $object->base_url . 'images/' . $row['user_image'];
	}
}

echo json_encode($data);


?>