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
  echo $_SESSION['author'];
?>