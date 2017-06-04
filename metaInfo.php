<html>
<body>

<?php
  include('simple_html_dom.php');
  $html = new simple_html_dom();
  $html->load_file($_POST["myUrl"]); 

  //website name
  $website_title = $html->find("meta[property='og:site_name']", 0)->content;

  //page title
  $meta_title = $html->find('title',0)->innertext;
  $og_title = $html->find("meta[property='og:title']", 0)->content;

  //publisher
  $publisher = $website_title;
  
  //Dates
  $accessed_date = date('d M Y');
  $published_date = $html->find("meta[property='article:published_time']", 0)->content;
  $display_date = $html->find("meta[name='DisplayDate']", 0)->content;
  $time_date = $html->find('time',0)->innertext; //NPR uses this - ugh
  
  //author - fix for multi-names
  $meta_author = $html->find("meta[name='author']", 0)->content;
  //$meta_Author = $html->find("meta[name='Author']", 0)->content; //WIRED is a prime example of this. Capitalizing letter is a totally new tag
  $meta_property_author = $html->find("meta[property='author']", 0)->content;
  $meta_article_author = $html->find("meta[property='article:author']", 0)->content;
?>

<?php //convert article:published_time to d M Y
  $t_delimited_publish_date = (explode("T", $published_date));
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
<p><b>website title</b>: <?php echo $website_title?></p> <!--if null, use article title-->
<p><b>article title</b>: <?php echo $og_title?></p>
<p><b>publisher</b>: <?php echo $publisher?></p> <!-- might be same as website_title -->
<p><b>electronically published</b>: <?php echo $full_publish_date?></p>
<p><b>Date Accessed</b>: <?php echo $accessed_date?> </p>

<?php 
  if($meta_author == null && $meta_property_author == null) {
    echo "<p>no author</p>"; //ask user to input missing info
  }
  elseif($meta_author == null && meta_property_author != null) {
    echo "<p><b>author</b>: " . $meta_property_author . "</p>";
  }
  elseif ($meta_property_author == null && meta_author != null){
    echo "<p><b>author</b>: " . $meta_author . "</p>";
  }
?>


<?php //author styling. lastName, firstName
  $str = $meta_property_author;
  $str_explode = (explode(" ", $str));
  $author_last_name = $str_explode[1];
  $author_first_name = $str_explode[0];
?>


<p>author. "Article Title". <i>Publisher</i>. Website name, date published. Type. date accessed</p>
<p><?php echo $author_last_name . ", " . $author_first_name . ". \"" . $og_title . "\". " . "<i>" . $publisher . "</i>. " . $website_title . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date ?></p>


<a href="http://localhost:8888/app">click to go back</a>

</body>
</html>