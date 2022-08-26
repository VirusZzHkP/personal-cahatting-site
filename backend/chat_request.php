<?php

//chat_request.php

include('Db.php');

$object = new Db;

$data = array();

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'send_request')
	{
		$chat_request_sender_id = $_SESSION['user_id'];

		$chat_request_receiver_id = $object->convert_data($_POST["uc"], 'decrypt');

		$t_data = array(
			':chat_request_sender_id'		=>	$chat_request_sender_id,
			':chat_request_receiver_id'		=>	$chat_request_receiver_id,
			':chat_request_status'			=>	'Send',
			':chat_request_datetime'		=>	time()
		);

		$object->query = "
		INSERT INTO chat_request_cpmvj 
		(chat_request_sender_id, chat_request_receiver_id, chat_request_status, chat_request_datetime) 
		VALUES (:chat_request_sender_id, :chat_request_receiver_id, :chat_request_status, :chat_request_datetime)
		";

		$object->execute($t_data);

		$data = array(
			'message'	=>	'success'
		);
	}

	if($_POST["action"] == 'load_request')
	{
		$object->query = "
		SELECT * FROM chat_request_cpmvj 
		WHERE chat_request_receiver_id = '".$_SESSION["user_id"]."' 
		AND chat_request_status = 'Send'
		";
		$result = $object->get_result();

		foreach($result as $row)
		{
			$u_data = $object->Get_user_data_from_id($row["chat_request_sender_id"]);
			$data[] = array(
				'rc'		=>	$object->convert_data($row["chat_request_id"]),
				'un'		=>	$u_data['un'],
				'ui'		=>	$u_data['ui'],
				'rd'		=>	date("Y-m-d H:s:i", $row["chat_request_datetime"])
			);
		}
	}

	if($_POST["action"] == 'accept_request')
	{
		$request_id = $object->convert_data($_POST["rc"], 'decrypt');

		$t_data = array(
			':chat_request_id'		=>	$request_id,
			':chat_request_status'	=>	'Accept'
		);

		$object->query = "
		UPDATE chat_request_cpmvj 
		SET chat_request_status = :chat_request_status 
		WHERE chat_request_id = :chat_request_id
		";

		$object->execute($t_data);

		$data = array(
			'message'	=>	$t_data
		);

	}

	if($_POST["action"] == 'load_connected_people')
	{
		$object->query = "
		SELECT chat_request_sender_id, chat_request_receiver_id FROM chat_request_cpmvj 
		WHERE chat_request_status = 'Accept' 
		AND (chat_request_sender_id = '".$_SESSION["user_id"]."' OR chat_request_receiver_id = '".$_SESSION["user_id"]."')
		";

		$result = $object->get_result();

		foreach($result as $row)
		{
			$other_user_id = '';

			if($row["chat_request_sender_id"] != $_SESSION["user_id"])
			{
				$other_user_id = $row["chat_request_sender_id"];
			}

			if($row["chat_request_receiver_id"] != $_SESSION["user_id"])
			{
				$other_user_id = $row["chat_request_receiver_id"];
			}

			$u_data = $object->Get_user_data_from_id($other_user_id);

			$data[] = array(
				'uc'		=>	$object->convert_data($other_user_id),
				'un'		=>	$u_data['un'],
				'ui'		=>	$u_data['ui'],
			);
		}
	}

	if($_POST["action"] == 'load_chat')
	{
		$receiver_user_id = $object->convert_data($_POST['receiver_user_id'], 'decrypt');

		$t_data = array(
			':chat_message_sender_id'		=>	$_SESSION['user_id'],
			':chat_message_receiver_id'		=>	$receiver_user_id
		);

		$where = '';

		if($_POST['last_chat_datetime'] != '')
		{
			$object->query = "
			SELECT * FROM chat_message_cpmvj 
			WHERE chat_message_datetime > '".$_POST['last_chat_datetime']."' AND ((chat_message_sender_id = :chat_message_sender_id AND chat_message_receiver_id = :chat_message_receiver_id) 
			OR (chat_message_sender_id = :chat_message_receiver_id AND chat_message_receiver_id = :chat_message_sender_id)) 
			ORDER BY chat_message_id
			";
		}
		else
		{
			$object->query = "
			SELECT * FROM chat_message_cpmvj 
			WHERE (chat_message_sender_id = :chat_message_sender_id AND chat_message_receiver_id = :chat_message_receiver_id) 
			OR (chat_message_sender_id = :chat_message_receiver_id AND chat_message_receiver_id = :chat_message_sender_id) 
			ORDER BY chat_message_id
			";
		}

		$object->execute($t_data);

		if($object->row_count())
		{

			$result = $object->statement_result();

			$last_chat_datetime = '';

			foreach($result as $row)
			{
				$action = '';
				if($row["chat_message_sender_id"] == $_SESSION['user_id'])
				{
					$action = 'Send';
				}
				else
				{
					$action = 'Receive';
				}

				$data['cm'][] = array(
					'si'		=>	$row["chat_message_sender_id"],
					'ri'		=>	$row["chat_message_receiver_id"],
					'msg'		=>	$row["chat_message"],
					'action'	=>	$action,
					'dt'		=>	date('l j F Y h:i:s A', $row['chat_message_datetime'])
				);

				$last_chat_datetime = $row['chat_message_datetime'];
			}

			

			$data['last_chat_datetime'] = $last_chat_datetime;


		}

		$sender_data = $object->Get_user_data_from_id($_SESSION['user_id']);

		$receiver_data = $object->Get_user_data_from_id($receiver_user_id);

		$data['sender_name'] = $sender_data['un'];
		$data['sender_image'] = $sender_data['ui'];

		$data['receiver_name'] = $receiver_data['un'];
		$data['receiver_image'] = $receiver_data['ui'];
	}

	if($_POST["action"] == 'send_chat')
	{
		$error = '';

		$formdata = array();

		if(empty($_POST["msg"]))
	    {
	        $error .= 'Please Type Something';
	    }
	    else
	    {
	        if (!preg_match("/^[a-zA-Z0-9. ']*$/", $_POST["msg"]))
	        {
	            $error .= 'Only Alphabets, Number, Space etc allowed';
	        }
	        else
	        {
	            $formdata['msg'] = trim($_POST["msg"]);
	        }
	    }

	    $html_output = '';

	    if($error == '')
	    {
	    	$t_data = array(
	    		':chat_message_sender_id'		=>	$_SESSION['user_id'],
	    		':chat_message_receiver_id'		=>	$object->convert_data($_POST["receiver_user_id"], 'decrypt'),
	    		':chat_message'					=>	$formdata['msg'],
	    		':chat_message_status'			=>	'No',
	    		':chat_message_datetime'		=>	time()
	    	);

	    	$object->query = "
	    	INSERT INTO chat_message_cpmvj 
	    	(chat_message_sender_id, chat_message_receiver_id, chat_message, chat_message_status, chat_message_datetime) 
	    	VALUES (:chat_message_sender_id, :chat_message_receiver_id, :chat_message, :chat_message_status, :chat_message_datetime)
	    	";

	    	$object->execute($t_data);

	    	$sender_data = $object->Get_user_data_from_id($_SESSION['user_id']);

	    	$html_output = '
	    	<div class="card text-white bg-info mb-3 w-75 float-end">
	    		<div class="card-body">'.$formdata['msg'].'</div>
	    		<div class="card-footer text-white text-end"><small><img src="images/'.$sender_data['ui'].'" width="25" class="rounded-circle me-2" /><b>'.$sender_data['un'].'</b> on '.date('l j F Y h:i:s A', time()).'</small></div>
	    	</div>
	    	';
	    }

	    $data = array(
	    	'error'		=>	$error,
	    	'lc'		=>	$html_output
	    );
	}
}

echo json_encode($data);
