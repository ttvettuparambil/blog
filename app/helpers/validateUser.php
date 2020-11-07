<?php
function validateUser($user)
{
    
    $errors=array();
         if(empty($user['username']))
         {
             array_push($errors,'Username is required');
         }
         if(empty($user['email']))
         {
             array_push($errors,'Email is required');
         }
         if(empty($user['password']))
         {
             array_push($errors,'Password is required');
         }
        //  if(empty($_POST['passwordConf']))
        //  {
        //      array_push($errors,'Confirm Password is required');
        //  }
         if($user['passwordConf']!==$_POST['password'])
         {
             array_push($errors,'Passwords do not match');
         }
    // Using selectOne() to select email entered by user
    // $existingUser=selectOne('users',['email'=>$user['email']]);
    // if(isset($existingUser))
    // {
    //     array_push($errors,'email already exists');
    // }
    $existingTopic=selectOne('users',['email'=>$user['email']]);
    if($existingUser)
    {
        // Below code ensures that the title of the post can be changed as long as it is not already present in the database
        if(isset($user['update-user'])&& $existingUser['id']!=$user['id'])
        {
            array_push($errors,'Email already exists');
        }

        if(isset($user['create-admin']))
        {
            array_push($errors,'Email already exists');
        }
    }
    return $errors;
}

// login user validation
function validateLogin($user)
{
    
    $errors=array();
         if(empty($user['username']))
         {
             array_push($errors,'Username is required');
         }
         
         if(empty($user['password']))
         {
             array_push($errors,'Password is required');
         }
        //  if(empty($_POST['passwordConf']))
        //  {
        //      array_push($errors,'Confirm Password is required');
        //  }
        //  if($user['passwordConf']!==$_POST['password'])
        //  {
        //      array_push($errors,'Passwords do not match');
        //  }
       
    return $errors;
}