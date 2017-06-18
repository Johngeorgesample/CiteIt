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
    $APA_date = $publish_date_year . ", " .  $publish_date_month . " " . $publish_date_day;
    $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;
  }

  else {
    echo "n.d";
  }
?>

<div class="container">
  <div class="final-citation">
    <?php
      if($citationStyle == 'MLA') {
        echo $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . $property_ogSite_name . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date;
      }

      elseif ($citationStyle == 'APA') {
        echo $author_last_name . ", " . $author_first_name_first_letter . ". " . "(" . $APA_date . ") " . $articleTitle . ". " . "Retrieved " . $accessed_date . ", " . "from " . $_POST["myUrl"];
      }
    ?>
  </div>
 </div>