<?php
  session_start();
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CiteIt!</title>
  <link rel="stylesheet" href="css/main.css" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
  <div class="titleBar">
    <h1><a href="http://localhost:8888/">CiteIt!</a></h1>
  </div>
  <nav>
    <ul class="nav-ul">
      <li class="nav-li" ng-click=""><a href="#">Web</a></li>
      <li class="nav-li" ng-click=""><a href="#">Book</a></li>
      <li class="nav-li" ng-click=""><a href="#">Tweet</a></li>
    </ul>
  </nav>

<?php
  include('simple_html_dom.php');
  $html = new simple_html_dom();
  $html->load_file($_POST["myUrl"]); 
  $citationStyle =  $_POST["citationStyle"];

  $URL = $_POST["myUrl"];

  // echo $citationStyle;

  $authorIsNull = true;
  $websiteTitleIsNull = true;
  $articleTitleIsNull = true;
  $publisherIsNull = true;
  $publishedDateIsNull = true;
  //$accessedDateIsNull = true;

  //website title
  $property_ogSite_name = $html->find("meta[property='og:site_name']", 0)->content;

  //article title
  $meta_title = $html->find('title',0)->innertext;
  $property_ogTitle = $html->find("meta[property='og:title']", 0)->content;

  //publisher
  $publisher = $property_ogSite_name;
  $websiteTitle = $property_ogSite_name;
  if ($property_ogSite_name != null) {
    $publisherIsNull = false;
    $websiteTitleIsNull = false;
  }
  
  //Dates
  $accessed_date = date('d F Y');

  $property_pubishedTime = $html->find("meta[property='article:published_time']", 0)->content;
  $property_ogPubishedTime = $html->find("meta[property='og:article:published_time']", 0)->content;
  $property_articlePublished = $html->find("meta[property='article:published']", 0)->content;
  $name_DisplayDate = $html->find("meta[name='DisplayDate']", 0)->content;

  $time_date = $html->find('time',0)->innertext;
  
  //author 
  //TODO: add logic to handle multiple authors
  $name_author = $html->find("meta[name='author']", 0)->content;
  $name_Author = $html->find("meta[name='Author']", 0)->content; //WIRED is a prime example of this. Capitalizing letter is a totally new tag
  $property_author = $html->find("meta[property='author']", 0)->content;
  $property_articleAuthor = $html->find("meta[property='article:author']", 0)->content; //TODO: fix this, it's not working
  $name_sailthru_author = $html->find("meta[name='sailthru.author']", 0)->content;

 
?>

<?php 
  if($property_ogTitle != null) {
    $articleTitleIsNull = false;
    $articleTitle = $property_ogTitle;
  }
  elseif($meta_title != null) {
    $articleTitleIsNull = false;
    $articleTitle = $meta_title;
  }
?>

<?php //convert article:published_time to d M Y
  if($property_pubishedTime != null) {
    $publishedDateIsNull = false;
    $publishedTime = $property_pubishedTime;
  }
  elseif($property_ogPubishedTime != null) {
    $publishedDateIsNull = false;
    $publishedTime = $property_ogPubishedTime;
  }
  elseif($property_articlePublished != null) {
    $publishedDateIsNull = false;
    $publishedTime = $property_articlePublished;
  }

  $t_delimited_publish_date = (explode("T", $publishedTime));
  $hyphen_delimited_publish_date = $t_delimited_publish_date[0];
  $publish_date_array = (explode("-", $hyphen_delimited_publish_date));

  $publish_date_day = $publish_date_array[2];
  $publish_date_year = $publish_date_array[0];
  $publish_date_month = $publish_date_array[1];

  if($publish_date_month == 05) { //ghetto way to do months. Will be dependent on citation style
    $publish_date_month = "May";
  }
  elseif($publish_date_month == 06) {
    $publish_date_month = "June";
  }

  $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;
?>

<div class="container">
  <h3>What we got</h3>

  <?php 
    if($name_author != null) {
      $authorIsNull = false;
      $author = $name_author;
      echo "<p><b>author</b>: " . $name_author . "</p>";
    }
    elseif ($name_Author != null) {
      $authorIsNull = false;
      $author = $name_Author;
      echo "<p><b>author</b>: " . $name_Author . "</p>";
    }
    elseif ($property_author != null) {
      $authorIsNull = false;
      $author = $property_author;
      echo "<p><b>author</b>: " . $property_author . "</p>";
    }
    elseif ($property_articleAuthor != null) {
      $authorIsNull = false;
      $author = $property_articleAuthor;
      echo "<p><b>author</b>: " . $property_articleAuthor . "</p>";
    }
    elseif ($name_sailthru_author != null) {
      $authorIsNull = false;
      $author = $name_sailthru_author;
      echo "<p><b>author</b>: " . $name_sailthru_author . "</p>";
    }
  ?>

  <?php //author styling. lastName, firstName
    $str = $author;
    $str_explode = (explode(" ", $str));
    $author_last_name = $str_explode[1];
    $author_first_name = $str_explode[0];

    $author_first_name_first_letter = $author_first_name[0]; 
  ?>

  <!-- TODO: stop displaying things that are null -->
  <p><b>url</b>: <?php echo $_POST["myUrl"] ?></p>
  <p><b>website title</b>: <?php echo $websiteTitle?></p> <!--if null, use article title-->
  <p><b>article title</b>: <?php echo $articleTitle?></p>
  <p><b>publisher</b>: <?php echo $publisher?></p> <!-- might be same as website_title -->
  <p><b>electronically published</b>: <?php echo $full_publish_date?></p>
  <p><b>Date Accessed</b>: <?php echo $accessed_date?> </p>

  <?php
    $_SESSION['citationStyle'] = $citationStyle;
    $_SESSION['author'] = $author;
    $_SESSION['author_last_name'] = $author_last_name;
    $_SESSION['author_first_name'] = $author_first_name;
    $_SESSION['author_first_name_first_letter'] = $author_first_name_first_letter;
    $_SESSION['articleTitle'] = $articleTitle;
    $_SESSION['publisher'] = $publisher;
    $_SESSION['websiteTitle'] = $websiteTitle; //TODO: make siteName variable
    $_SESSION['URL'] = $URL;
    $_SESSION['accessed_date'] = $accessed_date;

    $_SESSION['publish_date_day'] = $publish_date_day;
    $_SESSION['publish_date_year'] = $publish_date_year;
    $_SESSION['publish_date_month'] = $publish_date_month;
  ?>


  <form action="results.php" method="post">
    <?php
    if( $authorIsNull == true || $websiteTitleIsNull == true || $articleTitleIsNull == true || $publisherIsNull == true || $publishedDateIsNull == true) {

        echo "<hr>";
        echo "<h3>What we still need:</h3>";

    }
      if($authorIsNull == true) {
        echo '<p><b>author: </b> <input type="text" placeholder="Mark Twain" name="author"></p>';

      }
      if($websiteTitleIsNull == true) {
        echo '<p><b>website title: </b> <input type="text" placeholder="New York Times" name="websiteTitle"></p>';
      }
      if($articleTitleIsNull == true) {
        echo '<p><b>article title: </b> <input type="text" placeholder="MIT Janitor Brilliant at Mathcore" name="articleTitle"></p>';
      }
      if($publisherIsNull == true) {
        echo '<p><b>publisher: </b> <input type="text" placeholder="New York Times" name="publisher"></p>';
      }
      if($publishedDateIsNull == true) {
        echo '<p><b>published Date: </b><input type="text" id="datepicker" placeholder="click to select date" name="datepickerDate"></p>'; //TODO: style, fix date format to reuse explode method
      }
    ?>
  <input type="submit" value="Cite">
  </form>
</div>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $( function() {
        $( "#datepicker" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "mm-dd-yy"
        });
      } );
  </script>
</body>
</html>