<?php

//setting.php

include('Db.php');

$object = new Db;

$data = array();

if(isset($_POST["user_first_name"]))
{
	$error = '';

	$success_message = '';

	$formdata = array();

	$formdata['user_image'] = $_POST["hidden_user_image"];

	if(empty($_POST["user_first_name"]))
    {
        $error .= '<li>First Name is required</li>';
    }
    else
    {
        if (!preg_match("/^[a-zA-Z']*$/", $_POST["user_first_name"]))
        {
            $error .= '<li>Only Alphabets allowed</li>';
        }
        else
        {
            $formdata['user_first_name'] = trim($_POST["user_first_name"]);
        }
    }

    if(empty($_POST["user_last_name"]))
    {
        $error .= '<li>Last Name is required</li>';
    }
    else
    {
        if (!preg_match("/^[a-zA-Z']*$/", $_POST["user_last_name"]))
        {
            $error .= '<li>Only Alphabets allowed</li>';
        }
        else
        {
            $formdata['user_last_name'] = trim($_POST["user_last_name"]);
        }
    }

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
        if (!preg_match("/^[a-zA-Z-0-9']*$/", $_POST["user_password"]))
        {
            $error .= '<li>Only letters and Numbers allowed</li>';
        }
        else
        {
            $formdata['user_password'] = trim($_POST["user_password"]);
        }
    }

    if(!empty($_FILES['user_image']['name']))
    {
    	$img_name = $_FILES['user_image']['name'];
    	$img_type = $_FILES['user_image']['type'];
    	$tmp_name = $_FILES['user_image']['tmp_name'];
    	$fileinfo = @getimagesize($_FILES["user_image"]["tmp_name"]);
    	$width = $fileinfo[0];
    	$height = $fileinfo[1];
    	$image_size = $_FILES['user_image']['size'];
    	$img_explode = explode('.',$img_name);
    	$img_ext = strtolower(end($img_explode));
    	$extensions = ["jpeg", "png", "jpg"];
    	if(in_array($img_ext, $extensions) === true)
    	{
    		$types = ["image/jpeg", "image/jpg", "image/png"];
    		if(in_array($img_type, $types) === true)
    		{
    			if($image_size <= 2000000)
    			{
    				// if($width == '500' && $height == '500')
    				// {
		    			$new_img_name = time().'-'.rand() . '.'.$img_ext;
		    			if(move_uploaded_file($tmp_name,"../images/".$new_img_name))
		    			{
		    				$formdata['user_image'] = $new_img_name;
		    			}
		    			else
		    			{
		    				$error .= '<li>Unable to upload Image file</li>';
		    			}
		    		// }
		    		// else
		    		// {
		    		// 	$error .= '<li>Image dimension should be within 500 X 500</li>';
		    		// }
	    		}
	    		else
	    		{
	    			$error .= '<li>Image size exceeds 2MB</li>';
	    		}
    		}
    		else
    		{
    			$error .= '<li>Invalid Image Type</li>';
    		}
    	}
    	else
    	{
    		$error .= '<li>Invalid Image File</li>';
    	}
    }

    if($error == '')
    {
    	$check_data = array(
    		':user_email'		=>	$formdata['user_email']
    	);

    	$object->query = "
    	SELECT * FROM user_cpmvj 
    	WHERE user_id != '".$_SESSION["user_id"]."' AND user_email = :user_email
    	";

    	$object->execute($check_data);

        if($object->row_count() > 0)
        {
            $error = '<li>Email Already Exists</li>';
        }
        else
        {
        	$user_verification_code = md5(time() . rand());

        	$data = array(
        		':user_first_name'			=>	$formdata['user_first_name'],
        		':user_last_name'			=>	$formdata['user_last_name'],
        		':user_email'				=>	$formdata['user_email'],
        		':user_password'			=>	$formdata['user_password'],
        		':user_image'				=>	$formdata['user_image']
        	);

        	$object->query = "
        	UPDATE user_cpmvj 
        	SET user_first_name = :user_first_name, 
        	user_last_name = :user_last_name, 
        	user_email = :user_email, 
        	user_password = :user_password, 
        	user_image = :user_image 
        	WHERE user_id = '".$_SESSION["user_id"]."'
        	";

        	$object->execute($data);

        	$success_message = 'Data Updated';


        }
    }

    $output = array(
    	'error'		=>	$error,
    	'success'	=>	$success_message, 
    	'ui'		=>	$formdata['user_image']
    );
}

echo json_encode($output);


?>