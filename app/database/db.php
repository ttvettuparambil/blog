<?php
session_start();
// db.php now has access to connection object(connect.php)
 require('connect.php');
// $sql="select * from users";
// $stmt=$conn->prepare($sql);
// $stmt->execute();
// get_result() fetches result of $sql, fetch_all() fetches all the records correspondoing to the sql query and MYSQLI_ASSOC is a constant used to specify that the result should be passed onto $users
// $users=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// var_dump($users);
// The below statement is used to prettify the $sql query   response
// echo "<pre>", print_r($users),"</pre>";

//Creating a temporary function to print variables.To be deleted later.
function dd($value)
{
    // pretty print the output
    echo "<pre>", print_r($value,true),"</pre>";
    die();
}

// executeQuery() is used to reduce code redundancy in selectAll as well as selectOne().
// $data is the formal parameter for $conditions as well as for $data that is to be passed from create() as well.
function executeQuery($sql,$data)
{
    global $conn;
        $stmt=$conn->prepare($sql);
        //extracting values from $conditions array
        $values=array_values($data);
        // $types takes a string and repeats it number of times.If the query takes 3 values, then str_repeat will run 3 times.
        $types=str_repeat('s',count($values));
        // Dynamically add parameters according to the query
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        return $stmt; 
}

// selectAll function is used to dynamically take as argument a table in blog database and create prepared sql statements and execute them.
// function selectAll($table)
// {
//     global $conn;
//     $sql="SELECT * from $table";
//     $stmt=$conn->prepare($sql);
//     $stmt->execute();
//     $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//     return $records;

// }


// To make a parameter optional in php give it any value
//We use the $conditions to make sure that the selectAll() returns all records in table as well as specific records in table.
function selectAll($table,$conditions =[])
{
    global $conn;
    $sql="SELECT * from $table";
    if(empty($conditions))
    {
        $stmt=$conn->prepare($sql);
        $stmt->execute();
        $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
    else
    {
        //initailizing variable for key-value pairs
        $i=0;
        // Return records that match the condition
        // AND condition in query means that both conditions need to be true in order to return record from database
        foreach($conditions as $key=>$value)
        {
            if($i===0)
            {
            $sql=$sql . " WHERE $key=?";
            }
            else{
                $sql=$sql . " AND $key=?";
            }
            $i++;
        }  
        //  dd($sql);
        $stmt=executeQuery($sql,$conditions);
        $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}

// selectOne() is similar to selectAll() so we replicate code from selectAll()

function selectOne($table,$conditions)
{
    global $conn;
    $sql="SELECT * from $table";
        //initailizing variable for key-value pairs
    $i=0;
        // Return records that match the condition
        // AND condition in query means that both conditions need to be true in order to return record from database
        foreach($conditions as $key=>$value)
        {
            if($i===0)
            {
            $sql=$sql . " WHERE $key=?";
            }
            else{
                $sql=$sql . " AND $key=?";
            }
            $i++;
        }  
        // Limit 1 is used to indicate that when the query has found a match it is to be terminated immediately.
        $sql=$sql . " LIMIT 1";
        $stmt=executeQuery($sql,$conditions);
        // fetch_assoc() will fetch the single particular record
        $records=$stmt->get_result()->fetch_assoc();
        return $records;
    
}
// selectOne() ends

//create() takes 2 arguments-table for tablename and data for the data that is to be inputted to the table
function create($table,$data)
{
    global $conn;
    $sql="INSERT INTO $table SET ";
    $i=0;
    // Return records that match the condition
    // AND condition in query means that both conditions need to be true in order to return record from database
    foreach($data as $key=>$value)
    {
        if($i===0)
        {
        $sql=$sql . " $key=?";
        }
        else{
            $sql=$sql . ", $key=?";
        }
        $i++;
    }  
    // dd($sql);
    $stmt=executeQuery($sql,$data);
    $id=$stmt->insert_id;
    return $id;
}

// Creating update()
function update($table,$id,$data)
{
    global $conn;
    $sql="UPDATE $table SET ";
    $i=0;
    // Return records that match the condition
    // AND condition in query means that both conditions need to be true in order to return record from database
    foreach($data as $key=>$value)
    {
        if($i===0)
        {
        $sql=$sql . " $key=?";
        }
        else{
            $sql=$sql . ", $key=?";
        }
        $i++;
    }  

    // dd($sql);
    $sql=$sql . " WHERE id=?";
    // data['id'] is used to dynamically add id to $data=[]
    $data['id']=$id;
    $stmt=executeQuery($sql,$data);
    // affected_rows will return a negetive value should the query fail
    return $stmt->affected_rows;
}

// delete functionality
function delete($table,$id)
{
    global $conn;
    $sql="DELETE from $table WHERE id=?";
    // The reason why id is passed as an assosciative array is because executeQuery() accepts only assosciative array input.
    $stmt=executeQuery($sql,['id'=>$id]);
    // affected_rows will return a negetive value should the query fail
    return $stmt->affected_rows;
}

// Function to fetch username from user_id and show them in index.php slider and recent posts under authors
function getPublishedPosts()
{
    global $conn;
    $sql="SELECT p.*,u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=?";
    $stmt=executeQuery($sql,['published'=>1]);
     $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}
// function to get posts related to topics
function getPostsByTopicId()
{
    global $conn;
    $sql="SELECT p.*,u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND topic_id=?";
    $stmt=executeQuery($sql,['published'=>1,'topic_id'=>$topic_id]);
     $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}


// Search functionality
function searchPosts($term)
{
    $match='%' . $term . '%';
    global $conn;
    $sql="SELECT p.*,u.username FROM posts AS p JOIN users AS u ON p.user_id=u.id WHERE p.published=? AND p.title LIKE ? OR p.body LIKE ?";
    $stmt=executeQuery($sql,['published'=>1,'title'=>$match,'body'=>$match]);
     $records=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $records;
}




// Adding sample conditions
    // $conditions=[
    //     'admin'=>0,
    //     'username'=>'Thomas'
    // ];

// Create function test driver
// $data=[
//          'admin'=>0,
//          'username'=>'Rohan',
//          'email'=>'rohantgeorge05@gmail.com',
//          'password'=>'melvine'
//      ];
// 
    //  $data=[
    //     'admin'=>0,
    //     'username'=>'RohanT',
    //     'email'=>'rohantgeorge05@gmail.com',
    //     'password'=>'melvine'
    // ];
// DRIVER CODES FOR CRUD OPERATION
// $users=selectAll('users',$conditions);
// echo "<pre>", print_r($users),"</pre>";
// $users=selectOne('users',$conditions);
// $users=create('users',$data);
// dd($users);
// $id=create('users',$data);
// $id=update('users',2,$data);
// dd($id);
// $id=delete('users',2);
// dd($id);