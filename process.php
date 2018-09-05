<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <meta name="google-signin-client_id" content="621886397966-ojhk22pb1l2q4alnnusrd45ed7003cgo.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/platform.js" async defer>
  gapi.load('auth2', function(){gapi.auth2.init();});
  </script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <style media="screen">
  .is-visible{
    background-color: #fdf8d6 !important;
  }
    .is-visiblea{
    background-color: #ffeeee !important;
  }
  .is-hidden{
    color: #ccc;
    background-color: #f9f9f9 !important;
  }
  .is-visible-btn{
    background-color: #fffdf2 !important;
  }
  hr{
    border-top: 1px solid #9c9c98 !important;
    width: 90%;
  }
  @import url('http://fonts.googleapis.com/earlyaccess/nanumgothic.css');
  html, body, h1, h2, h3, h4, h5, h6, li, p {font-family:'Nanum Gothic';}
</style>
  <title>로스쿨 모의 지원</title>
</head>
<body>

  <div class="" align="center">
    <br><br>
    <a href="http://www.megals.co.kr/prof/prof_main.asp?bCode=kalitsma&sub_cd=26#tab1" target="_blank">
      <img src="./banner_2.png" alt="황변과 함께하는 법학적 사고력" style="width: 600px;">
    </a>


  </div><br>


  <?php
  require_once 'lib.php';
  //error_reporting(0);
      error_reporting(E_ALL);
      ini_set("display_errors",1);
  $start_time = array_sum(explode(' ', microtime()));


  $leetApure = $_POST['leetApure'];
  $leetBpure = $_POST['leetBpure'];
  $leetAscore = $_POST['leetAscore'];
  $leetAPscore = $_POST['leetAPscore'];
  $leetBscore = $_POST['leetBscore'];
  $leetBPscore = $_POST['leetBPscore'];
  $schoolScoreType = $_POST['radio'];
  $schoolScore = round($_POST['schoolScore'],2);
  $engScoreType = $_POST['radioEng'];
  $engScore = $_POST['engScore'];
  $scoreArray = [$leetAscore,$leetAPscore, $leetBscore,$leetBPscore, $schoolScoreType, $schoolScore,$engScoreType, $engScore, $leetApure, $leetBpure];

  $sql = "insert into log (   leeta  ,leetap  ,leetb  ,leetbp  ,gpa  ,gpatype  ,eng  ,engtype) VALUES (
   {$leetAscore}, {$leetAPscore}, {$leetBscore}, {$leetBPscore}, {$schoolScore}, {$schoolScoreType}, {$engScore}, \"{$engScoreType}\");";
   $result = mysqli_query($conn,$sql);

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


  <div style="text-align: center;" >
      <br><br><br>
      <a href="http://www.megals.co.kr/prof/prof_main.asp?bCode=kalitsma&sub_cd=26#tab1" target="_blank">
        <img src="./quot_2.png" alt="황변과 함께하는 법학적 사고력" style="width: 700px;">
      </a>

      <div id="chart_div" style="width: 800px; height: 500px; margin-left:auto; margin-right: auto;"></div>
      <br><br><br>

      <a href="http://www.megals.co.kr/prof/prof_main.asp?bCode=kalitsma&sub_cd=26#tab1" target="_blank">
        <img src="./banner_1.png" alt="황변과 함께하는 법학적 사고력" style="width: 850px;">
      </a>

  </div>


  <div class="container">

    <div class="jumbotron" style="background : white;">
      <div tyle="text-align: center;" style="font-weight: bold;" >

         <!--* 아래의 계산된 환산점수는 2018학년도 합격자와의 비교를 위해 2018학년도 입시요강을 사용하고 있습니다. <br>-->
         * 정성요소와 함께 합격자가 선정되기에 이 통계자료가 합격의 절대적인 기준이 될 수 없음을 알려드립니다. <br>
         <!--* 평균변환점수는 각 학교에서 발표한 2018학년 신입생 선발결과 자료 중 평균값을 기준으로 계산한 값입니다.<br><br>-->
         <!--* 단계별 학교선택 가이드 1단계 자료와 2019학년도 입시요강 및 정성요소를 고려하시어 최적의 학교를 찾아내시기 바랍니다.<br><br>-->

      </div>
      <div class="panel panel-default">

        <!-- Default panel contents -->


        <?php
        for($i = 1; $i<=count($school); $i++){

          $convertedLeet = round($school[$i-1]->convertedScore[0],2);
          $convertedGpa = round($school[$i-1]->convertedScore[1],2);
          $convertedEng = $school[$i-1]->convertedScore[2];

          $resultRate = get_table_etc("applicationrates", $i);
          $rowRate = mysqli_fetch_assoc($resultRate);
          $resultAvg = get_table_etc("avg2018table", $i);
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
                <th width=\"18%\">학교</th>
                <th width=\"18%\">구분</th>
                <th width=\"16%\">리트</th>
                <th width=\"16%\">학점</th>
                <th width=\"16%\">영어</th>
                <th width=\"16%\">합계</th>
              </tr>

            </thead><tbody><tr>
            <td rowspan=\"4\"  width=\"18%\"><br>{$school[$i-1]->schoolName} </td>

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
                echo "</td>";
                 echo "<td width=\"16%\">{$sumValueRate}</td></tr>";
              // echo "<tr>
              //   <td width=\"18%\">평균변환점수</td>
              //   <td width=\"16%\">{$rowAvg['leet']}</td>
              //   <td width=\"16%\">{$rowAvg['gpa']}</td>
              //   <td width=\"16%\">";
              //     if($i == 5){
              //       echo 99.7;
              //     }elseif($rowAvg['eng']== 0){
              //       echo "pass";
              //     }else{
              //       echo $rowAvg['eng'];
              //     }
              //     echo "</td>
              //     <td width=\"16%\">{$sumAvg}</td>
              //   </tr>
              //
              //   <tr>";
              //     $percentleet = round($convertedLeet/$rowAvg['leet'],4)*100;
              //     $percentgpa = round($convertedGpa/$rowAvg['gpa'],4)*100;
              //     $percenteng = round($convertedEng/$rowAvg['eng'],4)*100;
              //     $percentsum = round($sumValue/$sumAvg,4)*100;
              //
              //     echo "<td width=\"18%\">본인 / 평균</td> <td width=\"16%\"";
              //     if($percentleet <= 95){
              //       echo " style= \"color:#ff0000; font-weight:bold;\"";
              //     }elseif($percentleet >= 105){
              //
              //       echo " style= \"color:#0000ff;\"";
              //     }
              //     echo  ">{$percentleet}%</td>
              //     <td width=\"16%\"";
              //
              //     if($percentgpa <= 95){
              //       echo " style= \"color:#ff0000; font-weight:bold;\"";
              //     }elseif($percentgpa >= 105){
              //       echo " style= \"color:#0000ff;\"";
              //     }
              //     echo ">{$percentgpa}%</td>
              //     <td width=\"16%\"";
              //
              //     if($percenteng <= 95){
              //       if($percenteng != 0){
              //         echo " style= \"color:#ff0000; font-weight:bold;\"";
              //         echo ">{$percenteng}%";}else{
              //           echo ">-";
              //         }
              //
              //       }elseif($percenteng >= 105){
              //         echo " style= \"color:#0000ff;\"";
              //         echo ">{$percenteng}%";
              //       }else{
              //         echo ">{$percenteng}%";
              //       }
              //       echo "</td><td width=\"16%\"";
              //
              //       if($percentsum <= 95){
              //         echo " style= \"color:#ff0000; font-weight:bold;\"";
              //       }elseif($percentsum >= 105){
              //         echo " style= \"color:#0000ff;\"";
              //       }
              //       echo ">{$percentsum}%</td>
              //     </tr>
              echo "
                </tbody>
              </table>";
            }
            ?>
          </div>
          <br>
          <a href="index.php" class=" btn btn-default btn-lg" style="float: right;"> 돌아가기 </a>
          <br><br>

    </div>
  </div>
  <?php
  require("./foot.php"); ?>
