<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");
$table='posts';
$topics=selectAll('topics');
$posts=selectAll($table);

$errors=array();
$title="";
$body="";
$topic_id="";
$published="";

if(isset($_GET['id']))
{
    $post=selectOne($table,['id'=>$_GET['id']]);
    // dd($post);
    $id=$post['id'];
    $title=$post['title'];
    $body=$post['body'];
    $topic_id=$post['topic_id'];
    $published=$post['published'];
}
// code for delete functionality
if(isset($_GET['delete_id']))
{
    $count=delete($table,$_GET['delete_id']);
    $_SESSION['message']="Post deleted successfully";
    $_SESSION['type']="success";
    header('location:' . BASE_URL . '/admin/posts/index.php');
    exit();
}
// Code to check if published and p_id field to enable publish and unpublish in posts
if(isset($_GET['published'])&&isset($_GET['p_id']))
{
    $published=$_GET['published'];
    $id=$_GET['p_id'];
    $p_id=$_GET['p_id'];
    // Update published
    $count=update($table,$p_id,['published'=>$published]);
    $_SESSION['message']="Post published state changed successfully";
    $_SESSION['type']="success";
    header('location:' . BASE_URL . '/admin/posts/index.php');
    exit();


}



if(isset($_POST['add-post']))
{
    // dd($_FILES['image']);
    // dd($_FILES['image']['name']);
    //  dd($_POST);
      $errors=validatePost($_POST);

    if(!empty($_FILES['image']['name']))
    {
            // Store the images under assets/images folder using ROOT_PATH constant
            // Making sure an image with the same file name cannot be stored in post table again.
            $image_name=time() . '_' . $_FILES['image']['name'];
            $destination= ROOT_PATH . "/assets/images/" .          $image_name;
            $result=move_uploaded_file($_FILES['image']['tmp_name'],$destination);

            if($result)
            {
                $_POST['image']=$image_name;
            }
            else{
                array_push($errors,'failed to upload image');
            }

    }
    else{
            array_push($errors,"Post image required");
    }


    if(count($errors)===0)
    {
        // unset($_POST['add-post'],$_POST['topic_id']);
        unset($_POST['add-post']);
        
    // user_id is the id of the currently logged in user
    //$_POST['user_id']=1;
    $_POST['user_id']=$_SESSION['id'];
    
    // $_POST['published']=1;
    // Code to check if the publish checkbox is clicked, the post should be published 
    $_POST['published']=isset($_POST['published']) ? 1 : 0;
    $_POST['body']=htmlentities($_POST['body']);

    $post_id=create($table,$_POST); 
    $_SESSION['message']="Post created successfully";
    $_SESSION['type']="success";
    header('location:' . BASE_URL . '/admin/posts/index.php');
    exit();
    //dd($post_id);
    //  dd($_POST);
    }
    else{
        $title=$_POST['title'];
        $body=$_POST['body'];
        $topic_id=$_POST['topic_id'];
        // Because published field is a checkbox
        $published=isset($_POST['published']) ? 1 : 0;

    }
    
}
if(isset($_POST['update-post']))
{
    $errors=validatePost($_POST);
    if(!empty($_FILES['image']['name']))
    {
            $image_name=time() . '_' . $_FILES['image']['name'];
            $destination= ROOT_PATH . "/assets/images/" .          $image_name;
            $result=move_uploaded_file($_FILES['image']['tmp_name'],$destination);

            if($result)
            {
                $_POST['image']=$image_name;
            }
            else{
                array_push($errors,'failed to upload image');
            }

    }
    else{
            array_push($errors,"Post image required");
    }
     if(count($errors)==0)
    {
        $id=$_POST['id'];
        // unset($_POST['add-post'],$_POST['topic_id']);
        unset($_POST['update-post'],$_POST['id']);
        
        // user_id is the id of the currently logged in user
        // $_POST['user_id']=1;
        $_POST['user_id']=$_SESSION['id'];
        // $_POST['published']=1;
        // Code to check if the publish checkbox is clicked, the post should be published 
        $_POST['published']=isset($_POST['published']) ? 1 : 0;
        $_POST['body']=htmlentities($_POST['body']);

        $post_id=update($table,$id,$_POST); 
        $_SESSION['message']="Post updated successfully";
        $_SESSION['type']="success";
        header('location:' . BASE_URL . '/admin/posts/index.php');
        //dd($post_id);
        //  dd($_POST); 
    }
    else{
        $title=$_POST['title'];
        $body=$_POST['body'];
        $topic_id=$_POST['topic_id'];
        // Because published field is a checkbox
        $published=isset($_POST['published']) ? 1 : 0;

    }
}