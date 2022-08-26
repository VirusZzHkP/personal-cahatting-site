<?php

//login.php

if(isset($_POST["user_email"]))
{
	include('Db.php');

	$object = new Db;

	$error = '';

	$success_message = '';

	$formdata = array();

    if(empty($_POST["user_email"]))
    {
        $error .= '<li>Email is required</li>';
    }
    else
    {
        if(!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL))
        {
            $error .= '<li>Invalid Email Address</li>';
        }
        else
        {
            $formdata['user_email'] = trim($_POST["user_email"]);
        }
    }

    if(empty($_POST["user_password"]))
    {
        $error .= '<li>Password is required</li>';
    }
    else
    {
        $formdata['user_password'] = trim($_POST["user_password"]);
    }

    if($error == '')
    {
    	$check_data = array(
    		':user_email'		=>	$formdata['user_email']
    	);

    	$object->query = "
    	SELECT * FROM user_cpmvj 
    	WHERE user_email = :user_email
    	";

    	$object->execute($check_data);

        if($object->row_count() > 0)
        {
            $result = $object->statement_result();

            foreach($result as $row)
            {
            	if($row["user_status"] != 'Pending')
            	{
            		if($row["user_password"] == $formdata['user_password'])
            		{
            			$_SESSION['user_id'] = $row["user_id"];

            			$object->query = "
            			UPDATE user_cpmvj 
            			SET user_status = 'Online' 
            			WHERE user_id = '".$row["user_id"]."'
            			";

            			$object->get_result();
            		}
            		else
            		{
            			$error .= '<li>Wrong Password</li>';
            		}
            	}
            	else
            	{
            		$error .= '<li>Please first verify your email address</li>';
            	}
            }
        }
        else
        {
        	$error = '<li>Wrong Email Address</li>';
        }
    }

    $output = array(
    	'error'		=>	$error
    );

    echo json_encode($output);
}

?>