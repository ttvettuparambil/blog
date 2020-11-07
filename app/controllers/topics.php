<?php
include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/validateTopic.php");
// $table contains the name of the table ie in this case topics
$errors=array();
$table='topics';
$id='';
$name='';
$description='';



$topics=selectAll($table);
// dd($topics);
if(isset($_POST['add-topic']))
{
    // dd($_POST);
    // Passing fields to validateTopic.php
    $errors=validateTopic($_POST);
    if(count($errors)===0)
    {
        unset($_POST['add-topic']);
        $topic_id=create('topics',$_POST);
        $_SESSION['message']='Topic created successfully';
        $_SESSION['type']='success';
        header('location:' . BASE_URL . '/admin/topics/index.php');
        exit();
    }
    else{
        $name=$_POST['name'];
        $description=$_POST['description'];

    }
    
}


// Check if id is present in URL slug when user clicks edit button in topics
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $topic=selectOne($table,['id'=>$id]);
    $id=$topic['id'];
    $name=$topic['name'];
    $description=$topic['description'];
}
// Check if del_id is present in the URL slug
if(isset($_GET['del_id']))
{
    $id=$_GET['del_id'];
    $count=delete($table,$id);
    $_SESSION['message']='Topic deleted successfully';
    $_SESSION['type']='success';
    header('location:' . BASE_URL . '/admin/topics/index.php');
    exit();

}


// Checks if the user has clicked the update button in topics
if(isset($_POST['update-topic']))
{
    $errors=validateTopic($_POST);
    if(count($errors)===0)
    {
        // dd($_POST);
        $id=$_POST['id'];
        unset($_POST['update-topic'],$_POST['id']);
        $topic_id=update($table,$id,$_POST);
        $_SESSION['message']='Topic updated successfully';
        $_SESSION['type']='success';
        header('location:' . BASE_URL . '/admin/topics/index.php');
        exit();

    }
    else{
        $id=$_POST['id'];
        $name=$_POST['name'];
        $description=$_POST['description'];

    }
    
   
}