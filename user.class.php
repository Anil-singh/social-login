<?php

	Class User {
		public $table_name = "users";
		/* Defines User class constructor */
		function __construct() {		   
	    }

	    /* Gets a user details from db */
		function getUser($email,$email_exists=true){
			global $mysqli;
                        $queryStr = "";
                        if($email_exists == true){
                           $queryStr = "email = '$email'" ;
                        }
                        else{
                            $queryStr = "twitter_id = '$email'" ;
                        }
			$row = array();
			$stmt = $mysqli->prepare("SELECT id,first_name,last_name,email,gender FROM $this->table_name WHERE $queryStr");
            $stmt->execute();
			$stmt->bind_result($id, $first_name,$last_name,$email,$gender);
			while ($stmt->fetch()){
				$row[] = array('id' => $id, 'first_name' => $first_name, 'last_name' => $last_name,'email'=>$email,'gender' =>$gender);
			}
			return $row;
		}

		/* Adds a new user in db */
		function addUser($first_name,$last_name,$email,$gender,$twitter_id=""){
			global $mysqli;
                        if($twitter_id == ""){
                            $stmt = $mysqli->prepare("INSERT INTO ".$this->table_name."(
                                    first_name,
                                    last_name,
                                    email,
                                    gender
                                    )
                                    VALUES(
                                    ?,?,?,?)"
                            );
                            $stmt->bind_param('sssi',$first_name,$last_name,$email,$gender);
                                    }
                        else{
                            $stmt = $mysqli->prepare("INSERT INTO ".$this->table_name."(
                                    first_name,
                                    last_name,
                                    email,
                                    gender,
                                    twitter_id
                                    )
                                    VALUES(
                                    ?,?,?,?,?)"
                            );
                            $stmt->bind_param('sssii',$first_name,$last_name,$email,$gender,$twitter_id);
                        }
	        return $result = $stmt->execute();        
		}
	}