<?php
// Start session to locally store variables. session_start() is defined in db.php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateUser.php");

// using selectAll()
$table='users';
$admin_users=selectAll($table,['admin'=>1]);


// Initializing all fields in the register.php as empty string
$errors=array();
$id='';
$username='';
$admin='';
$email='';
$password='';
$passwordConf='';


// Creating a function to store values as session variables.
function LoginUser($user)
{
            $_SESSION['id']=$user['id'];
            $_SESSION['username']=$user['username'];
            $_SESSION['admin']=$user['admin'];
            $_SESSION['message']='You are now logged in';
            // success is an alredy defines style in style.css
            $_SESSION['type']='success';
            // header('location:' . BASE_URL.'/index.php');
            // exit();
            if($_SESSION['admin'])
            {
                header('location:' . BASE_URL.'/admin/dashboard.php');
            }
            else{
                header('location:' . BASE_URL.'/index.php');
            }
            exit();
}

// Checking if the user presses the signup btn || the user signs up as an admin
    if(isset($_POST['register-btn'])||isset($_POST['create-admin']))
    {
        // var_dump($_POST);
        // die();
     // Creating validation for input fields for signin/signup btn
        $errors=validateUser($_POST);
        
        //  $errors=array();
        //  if(empty($_POST['username']))
        //  {
        //      array_push($errors,'Username is required');
        //  }
        //  if(empty($_POST['email']))
        //  {
        //      array_push($errors,'Email is required');
        //  }
        //  if(empty($_POST['password']))
        //  {
        //      array_push($errors,'Password is required');
        //  }
        // //  if(empty($_POST['passwordConf']))
        // //  {
        // //      array_push($errors,'Confirm Password is required');
        // //  }
        //  if($_POST['passwordConf']!==$_POST['password'])
        //  {
        //      array_push($errors,'Passwords do not match');
        //  }
        //  dd($errors);
        // Checking if error count is 0
        if(count($errors)===0)
        {
        
            // we use unset() so that we can exclude any fields coming in the assosciative array
            unset($_POST['register-btn'],$_POST['passwordConf'],$_POST['create-admin']);
            $_POST['password']=password_hash($_POST['password'],PASSWORD_DEFAULT);

            if(isset($_POST['admin']))
            {
                $_POST['admin']=1;
                $user_id=create($table,$_POST);
                $_SESSION['message']='Admin created successfully';
                $_SESSION['type']='success';
                header('location:' . BASE_URL.'/admin/users/index.php');
                exit();

            }
            else{
                $_POST['admin']=0;
                $user_id=create($table,$_POST);
                $user=selectOne($table,['id'=>$user_id]);
                // dd($_POST);
                // dd($user);
                // log user in after successful signup
                LoginUser($user);
            }
             

        }
        else{
            // The else block will be executed if there are any errors
            // The below section will be executed in case an error was reported in one field, the data will persist in the respective field so that the user need to correct only the wrong entry
            $username=$_POST['username'];
            $admin=isset($_POST['admin']) ? 1 : 0;
            $email=$_POST['email'];
            $password=$_POST['password'];
            $passwordConf=$_POST['passwordConf'];
            
        }
    }
// if the user clicks on update-user button,the new values should be updated to the database
if(isset($_POST['update-user']))
{
    // Copying same code as create user 
    // dd($_POST);
    // Creating validation for input fields for signin/signup btn
    $errors=validateUser($_POST);
  
    
    if(count($errors)===0)
    {
        $id=$_POST['id'];
    
        // we use unset() so that we can exclude any fields coming in the assosciative array
        unset($_POST['passwordConf'],$_POST['update-user'],$_POST['id']);
        $_POST['password']=password_hash($_POST['password'],PASSWORD_DEFAULT);
           
        $_POST['admin']=isset($_POST['admin']) ? 1 : 0;
        $count=update($table,$id,$_POST);
        $_SESSION['message']='Admin created successfully';
        $_SESSION['type']='success';
        header('location:' . BASE_URL.'/admin/users/index.php');
        exit();

    }
               

    
    else{
        // The else block will be executed if there are any errors
        // The below section will be executed in case an error was reported in one field, the data will persist in the respective field so that the user need to correct only the wrong entry
        $username=$_POST['username'];
        $admin=isset($_POST['admin']) ? 1 : 0;
        $email=$_POST['email'];
        $password=$_POST['password'];
        $passwordConf=$_POST['passwordConf'];
        
    }
}

// if the user clicks edit button in the admin/users/index.php all the values should be present inside the edit form

    if(isset($_GET['id']))
    {
        $user=selectOne($table,['id'=>$_GET['id']]);
        $id=$user['id'];
   
        // dd($user);
        $username=$user['username'];
        $admin=isset($user['admin']) ? 1 : 0;
        $email=$user['email'];

    }


    if(isset($_POST['login-btn']))
    {
        // dd($_POST);
        
        $errors=validateLogin($_POST);

        if(count($errors)===0)
        {
            $user=selectOne($table,['username'=>$_POST['username']]);

            if($user && password_verify($_POST['password'],$user['password']))
            {
                //login user and redirect
                LoginUser($user);
            }
            else{
                    array_push($errors,'wrong credentials');
            }
        }

        $username=$_POST['username'];
        $password=$_POST['password'];


    }
    // When the admin user clicks the delete button
    if(isset($_GET['delete_id']))
    {
        $count=delete($table,$_GET['delete_id']);
        $_SESSION['message']='Admin deleted successfully';
        $_SESSION['type']='success';
        header('location:' . BASE_URL.'/admin/users/index.php');
        exit();
    }

?>