<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CiteIt!</title>
  <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>
  <div class="titleBar">
    <h1><a href="http://localhost:8888/">CiteIt!</a></h1>
  </div>
  <nav>
    <ul>
      <li ng-click=""><a href="#">Web</a></li>
      <li ng-click=""><a href="#">Book</a></li>
      <li ng-click=""><a href="#">Tweet</a></li>
    </ul>
  </nav>

<?php
  include('simple_html_dom.php');
  $html = new simple_html_dom();
  $html->load_file($_POST["myUrl"]); 

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
  if ($property_ogSite_name != null) {
    $publisherIsNull = false;
    $websiteTitleIsNull = false;
  }
  
  //Dates
  $accessed_date = date('d M Y');

  $property_pubishedTime = $html->find("meta[property='article:published_time']", 0)->content;
  $property_ogPubishedTime = $html->find("meta[property='og:article:published_time']", 0)->content;
  $name_DisplayDate = $html->find("meta[name='DisplayDate']", 0)->content;

  $time_date = $html->find('time',0)->innertext;
  
  //author 
  //TODO: add logic to handle multiple authors
  $name_author = $html->find("meta[name='author']", 0)->content;
  $name_Author = $html->find("meta[name='Author']", 0)->content; //WIRED is a prime example of this. Capitalizing letter is a totally new tag
  $property_author = $html->find("meta[property='author']", 0)->content;
  $property_articleAuthor = $html->find("meta[property='article:author']", 0)->content;
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

  /*
    --MLA & Chicago--
    Jan.
    Feb.
    Mar.
    Apr.
    May
    June
    July
    Aug.
    Sept.
    Oct.
    Nov.
    Dec

    --AP--
    Jan.
    Feb.
    March
    April
    May
    June
    July
    Aug.
    Sept.
    Oct.
    Nov.
    Dec.
  */
?>

<div class="container">
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
  ?>

  <p><b>url</b>: <?php echo $_POST["myUrl"] ?></p>
  <p><b>website title</b>: <?php echo $property_ogSite_name?></p> <!--if null, use article title-->
  <p><b>article title</b>: <?php echo $articleTitle?></p>
  <p><b>publisher</b>: <?php echo $publisher?></p> <!-- might be same as website_title -->
  <p><b>electronically published</b>: <?php echo $full_publish_date?></p>
  <p><b>Date Accessed</b>: <?php echo $accessed_date?> </p>

  <?php
  if( $authorIsNull == true || $websiteTitleIsNull == true || $articleTitleIsNull == true || $publisherIsNull == true || $publishedDateIsNull == true) {

      echo "<p>--------------------------------------------</p>";
      echo "<h3>What we still need:</h3>";

  }
    if($authorIsNull == true) {
      echo "<p><b>author</b></p>:";
      echo '<form><input type=\"text\" placeholder="Mark Twain"></form>';
    }
    if($websiteTitleIsNull == true) {
      echo "<p><b>website title</b></p>";
      echo '<form><input type=\"text\" placeholder="The Verge"></form>';
    }
    if($articleTitleIsNull == true) {
      echo "<p><b>article title</b></p>";
      echo '<form><input type=\"text\" placeholder="iPhone 12+S hands on"></form>';
    }
    if($publisherIsNull == true) {
      echo "<p><b>publisher</b></p>";
      echo '<form><input type=\"text\" placeholder="New York Times"></form>';
    }
    if($publishedDateIsNull == true) {
      echo "<p><b>published date</b></p>";
      echo '<form><input type=\"text\" placeholder="06-12-2017"></form>';
    }
  ?>

  <p>--------------------------------------------</p>

  <p>author. "Article Title". <i>Publisher</i>. Website name, date published. Type. date accessed</p>
  <p><?php echo $author_last_name . ", " . $author_first_name . ". \"" . $property_ogTitle . "\". " . "<i>" . $publisher . "</i>. " . $property_ogSite_name . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date ?></p>

</div>

</body>
</html>