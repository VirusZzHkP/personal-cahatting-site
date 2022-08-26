<?php

//logout.php

if(isset($_POST["action"]))
{
	include('Db.php');

	$object = new Db;

	$data = array();

	$object->query = "
	UPDATE user_cpmvj 
	SET user_status = 'Offline' 
	WHERE user_id = '".$_SESSION['user_id']."'
	";

	$object->get_result();

	session_unset();

	session_destroy();

	echo json_encode($data);
}

?>