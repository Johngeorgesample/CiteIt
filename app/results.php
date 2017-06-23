<?php session_start(); ?>
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
  $citationStyle = $_SESSION['citationStyle'];
  $author = $_SESSION['author'];
  $author_last_name = $_SESSION['author_last_name'];
  $author_first_name = $_SESSION['author_first_name'];
  $author_first_name_first_letter = $_SESSION['author_first_name_first_letter'];
  $articleTitle = $_SESSION['articleTitle'];
  $publisher = $_SESSION['publisher'];
  $websiteTitle = $_SESSION['websiteTitle'];
  $URL = $_SESSION['URL'];
  $accessed_date = $_SESSION['accessed_date'];

  $publish_date_day = $_SESSION['publish_date_day'];
  $publish_date_year = $_SESSION['publish_date_year']; 
  $publish_date_month = $_SESSION['publish_date_month'];
  $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;

  if($_SESSION['author'] == null) {
    $author = $_POST["author"];

    $str_explode = (explode(" ", $author));
    $author_last_name = $str_explode[1];
    $author_first_name = $str_explode[0];

    $author_first_name_first_letter = $author_first_name[0]; 
  }

  if($_SESSION['articleTitle'] == null) {
    $articleTitle = $_POST["articleTitle"];
  }
  
  if($_SESSION['publisher'] == null) {
    $publisher = $_POST["publisher"];
  }
?>

<?php
  if($publish_date_month == null && $_POST["datepickerDate"] != null) {
    $publish_date_needs_format = $_POST["datepickerDate"];
    $publish_date_array = (explode("-", $publish_date_needs_format));
    $publish_date_day = $publish_date_array[1];
    $publish_date_year = $publish_date_array[2];
    $publish_date_month = $publish_date_array[0];
    
    $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;
  }

  elseif ($publish_date_month == null && $_POST["datepickerDate"] == null){
    $full_publish_date = "n.d";
  }

  $APA_date = $publish_date_year . ", " .  $publish_date_month . " " . $publish_date_day;
?>

<div class="container">
  <div class="final-citation"> <!--TODO: save all citation in memory, allow user to download PDF (alphabetized)-->
    <?php
      if($citationStyle == 'MLA') {

        // if($publish_date_month == 01) { //TODO: fix why this is half broken
        //   $publish_date_month = "Jan";
        // }
        // elseif($publish_date_month == 02) {
        //   $publish_date_month = "Feb";
        // }
        // elseif($publish_date_month == 03) {
        //   $publish_date_month = "Mar";
        // }
        // elseif($publish_date_month == 04) {
        //   $publish_date_month = "Apr";
        // }
        // elseif($publish_date_month == 05) {
        //   $publish_date_month = "May";
        // }
        // elseif($publish_date_month == 06) {
        //   $publish_date_month = "June";
        // }
        // elseif($publish_date_month == 07) {
        //   $publish_date_month = "July";
        // }
        // elseif($publish_date_month == 08) {
        //   $publish_date_month = "Aug";
        // }
        // elseif($publish_date_month == 09) {
        //   $publish_date_month = "Sept";
        // }
        // elseif($publish_date_month == 10) {
        //   $publish_date_month = "Oct";
        // }
        // elseif($publish_date_month == 11) {
        //   $publish_date_month = "Nov";
        // }
        // elseif($publish_date_month == 12) {
        //   $publish_date_month = "Dec";
        // }


        echo $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . $websiteTitle . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date;
      }

      elseif ($citationStyle == 'APA') {
        echo $author_last_name . ", " . $author_first_name_first_letter . ". " . "(" . $APA_date . ") " . $articleTitle . ". " . "Retrieved " . $accessed_date . ", " . "from " . $URL;
      }

      elseif($citationStyle == 'Chicago') {
        echo $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . " " . $full_publish_date . ". " . " " . $accessed_date . "<br>" . $URL;
      }
    ?>
  </div>
 </div>