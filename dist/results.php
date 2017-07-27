<?php session_start(); ?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CiteIt!</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/main.css" type="text/css">

</head>
<body>
  <div class="titleBar">
    <h1><a href="http://localhost:8888/">CiteIt!</a></h1>
  </div>
  
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

  if($_SESSION['websiteTitle'] == null) {
    $websiteTitle = $_POST["websiteTitle"];
  }

  if($publish_date_month == null && $_POST["datepickerDate"] != null) {
    $publish_date_needs_format = $_POST["datepickerDate"];
    $publish_date_array = (explode("-", $publish_date_needs_format));
    $publish_date_day = $publish_date_array[1];
    $publish_date_year = $publish_date_array[2];
    $publish_date_month = $publish_date_array[0];
    
    $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;
  }

  elseif ($publish_date_month == null && $_POST["datepickerDate"] == null) {
    $full_publish_date = "n.d";
  }

  $APA_date = $publish_date_year . ", " .  $publish_date_month . " " . $publish_date_day;
?>

<div class="container">
  <div class="final-citation">
    <?php
      if($citationStyle == 'MLA') {
        switch ($publish_date_month) {
            case "01":
                $publish_date_month = "Jan.";
                break;
            case "02":
                $publish_date_month = "Feb.";
                break;
            case "03":
                $publish_date_month = "Mar.";
                break;
            case "04":
                $publish_date_month = "Apr.";
                break;
            case "05":
                $publish_date_month = "May";
                break;
            case "06":
                $publish_date_month = "June";
                break;
            case "07":
                $publish_date_month = "July";
                break;
            case "08":
                $publish_date_month = "Aug.";
                break;
            case "09":
                $publish_date_month = "Sept.";
                break;
            case "10":
                $publish_date_month = "Oct.";
                break;
            case "11":
                $publish_date_month = "Nov.";
                break;
            case "12":
                $publish_date_month = "Dec.";
                break;
        }

        $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;

        echo "<p id='finalCitationBox'>" . $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . $websiteTitle . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date . ".</p>";
      }

      elseif ($citationStyle == 'APA') {
        switch ($publish_date_month) {
            case "01":
                $publish_date_month = "Jan.";
                break;
            case "02":
                $publish_date_month = "Feb.";
                break;
            case "03":
                $publish_date_month = "Mar.";
                break;
            case "04":
                $publish_date_month = "Apr.";
                break;
            case "05":
                $publish_date_month = "May";
                break;
            case "06":
                $publish_date_month = "June";
                break;
            case "07":
                $publish_date_month = "July";
                break;
            case "08":
                $publish_date_month = "Aug.";
                break;
            case "09":
                $publish_date_month = "Sept.";
                break;
            case "10":
                $publish_date_month = "Oct.";
                break;
            case "11":
                $publish_date_month = "Nov.";
                break;
            case "12":
                $publish_date_month = "Dec.";
                break;
        }
        $APA_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;

        echo "<p id='finalCitationBox'>" . $author_last_name . ", " . $author_first_name_first_letter . ". " . "(" . $APA_date . ") " . $articleTitle . ". " . "Retrieved " . $accessed_date . ", " . "from " . $URL . "</p>";
      }

      elseif($citationStyle == 'Chicago') {
        switch ($publish_date_month) {
            case "01":
                $publish_date_month = "Jan.";
                break;
            case "02":
                $publish_date_month = "Feb.";
                break;
            case "03":
                $publish_date_month = "Mar.";
                break;
            case "04":
                $publish_date_month = "Apr.";
                break;
            case "05":
                $publish_date_month = "May";
                break;
            case "06":
                $publish_date_month = "June";
                break;
            case "07":
                $publish_date_month = "July";
                break;
            case "08":
                $publish_date_month = "Aug.";
                break;
            case "09":
                $publish_date_month = "Sept.";
                break;
            case "10":
                $publish_date_month = "Oct.";
                break;
            case "11":
                $publish_date_month = "Nov.";
                break;
            case "12":
                $publish_date_month = "Dec.";
                break;
        }
        $full_publish_date = $publish_date_day . " " . $publish_date_month . " " . $publish_date_year;
        echo "<p id='finalCitationBox'>" . $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . " " . $full_publish_date . ". " . " " . $accessed_date . "<br>" . $URL . "</p>";
      }
    ?>
    <!--  <h1 style="color:black" onclick="populateStorage()">click</h1> -->
    <hr>
    <h2>Older Citations</h2>
     <div id="DivToPrintOut"></div>
  </div>
 </div>

<h1 style="color: black" onclick="clearS()">click to clear storage</h1>
<h1 style="color: black" onclick="generatePDF()">click to generatePDF</h1>
<h1 style="color: black" onclick="generateBetterPDF()">click to generateBetterPDF</h1>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="js/script.js"></script>
<script src="js/pdfmake.min.js"></script>
<script src="js/vfs_fonts.js"></script>

</body>
</html>