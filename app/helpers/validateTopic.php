<?php
function validateTopic($topic)
{
    
    $errors=array();
         if(empty($topic['name']))
         {
             array_push($errors,'Topic Name is required');
         }
        
    // Using selectOne() to select email entered by user
    // $existingTopic=selectOne('topics',['name'=>$topic['name']]);
    // if(isset($existingTopic))
    // {
    //     array_push($errors,'Topic name already exists');
    // }

    $existingTopic=selectOne('topics',['name'=>$post['name']]);
    if($existingTopic)
    {
        // Below code ensures that the title of the post can be changed as long as it is not already present in the database
        if(isset($topic['update-topic'])&& $existingTopic['id']!=$topic['id'])
        {
            array_push($errors,'Topic name already exists');
        }

        if(isset($topic['add-topic']))
        {
            array_push($errors,'Topic name already exists');
        }
    }
    return $errors;
}

