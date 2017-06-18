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
  $citationStyle = $_SESSION['citationStyle'];
  $author = $_SESSION['author'];
  $author_last_name = $_SESSION['author_last_name'];
  $author_first_name = $_SESSION['author_first_name'];
  $author_first_name_first_letter = $_SESSION['author_first_name_first_letter'];
  $articleTitle = $_SESSION['articleTitle'];
  $publisher = $_SESSION['publisher'];
  //$_SESSION['siteName'] = $siteName; //TODO: make siteName variable
  $accessed_date = $_SESSION['accessed_date'];
  $full_publish_date =  $_POST["datepickerDate"];
?>

<?php
  if($full_publish_date == null) {
    echo "n.d";
  }

  else {
    $publish_date_array = (explode("-", $full_publish_date));
    $publish_date_day = $publish_date_array[1];
    $publish_date_year = $publish_date_array[2];
    $publish_date_month = $publish_date_array[0];
    $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;
  }
?>

  <?php
    if($citationStyle == 'MLA') {
      echo $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . $property_ogSite_name . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date;
    }

    elseif ($citationStyle == 'APA') {
      echo $author_last_name . ", " . $author_first_name_first_letter . ". " . "(" . $full_publish_date . ") " . $articleTitle . ". " . "Retrieved " . $accessed_date . ", " . "from " . $_POST["myUrl"];
    }
  ?>