<?php
require_once "Database.php";

class User extends Database
{
    public function store($request)
    {
        $first_name = $request['first_name'];
        $last_name  = $request['last_name'];
        $username   = $request['username'];
        $password   = $request['password'];

        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (`first_name`, `last_name`, `username`, `password`)
                VALUES ('$first_name', '$last_name', '$username', '$password')";

        if ($this->conn->query($sql)){
            header('location: ../views');   // go to index.php
            exit;                           // same as die
        } else {
            die('Error creating the user: ' . $this->conn->error);
        }
    }

    public function login($request)
    {
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = $this->conn->query($sql);

        # Check the username
        if ($result->num_rows == 1){
            # Check if the password is correct
            $user = $result->fetch_assoc();
            // $user = ['id' => 1, 'username' => 'john', 'password' => '$2y$10$C9v...'];
            
            if (password_verify($password, $user['password'])){
                # Create session variables for future use.
                session_start();
                $_SESSION['id']         = $user['id'];
                $_SESSION['username']   = $user['username'];
                $_SESSION['full_name']  = $user['first_name'] . " " . $user['last_name'];

                header('location: ../views/dashboard.php');
                exit;
            } else {
                die('Password is incorrect');
            }
        } else {
            die('Username not found.');
        }
    }

    public function logout()
    {
        session_start();
        // unset -- remove the values to forget the data of the previous session
        session_unset();
        // destroy -- delete the session
        session_destroy();

        header('location: ../views');
        exit;
    }

    public function getAllUsers()
    {
        $sql = "SELECT id, first_name, last_name, username, photo FROM users";

        if ($result = $this->conn->query($sql)) {
            // $result contains 4 rows and 5 columns
            return $result;
        } else {
            die('Error retrieving all users: ' . $this->conn->error);
        }
    }
    public function getUser()
    {
        $id = $_SESSION['id'];

        $sql = "SELECT first_name,last_name,username,photo FROM users WHERE id=$id";

        if ($result = $this->conn->query($sql)) {
            return $result->fetch_assoc();
        } else {
            die('Error retrieving the user: '.$this->conn->error);
        }
    }

    public function update($request,$files)
    {   // start session to get session variables
        session_start();
        $id = $_SESSION['id'];

        // get input values from the form
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];
        $photo = $files['photo']['name']; // name of the file
        $photo_tmp = $files['photo']['tmp_name']; // name of the temporary file
        
        // sql command for updating
        $sql = "UPDATE users SET `first_name`='$first_name',`last_name`= '$last_name',`username`= '$username' WHERE `id`='$id'";

        // execute the sql command
        if($this->conn->query($sql))
        { // success
            // update session variable to reflect the update in session
            $_SESSION['username']= $username;
            $_SESSION['full_name']= $first_name . " " . $last_name;

            // check if the user will update the photo 
            if($photo)
            {
                // create 2nd sql command for updating photo
                $sql2 = "UPDATE users SET `photo`='$photo' WHERE `id` = '$id'";

                // execute sql command
                if($this->conn->query($sql2))
                {   // if success
                    // save the photo the assets/images folder
                    $destination = "../assets/images/$photo";

                    // move the tmp file in the destination
                    if(move_uploaded_file($photo_tmp,$destination))
                    {   // if move success

                        header("location: .. /views/dashboard.php");
                        exit;

                    }else{
                        // if move fail
                        die('Error moving the photo.');
                    }

                }else{
                    // if fail
                    die('Error Uploading Photo'.$this->conn->error);
                }
            }

            header('location: ../views/dashboard.php');
            exit;


        }else{
            //if fail
            die('Error Updating the user: '.$this->conn->error);
        }

    }


}

