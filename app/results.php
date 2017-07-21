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

        echo "<span id='finalCitationBox'>" . $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . $websiteTitle . ", " . $full_publish_date . ". " . "Web." . " " . $accessed_date . "</span>";
      }

      elseif ($citationStyle == 'APA') {
        echo "<span id='finalCitationBox'>" . $author_last_name . ", " . $author_first_name_first_letter . ". " . "(" . $APA_date . ") " . $articleTitle . ". " . "Retrieved " . $accessed_date . ", " . "from " . $URL . "</span>";
      }

      elseif($citationStyle == 'Chicago') {
        echo "<span id='finalCitationBox'>" . $author_last_name . ", " . $author_first_name . ". \"" . $articleTitle . "\". " . "<i>" . $publisher . "</i>. " . " " . $full_publish_date . ". " . " " . $accessed_date . "<br>" . $URL . "</span>";
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

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="js/script.js"></script>
	

<script>
  var output = ''; 
  localStorage.setItem(document.getElementById('finalCitationBox').innerHTML, document.getElementById('finalCitationBox').innerHTML);


  for (var i in localStorage) {
  	//if(localStorage[i] != document.getElementById('finalCitationBox').innerHTML) {
      console.log(localStorage[i]); //for debugging
    //}
  }

  var j = 0;
  for (var i in localStorage) { //don't add newly created citation to "older citations"
  	if(localStorage[i] != document.getElementById('finalCitationBox').innerHTML) {
      output+= '<p onclick="removeFromlocalStorage(this.id);hideCitation()" id="'+j+'">' + (localStorage[i])+'</p>';
      j++;
    }
  }

  $('#DivToPrintOut').html(output);

  function clearS() {
  	localStorage.clear();
  }
  
  function removeFromlocalStorage(citation) {
    for (var i in localStorage) {
      if(localStorage[i] === document.getElementById(citation).innerHTML) {
        console.log("removing " + localStorage[i]);
        localStorage.removeItem(document.getElementById(citation).innerHTML);
      }
    }
  }

  function hideCitation() {
    //$( "p" ).remove();
  }
</script>