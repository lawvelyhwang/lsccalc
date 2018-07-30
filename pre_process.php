<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=euc-kr">
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title></title>
  </head>
  <body>
    <div align ="center">
      <br><br>
      <img src="./popup.png" alt="" style="width: 550px;">
<br><br>

    <form class="" action="process.php" method="post" name="score">
    <?php

      $leetApure = $_POST['leetApure'];
      $leetBpure = $_POST['leetBpure'];
      $leetAscore = $_POST['leetAscore'];
      $leetAPscore = $_POST['leetAPscore'];
      $leetBscore = $_POST['leetBscore'];
      $leetBPscore = $_POST['leetBPscore'];
      $schoolScoreType = $_POST['radio'];
      $schoolScore = $_POST['schoolScore'];
      $engScoreType = $_POST['radioEng'];
      $engScore = $_POST['engScore'];

      echo "<input type=\"hidden\", name=\"leetApure\", value={$leetApure}>";
      echo "<input type=\"hidden\", name=\"leetBpure\", value={$leetBpure}>";
      echo "<input type=\"hidden\", name=\"leetAscore\", value={$leetAscore}>";
      echo "<input type=\"hidden\", name=\"leetAPscore\", value={$leetAPscore}>";
      echo "<input type=\"hidden\", name=\"leetBscore\", value={$leetBscore}>";
      echo "<input type=\"hidden\", name=\"leetBPscore\", value={$leetBPscore}>";
      echo "<input type=\"hidden\", name=\"radio\", value={$schoolScoreType}>";
      echo "<input type=\"hidden\", name=\"schoolScore\", value={$schoolScore}>";
      echo "<input type=\"hidden\", name=\"radioEng\", value={$engScoreType}>";
      echo "<input type=\"hidden\", name=\"engScore\", value={$engScore}>";

      echo "<input type=\"submit\", class=\"btn btn-default btn-lg\" value=\"결과 확인\">";


     ?>


  </form>
  </div>
<br><br>

  </body>
</html>
