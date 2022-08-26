<?php

class Db
{
	public $base_url;
	public $connect;
	public $query;
	public $statement;
	public $now;
	public $cur_sym;

	public function __construct()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=personalchatting2", "root", "");  //Define Database name in dbname

		$this->base_url = '';  //Define base url here

		date_default_timezone_set('Asia/Kolkata');

		session_start();

		$this->now = date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
	}

	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if($data)
		{
			$this->statement->execute($data);
		}
		else
		{
			$this->statement->execute();
		}		
	}

	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function is_login()
	{
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
		return false;
	}

	function Get_user_name()
	{
		$this->query = "
		SELECT user_name FROM user_cpmvj 
		WHERE user_id = '".$_SESSION['user_id']."'
		";
		$user_name = '';
		$result = $this->get_result();
		foreach($result as $row)
		{
			$user_name = $row["user_name"];
		}
		return $user_name;
	}

	function convert_data($string, $action = 'encrypt')
	{
		$encrypt_method = "AES-256-CBC";
	    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
	    $secret_iv = '5fgf5HJ5g27'; // user define secret key
	    $key = hash('sha256', $secret_key);
	    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
	    if ($action == 'encrypt') {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if ($action == 'decrypt') {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	}

	function clean_input($data)
	{
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}	

	function Get_user_data_from_id($user_id)
	{
		$this->query = "
		SELECT user_first_name, user_last_name, user_image FROM user_cpmvj 
		WHERE user_id = '".$user_id."'
		";
		$data = array();
		$result = $this->get_result();
		foreach($result as $row)
		{
			$data['un'] = $row["user_first_name"] . ' ' . $row["user_last_name"];
			$data['ui'] = $row["user_image"];
		}
		return $data;
	}


}

?>