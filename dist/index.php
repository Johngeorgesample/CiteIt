<!DOCTYPE html>
<!--[if lte IE 6]><html class="preIE7 preIE8 preIE9"><![endif]-->
<!--[if IE 7]><html class="preIE8 preIE9"><![endif]-->
<!--[if IE 8]><html class="preIE9"><![endif]-->
<!--[if gte IE 9]><!--><html><!--<![endif]-->
  <head>
    <meta charset="UTF-8">
    <meta name="author" content="John-George Sample">
    <meta name="description" content="A web app that allows users to easily create citations using popular citation styles including MLA, APA, and Chicago.">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>CiteIt!</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css"> 
    <link href="https://fonts.googleapis.com/css?family=Zilla+Slab" rel="stylesheet">
  </head>
  <body>
    <div id="squareOne">
      <h1 class="title">Cite It</h1>
      <form action="#squareTwo" method="post">
        <div class="radio-toolbar">
         <input type="radio" id="radio1" name="citationStyle" value="MLA" checked>
         <label for="radio1">MLA</label>

         <input type="radio" id="radio2" name="citationStyle" value="APA">
         <label for="radio2">APA</label>

         <input type="radio" id="radio3" name="citationStyle" value="Chicago">
         <label for="radio3">Chicago</label>
        </div>

         <div class="searchBox">
           <input type="text" class="myBox" name="myUrl" placeholder="enter url to cite">
           <input type="submit" value="Cite">
         </div>
      </form>
    </div>

   

    <div id="squareTwo">
     <?php
      if(isset($_POST['myUrl']) && !empty($_POST['myUrl'])) {
        //session_start(); 
            include('simple_html_dom.php');
            $html = new simple_html_dom();
            $html->load_file($_POST["myUrl"]); 
            $citationStyle =  $_POST["citationStyle"];
            $URL = $_POST["myUrl"];

            $authorIsNull = true;
            $websiteTitleIsNull = true;
            $articleTitleIsNull = true;
            $publisherIsNull = true;
            $publishedDateIsNull = true;

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

            if($property_ogTitle != null) {
              $articleTitleIsNull = false;
              $articleTitle = $property_ogTitle;
            }
            elseif($meta_title != null) {
              $articleTitleIsNull = false;
              $articleTitle = $meta_title;
            }


           //convert article:published_time to d M Y
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

            $full_publish_date = $publish_date_month . " " . $publish_date_day . " " . $publish_date_year;


          echo "<div class='container'><br>
            <h3>What we got</h3>";

             
              if($name_author != null) {
                $authorIsNull = false;
                $author = $name_author;
                echo "<p><b>author</b>: <span id='author'>" . $name_author . "</span></p>";
              }
              elseif ($name_Author != null) {
                $authorIsNull = false;
                $author = $name_Author;
                echo "<p><b>author</b>: <span id='author'>" . $name_Author . "</span></p>";
              }
              elseif ($property_author != null) {
                $authorIsNull = false;
                $author = $property_author;
                echo "<p><b>author</b>: <span id='author'>" . $property_author . "</span></p>";
              }
              elseif ($property_articleAuthor != null) {
                $authorIsNull = false;
                $author = $property_articleAuthor;
                echo "<p><b>author</b>: <span id='author'>" . $property_articleAuthor . "</span></p>";
              }
              elseif ($name_sailthru_author != null) {
                $authorIsNull = false;
                $author = $name_sailthru_author;
                echo "<p><b>author</b>: <span id='author'>" . $name_sailthru_author . "</span></p>";
              }
            

             //author styling. lastName, firstName
              $str = $author;
              $str_explode = (explode(" ", $str));
              $author_last_name = $str_explode[1];
              $author_first_name = $str_explode[0];

              $author_first_name_first_letter = $author_first_name[0]; 
            

            echo "<p><b>url</b>: <span id='URL'>" . $_POST['myUrl'] . "</span></p>";
             if($websiteTitle != null) {echo "<p><b>website title</b>: <span id='websiteTitle'>" . $websiteTitle . "</span></p>";} 
             if($articleTitle != null) {echo "<p><b>article title</b>: <span id='articleTitle'>" . $articleTitle . "</span></p>";} 
             if($publisher != null) {echo "<p><b>publisher</b>: <span id='publisher'>" . $publisher . "</span></p>";} 
             if($publishedTime != null) {echo "<p><b>electronically published</b>: <span id='full_publish_date'>" . $full_publish_date . "</span></p>";} 
             if($accessed_date != null) {echo "<p><b>Date Accessed</b>: <span id='accessed_date'>" . $accessed_date . "</span></p>";} 
           

            
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
            


            echo "<form action='results.php' method='post'>";
              
              if( $authorIsNull == true || $websiteTitleIsNull == true || $articleTitleIsNull == true || $publisherIsNull == true || $publishedDateIsNull == true) {

                  echo "<hr>";
                  echo "<h3>What we still need:</h3>"; //only display if value is missing
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
                  echo '<p><b>published Date: </b><input type="text" id="datepicker" placeholder="click to select date" name="datepickerDate"></p>';
                }
            
      }
     ?>
     <input type="submit" value="Cite">
  </form>
</div>
    </div>

    <div id="squareThree">
     
    </div>


 
  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script>
    $( function() {
        $( "#datepicker" ).datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "mm-dd-yy"
        });
      } );
  </script> 
  <script>
      $(function () {
          $('a[href*=#]:not([href=#])').click(function () {
              if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {

                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                  if (target.length) {
                      $('html,body').animate({
                          scrollTop: target.offset().top
                      }, 1000);
                      return false;
                  }
              }
          });
      });
  </script>
  </body>
</html>