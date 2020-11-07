<?php
function validatePost($post)
{
    
    $errors=array();
         if(empty($post['title']))
         {
             array_push($errors,'Post Title is required');
         }
         if(empty($post['body']))
         {
             array_push($errors,'Body is required');
         }
         if(empty($post['topic_id']))
         {
             array_push($errors,'Topic id is required');
         }
        
    // Using selectOne() to select email entered by user
    $existingPost=selectOne('posts',['title'=>$post['title']]);
    if($existingPost)
    {
        // Below code ensures that the title of the post can be changed as long as it is not already present in the database
        if(isset($post['update-post'])&& $existingPost['id']!=$post['id'])
        {
            array_push($errors,'Post with this title already exists');
        }

        if(isset($post['add-post']))
        {
            array_push($errors,'Post with this title already exists');
        }
    }
    return $errors;
}