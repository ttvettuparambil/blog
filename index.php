<?php 
include('path.php');
// include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/controllers/topics.php");
$posts=array();
$postsTitle='Recent Posts';
// $posts=selectAll('posts',['published'=>1]);
if(isset($_POST['search-term']))
{
  $postsTitle="You searched for " . $_POST['search-term'];
  // dd($_POST);
  $posts=searchPosts($_POST['search-term']);

}
else{
  $posts=getPublishedPosts();
}

// $posts=getPublishedPosts();
// dd($posts);
// Checking if search term exists

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">

  <title>Blog</title>
</head>

<body>
<!-- Menu bar code to be called from app/includes/header.php -->
  <?php 
  // include("app/includes/header.php"); 
  include(ROOT_PATH . "/app/includes/header.php");
  include(ROOT_PATH . "/app/includes/messages.php");
  ?>
<!-- Menu bar code ends here -->

  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Post Slider -->
    <div class="post-slider">
      <h1 class="slider-title">Trending Posts</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>

      <div class="post-wrapper">
      <?php foreach($posts as $post):?>
        <div class="post">
          <img src="<?php echo BASE_URL . '/assets/images/' . $post['image'];?>" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.php?id=<?php echo $post['id'];?>"><?php echo $post['title']?></a></h4>
            <i class="far fa-user"> <?php echo $post['username'];?></i>
            &nbsp;
            <i class="far fa-calendar"> <?php echo date('F j, Y',strtotime($post['created_at']));?></i>
          </div>
        </div>
      <?php endforeach;?>
     
                   
        <!-- <div class="post">
          <img src="assets/images/image_1.png" alt="" class="slider-image">
          <div class="post-info">
            <h4><a href="single.php">One day your life will flash before your eyes</a></h4>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 8, 2019</i>
          </div>
        </div> -->


      </div>

    </div>
    <!-- // Post Slider -->

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content -->
      <div class="main-content">
        <h1 class="recent-post-title"><?php echo $postsTitle?></h1>
        <!-- looping through posts -->
        <?php foreach($posts as $post):?>
          <div class="post clearfix">
          <img src="<?php echo BASE_URL . '/assets/images/' . $post['image'];?>" alt="" class="post-image">
          <div class="post-preview">
            <h2><a href="single.php?id=<?php echo $post['id'];?>"><?php echo $post['title']?></a></h2>
            <i class="far fa-user"><?php echo $post['username'];?></i>
            &nbsp;
            <i class="far fa-calendar"> <?php echo date('F j, Y',strtotime($post['created_at']));?></i>
            <p class="preview-text">
              <?php echo html_entity_decode(substr($post['body'],0,50) . '...');?>
            </p>
            <a href="single.php?id=<?php echo $post['id'];?>" class="btn read-more">Read More</a>
          </div>
        </div>
        <?php endforeach;?>
        

      
        <!-- <div class="post clearfix">
          <img src="assets/images/image_3.png" alt="" class="post-image">
          <div class="post-preview">
            <h2><a href="single.php">The strongest and sweetest songs yet remain to be sung</a></h2>
            <i class="far fa-user"> Awa Melvine</i>
            &nbsp;
            <i class="far fa-calendar"> Mar 11, 2019</i>
            <p class="preview-text">
              Lorem ipsum dolor sit amet consectetur, adipisicing elit.
              Exercitationem optio possimus a inventore maxime laborum.
            </p>
            <a href="single.php" class="btn read-more">Read More</a>
          </div>
        </div> -->

      </div>
      <!-- // Main Content -->

      <div class="sidebar">

        <div class="section search">
          <h2 class="section-title">Search</h2>
          <form action="index.php" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Search...">
          </form>
        </div>


        <div class="section topics">
          <h2 class="section-title">Topics</h2>
          <ul>
          <?php foreach($topics as $key=>$topic): ?>
            <!-- <li><a href="#"><?php echo $topic['name'];?></a></li> -->
            <li><a href="<?php echo BASE_URL . '/index.php?t_id=' .$topic['id'];?>"><?php echo $topic['name'];?></a></li>
          <?php endforeach ?>
            
            <!-- <li><a href="#">Quotes</a></li>
            <li><a href="#">Fiction</a></li>
            <li><a href="#">Biography</a></li>
            <li><a href="#">Motivation</a></li>
            <li><a href="#">Inspiration</a></li>
            <li><a href="#">Life Lessons</a></li> -->
          </ul>
        </div>

      </div>

    </div>
    <!-- // Content -->

  </div>
  <!-- // Page Wrapper -->

  <!-- footer -->
  <?php include("app/includes/footer.php"); ?>
  <!-- // footer -->


  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Slick Carousel -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>

</body>

</html>