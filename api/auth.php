<?php
require 'config.php';

		use Firebase\JWT\JWT;
        require_once './php-jwt-master/src/JWT.php';

/*$password  = 'admin';
  $hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);
			try {
				$stmt = $db->prepare('INSERT INTO gst_users (gst_userName,gst_userPass) VALUES (:username, :password)') ;
				$stmt->execute(array(
					':username' => 'user',
					':password' => $hashedpassword
				));echo'inserted!';
			}catch(PDOException $e){echo $e->getMessage();}
exit;*/


$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)){
	
	 $request = json_decode($postdata);
	 
		$email = filter_var(($request->email), FILTER_SANITIZE_STRING);
		$password = filter_var(($request->password), FILTER_SANITIZE_STRING);;
	
	
//	if(($username == 'admin') && ($password == 'admin')){
	if($user->login($email,$password)){
		$time = time();
        $key = "example_key";
        $token = array(
            'iat' => $time,
            'exp' => $time + (60 * 60),                                                    
            'idUsuario' =>$request->email
        );
		
		http_response_code(200);
		
        $jwt = JWT::encode($token, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        //print_r('token '.$jwt);
        //print_r($decoded);
		echo '
		{
			"success": true,
			"message": "This is the secret no one khows but the admin",
			"jwt": "'.$jwt.'"
		}
		';
	} else {
		
		 http_response_code(401);
		 
		echo '
		{
			"success": false,
			"message": "invalid credentials"
		}
		';
	}
} else {
	echo '
	{
		"success": false,
		"message": "only post method accepted"
	}
	';
}
?> 
