<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <title>로스쿨 모의지원 전체</title>
</head>
<body>
  <?php
  error_reporting(0);
  //    error_reporting(E_ALL);
  //    ini_set("display_errors",1);
  $start_time = array_sum(explode(' ', microtime()));


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
  $scoreArray = [$leetAscore,$leetAPscore, $leetBscore,$leetBPscore, $schoolScoreType, $schoolScore,$engScoreType, $engScore, $leetApure, $leetBpure];

  require_once 'lib.php';
  $school1 = new kwu($scoreArray);
  $school2 = new kku($scoreArray);
  $school3 = new knu($scoreArray);
  $school4 = new khu($scoreArray);
  $school5 = new kru($scoreArray);
  $school6 = new dau($scoreArray);
  $school7 = new bsu($scoreArray);
  $school8 = new sgu($scoreArray);
  $school9 = new snu($scoreArray);
  $school10 = new uos($scoreArray);
  $school11 = new skku($scoreArray);
  $school12 = new aju($scoreArray);
  $school13 = new ysu($scoreArray);
  $school14 = new ynu($scoreArray);
  $school15 = new wgu($scoreArray);
  $school16 = new ehu($scoreArray);
  $school17 = new ihu($scoreArray);
  $school18 = new jnu($scoreArray);
  $school19 = new jbu($scoreArray);
  $school20 = new jju($scoreArray);
  $school21 = new jau($scoreArray);
  $school22 = new cnu($scoreArray);
  $school23 = new cbu($scoreArray);
  $school24 = new hufs($scoreArray);
  $school25 = new hyu($scoreArray);

  $school = [$school1, $school2, $school3, $school4, $school5,
  $school6, $school7, $school8, $school9, $school10, $school11,
  $school12,$school13, $school14, $school15, $school16, $school17,
  $school18, $school19, $school20, $school21, $school22, $school23, $school24, $school25];


  for($i=0; $i<count($school); $i++){
    $school[$i]->get_convertedScores();
  }


  $end_time = array_sum(explode(' ', microtime()));

  //    echo "TIME : ". ( $end_time - $start_time );


  ?>

  <h1 class="heading" style="text-align: center;">로스쿨 모의지원 전체</h1><br>
  <div class="container">
    <div class="jumbotron">
      <div class="panel panel-default">
        <!-- Default panel contents -->


        <?php
        for($i = 1; $i<=count($school); $i++){

          $convertedLeet = round($school[$i-1]->convertedScore[0],2);
          $convertedGpa = round($school[$i-1]->convertedScore[1],2);
          $convertedEng = $school[$i-1]->convertedScore[2];

          $resultRate = get_table_etc("applicationrates", $i);
          $rowRate = mysqli_fetch_assoc($resultRate);
          $resultAvg = get_table_etc("avg2017table", $i);
          $rowAvg = mysqli_fetch_assoc($resultAvg);

          $sumValueRate = $rowRate['leet']+$rowRate['eng']+$rowRate['gpa'];
          $sumValue = $convertedLeet + $convertedEng + $convertedGpa;
          $sumAvg = $rowAvg['leet'] + $rowAvg['gpa'] + $rowAvg['eng'];
          $url = "./index.php?page=2&school={$i}";

          echo "
          <div class=\"panel-heading\"></div>
          <table class=\"table\">
            <thead>
              <tr>
                <th width=\"18%\">추천순위</th>
                <th width=\"18%\">구분</th>
                <th width=\"16%\">리트</th>
                <th width=\"16%\">학점</th>
                <th width=\"16%\">영어</th>
                <th width=\"16%\">합계</th>
              </tr>

            </thead><tbody><tr >
            <td rowspan=\"4\"  width=\"18%\"><br><a href=\"{$url}\">{$school[$i-1]->schoolName}</a>  </td>

              <td width=\"18%\">변환점수</td>
              <td width=\"16%\">{$convertedLeet}</td>
              <td width=\"16%\">{$convertedGpa}</td>
              <td width=\"16%\">{$convertedEng}</td>
              <td width=\"16%\">{$sumValue}</td>
            </tr>
            <tr>
              <td width=\"18%\">최대점수</td>
              <td width=\"16%\">{$rowRate['leet']}</td>
              <td width=\"16%\">{$rowRate['gpa']}</td>
              <td width=\"16%\">";
                if($rowRate['eng']== 0){
                  echo "pass";
                }else{
                  echo $rowRate['eng'];
                }
                echo "</td>
                <td width=\"16%\">{$sumValueRate}</td>
              </tr>
              <tr>
                <td width=\"18%\">평균변환점수</td>
                <td width=\"16%\">{$rowAvg['leet']}</td>
                <td width=\"16%\">{$rowAvg['gpa']}</td>
                <td width=\"16%\">";
                  if($i == 5){
                    echo 99.7;
                  }elseif($rowAvg['eng']== 0){
                    echo "pass";
                  }else{
                    echo $rowAvg['eng'];
                  }
                  echo "</td>
                  <td width=\"16%\">{$sumAvg}</td>
                </tr>

                <tr>";
                  $percentleet = round($convertedLeet/$rowAvg['leet'],4)*100;
                  $percentgpa = round($convertedGpa/$rowAvg['gpa'],4)*100;
                  $percenteng = round($convertedEng/$rowAvg['eng'],4)*100;
                  $percentsum = round($sumValue/$sumAvg,4)*100;

                  echo "<td width=\"18%\">본인 / 평균</td> <td width=\"16%\"";
                  if($percentleet <= 90){
                    echo " style= \"color:#ff0000; font-weight:bold;\"";
                  }elseif($percentleet >= 110){
                    echo " style= \"color:#0000ff;\"";
                  }
                  echo  ">{$percentleet}%</td>
                  <td width=\"16%\"";

                  if($percentgpa <= 90){
                    echo " style= \"color:#ff0000; font-weight:bold;\"";
                  }elseif($percentgpa >= 110){
                    echo " style= \"color:#0000ff;\"";
                  }
                  echo ">{$percentgpa}%</td>
                  <td width=\"16%\"";

                  if($percenteng <= 90){
                    if($percenteng != 0){
                      echo " style= \"color:#ff0000; font-weight:bold;\"";
                      echo ">{$percenteng}%";}else{
                        echo ">-";
                      }

                    }elseif($percenteng >= 110){
                      echo " style= \"color:#0000ff;\"";
                      echo ">{$percenteng}%";
                    }else{
                      echo ">{$percenteng}%";
                    }
                    echo "</td><td width=\"16%\"";

                    if($percentsum <= 90){
                      echo " style= \"color:#ff0000; font-weight:bold;\"";
                    }elseif($percentsum >= 110){
                      echo " style= \"color:#0000ff;\"";
                    }
                    echo ">{$percentsum}%</td>
                  </tr>

                </tbody>
              </table>";
            }
            ?>
          </div>
          <br>
          <a href="index.php" class=" btn btn-default btn-lg" style="float: right;"> 돌아가기 </a>
          <br><br><br><br>

    </div>
  </div>
  <br><br><br>
  <?php
  require("./foot.php"); ?>
