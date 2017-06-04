<html>
<body>

<?php
  include('simple_html_dom.php');
  $html = new simple_html_dom();
  $html->load_file($_POST["myUrl"]); 

  //website title
  $property_ogSite_name = $html->find("meta[property='og:site_name']", 0)->content;

  //article title
  $meta_title = $html->find('title',0)->innertext;
  $property_ogTitle = $html->find("meta[property='og:title']", 0)->content;

  //publisher
  $publisher = $property_ogSite_name;
  
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

<?php //convert article:published_time to d M Y
  $t_delimited_publish_date = (explode("T", $property_pubishedTime));
  $hyphen_delimited_publish_date = $t_delimited_publish_date[0];
  $publish_date_array = (explode("-", $hyphen_delimited_publish_date));

  $publish_date_day = $publish_date_array[2];
  $publish_date_year = $publish_date_array[0];
  $publish_date_month = $publish_date_array[1];

  if($publish_date_month == 05) { //ghetto way to do months. Will be dependent on citation style
    $publish_date_month = "May";
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

<p><b>url</b>: <?php echo $_POST["myUrl"] ?></p>
<p><b>website title</b>: <?php echo $property_ogSite_name?></p> <!--if null, use article title-->
<p><b>article title</b>: <?php echo $property_ogTitle?></p>
<p><b>publisher</b>: <?php echo $publisher?></p> <!-- might be same as website_title -->
<p><b>electronically published</b>: <?php echo $full_publish_date?></p>
<p><b>Date Accessed</b>: <?php echo $accessed_date?> </p>


<?php 
  if($name_author != null) {
    $author = $name_author;
    echo "<p><b>author</b>: " . $name_author . "</p>";
  }
  elseif ($name_Author != null) {
    $author = $name_Author;
    echo "<p><b>author</b>: " . $name_Author . "</p>";
  }
  elseif ($property_author != null) {
    $author = $property_author;
    echo "<p><b>author</b>: " . $property_author . "</p>";
  }
  elseif ($property_articleAuthor != null) {
    $author = $property_articleAuthor;
    echo "<p><b>author</b>: " . $property_articleAuthor . "</p>";
  }
   elseif ($name_sailthru_author != null) {
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


<p>author. "Article Title". <i>Publisher</i>. Website name, date published. Type. date accessed</p>
<p><?php echo $author_last_name . ", " . $author_first_name . ". \"" . $og_title . "\". " . "<i>" . $publisher . "</i>. " . $website_title . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date ?></p>


<a href="http://localhost:8888/">click to go back</a>

</body>
</html>