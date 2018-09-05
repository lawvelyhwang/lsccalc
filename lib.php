
<?php
/*
$resultTableTitle = ['추천순위','구분','리트','학점','영어','논술','면접','서류','합계'];
for($i=0; $i<count($resultTableTitle); $i++){
  echo $resultTableTitle[$i];
}*/
$conn = mysqli_connect("localhost","root","Trust0925");

function set_user($score){
  global $conn;
  mysqli_select_db($conn,"lawschoolproject01");
  $sql = "insert into usertable values(null, null, {$score[0]}, {$score[1]}, {$score[2]}, {$score[3]}, {$score[4]}, {$score[5]}, '{$score[6]}', {$score[7]})";
  $result = mysqli_query($conn,$sql);
}

function get_table_etc($tableName, $value){
  global $conn;
  mysqli_select_db($conn,"lawschoolproject01");
  $sql = "select * from ".$tableName." where `schoolnumber` = ".$value;
  $result = mysqli_query($conn,$sql);
return $result;
}

function get_table($tableName, $valuetype, $value){
  global $conn;
  mysqli_select_db($conn,"lawschoolproject01");
  $sql = "select * from ".$tableName." where `". $valuetype . "` = ".$value;

  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
return $row;
}
function get_table_de($tableName, $valuetype, $value){
  global $conn;
  mysqli_select_db($conn,"lawschoolproject01");
  $sql = "select * from ".$tableName." where `". $valuetype . "` <= ".$value. " order by `{$valuetype}` desc";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
return $row;
}

function recommend($score, $checker){
  global $conn;
  if($score[0] == 0){
  mysqli_select_db($conn,"lawschoolproject01");
  $sql = "select * from leetconverttable2018 where leetPure = '{$score[8]}'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  $score[0] = $row['leetAscore'];

  $sql = "select * from leetconverttable2018 where leetPure = '{$score[9]}'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $score[2] = $row['leetBscore'];
}


  $row = get_table("gpaconverttable", $score[4], $score[5]);

  $sumvalue = ($score[0]+$score[2])*$row['100'];
  if($checker == 2){
  $sql = "select schoolname, {$sumvalue} - recommendscore  as recommendation, schoolnumber  from recommendtable where {$sumvalue} - recommendscore >=0 order by recommendation"; //하향지원
}elseif ($checker == 1) {
  $sql = "select schoolname, {$sumvalue} - recommendscore  as recommendation, schoolnumber  from recommendtable where {$sumvalue} - recommendscore <0 order by recommendation desc"; //상향지원
}
  $result = mysqli_query($conn,$sql);


return $result;
}

class schoolInfo{
   public $schoolName;
   public $schoolId;
   public $convertedScore;
   public $applicationRate;
   public $maxLeetA = 80;
   public $maxLeetB = 75;
   public $scoreArray;


  function __construct($schoolName, $schoolId, $scoreArray){
    $this->schoolName = $schoolName;
    $this->schoolId = $schoolId;
    $this->scoreArray = $scoreArray;

  }

  function get_schoolInfo(){
    echo $this->schoolName.", ". $this->schoolId. " | ";
    for($i=0; $i<count($this->scoreArray); $i++){
    echo $this->scoreArray[$i].", ";}
  }

  function get_convertedScores(){
    global $conn;
        mysqli_select_db($conn,"lawschoolproject01");
    $sql = "select * from leetconverttable2018 where leetPure = '{$this->scoreArray[8]}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if($this->scoreArray[0] == 0){
    $this->scoreArray[0] = $row['leetAscore'];
    $this->scoreArray[1] = $row['leetAPscore'];
    $sql = "select * from leetconverttable2018 where leetPure = '{$this->scoreArray[9]}'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $this->scoreArray[2] = $row['leetBscore'];
    $this->scoreArray[3] = $row['leetBPscore'];}
      //리트점수 환산, 영어점수 환산, 학점 환산
    $this->get_convertedLeet();
    $this->get_convertedGpa();
    $this->get_convertedEng();
  }
  function get_convertedLeet(){ }
  function get_convertedGpa(){}
  function get_convertedEng(){}

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
//강원대 수정 완료
class kwu extends schoolInfo{

  function __construct($scoreArray){
    $this->schoolName = '강원대';
    $this->schoolId = 1;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = ($this->scoreArray[0]+$this->scoreArray[2])*2/3; //2017
    //$this->convertedScore[0] = ($this->scoreArray[0] + $this->scoreArray[2])/160*150; //2018
    $this->convertedScore[0] = ($this->scoreArray[0] + $this->scoreArray[2])/155*150; //2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    //$this->convertedScore[1] = $row['100']/2; //2017
    //$this->convertedScore[1] = $row['100']; //2018
    $this->convertedScore[1] = $row['100']; //2019
  }
  function get_convertedEng(){ //2017 2018
    $minEngScore;
    if ($this->scoreArray[6] === 'toeic'){
      $minEngScore = 720;
    }else if ($this->scoreArray[6] === 'toefl'){
      $minEngScore = 75;
    }else if ($this->scoreArray[6] === 'teps'){
      $minEngScore = 570;
    }

    if ($this->scoreArray[7]>=$minEngScore){
      $this->convertedScore[2] = "pass";
    } else {
      $this->convertedScore[2] = "fail";
    }
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
//건대 입시요강 없음
class kku extends schoolInfo{

  function __construct($scoreArray){
    $this->schoolName = '건국대';
    $this->schoolId = 2;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $this->convertedScore[0] = ($this->scoreArray[0])+($this->scoreArray[2])*150/155;
    # 지원자중 최상위 점수 지만 155 로 함 # 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    #$this->convertedScore[1] = $row['100']*150/100; // 2017
    if ($row['100'] >= 96) { #2018, #2019
      $this->convertedScore[1] = 100;
    }elseif ($row['100'] >= 93) {
      $this->convertedScore[1] = 95;
    }elseif ($row['100'] >= 89) {
      $this->convertedScore[1] = 90;
    }elseif ($row['100'] >= 86) {
      $this->convertedScore[1] = 85;
    }elseif ($row['100'] >= 83) {
      $this->convertedScore[1] = 80;
    }elseif ($row['100'] >= 80) {
      $this->convertedScore[1] = 75;
    }elseif ($row['100'] >= 76) {
      $this->convertedScore[1] = 70;
    }elseif ($row['100'] >= 73) {
      $this->convertedScore[1] = 65;
    }elseif ($row['100'] >= 69) {
      $this->convertedScore[1] = 60;
    }elseif ($row['100'] >= 64) {
      $this->convertedScore[1] = 55;
    }
  }
  function get_convertedEng(){
    $minEngScore; #2018, 2019
    $row = get_table("knuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    #if ($this->scoreArray[6] === 'toeic'){
    //   $row = get_table("kkuengconverttable", $this->scoreArray[6], $row['toeic']);
    //   $this->convertedScore[2] = $row['score'];
    // }else if ($this->scoreArray[6] === 'toefl'){
    //   $this->convertedScore[2] = 0;
    // }else if ($this->scoreArray[6] === 'teps'){
    //   $this->convertedScore[2] = 0;
    // }
    $row = get_table("kkuengconverttable", $this->scoreArray[6], $row['toeic']);
    $this->convertedScore[2] = $row['score'];
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
//2018경북대 변화 없음 수정 완료
class knu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '경북대';
    $this->schoolId = 3;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $this->convertedScore[0] = 95 + (55*($this->scoreArray[0] + $this->scoreArray[2])/($this->maxLeetA + $this->maxLeetB));
    #2018, 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $this->convertedScore[1] = 65 + $row['100']*35/100;
    #2018, 2019
  }
  function get_convertedEng(){
    $minEngScore;
    $row = get_table("knuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = round($row['toeic']*30/990+70,2);
    #2018, 2019

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 경희대 변화 없음 수정 완료
class khu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '경희대';
    $this->schoolId = 4;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    #$this->convertedScore[0] = 70 + 0.2*($this->scoreArray[0] + $this->scoreArray[2]); //2018
    $this->convertedScore[0] = 60 + 0.25*($this->scoreArray[0] + $this->scoreArray[2]); //2019

  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $value = $row['100'];
    if ($value >= 90){
    $this->convertedScore[1] = 100;
    }else {
    $this->convertedScore[1] = 100 - ((90-$value) * 1);
    }
    #2018, 2019
  }

  function get_convertedEng(){
    $minEngScore;
    if ($this->scoreArray[6] === 'toeic'){
      $minEngScore = 700;
    }else if ($this->scoreArray[6] === 'toefl'){
      $minEngScore = 79;
    }else if ($this->scoreArray[6] === 'teps'){
      $minEngScore = 555;
    }

    if ($this->scoreArray[7] >= $minEngScore){
      $this->convertedScore[2] = "pass";
    } else {
      $this->convertedScore[2] = "fail";
    }
    #2018, 2019
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 고려대 영어 pf로 변경, 학점 리트 테이블 수정 완료
class kru extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '고려대';
    $this->schoolId = 5;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $row = get_table_de("kruleetconverttable", '100', $this->scoreArray[1]);
    $leeta = $row['leeta'];
    $row = get_table_de("kruleetconverttable", '100', $this->scoreArray[3]);
    $leetb = $row['leetb'];
    $this->convertedScore[0] = $leeta + $leetb;
    #2018, 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $value = floor($row['100']);
    $row = get_table("krugpaconverttable", '100', $value);
    $this->convertedScore[1] = $row['score'];
    #2018
    #2019 테이블 변경 / 더 세부적으로
  }

  function get_convertedEng(){
    /*
    $row = get_table_de("kruengconverttable", $this->scoreArray[6], $this->scoreArray[7]);

    if ($this->scoreArray[6] === 'toeic'){
      $this->convertedScore[2] = "fail";
    }else{
      $this->convertedScore[2] = $row['score'];
    }*/ //2017

    $minEngScore;
    if ($this->scoreArray[6] === 'toeic'){
      $minEngScore = 1000;
    }else if ($this->scoreArray[6] === 'toefl'){
      $minEngScore = 94;
    }else if ($this->scoreArray[6] === 'teps'){
      $minEngScore = 657;
    }

    if ($this->scoreArray[7]>=$minEngScore){
      $this->convertedScore[2] = "pass";
    } else {
      $this->convertedScore[2] = "fail";
    }  //2018, 2019
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 리트 비중 증가, 학점 비중 감소, 영어 비중 대폭 감소 수정 완료
class dau extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '동아대';
    $this->schoolId = 6;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = 240 + round(($this->scoreArray[0] + $this->scoreArray[2])/3,2); //2017
    //$this->convertedScore[0] = 200 + round(($this->scoreArray[0] + $this->scoreArray[2])/2,2); //2018
    $this->convertedScore[0] = 200 + round(($this->scoreArray[0] + $this->scoreArray[2])/2,2); //2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    // $this->convertedScore[1] = 80 + $row['100']*20/100; //2017
    //$this->convertedScore[1] = 95 + $row['100']*5/100; //2018
    $this->convertedScore[1] = 95 + $row['100']*5/100; //2019
  }
  function get_convertedEng(){
    $minEngScore;
    #$row = get_table("dauengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    #$this->convertedScore[2] = $row['score'];
    // 2018

    $minEngScore;
    $minEngScore2;
    if ($this->scoreArray[6] === 'toeic'){
      $minEngScore = 700;
      $minEngScore2 = 600;
    }else if ($this->scoreArray[6] === 'toefl'){
      $minEngScore = 80;
      $minEngScore2 = 68;
    }else if ($this->scoreArray[6] === 'teps'){
      $minEngScore = 549;
      $minEngScore2 = 476;
    }

    if ($this->scoreArray[7]>=$minEngScore){
      $this->convertedScore[2] = 200;
    } elseif ($this->scoreArray[7] >= $minEngScore2) {
      $this->convertedScore[2] = 190;
    } else {
      $this->convertedScore[2] = 0;
    }  //2019

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 변화 사항 없음 수정 완료
class bsu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '부산대';
    $this->schoolId = 7;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $this->convertedScore[0] = 5 + round((25*(($this->scoreArray[0]/$this->maxLeetA) +
    ($this->scoreArray[2]/$this->maxLeetB))/2),2); //2018, 2019

  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $this->convertedScore[1] = $row['100']*0.2; //2018, 2019
  }
  function get_convertedEng(){
    $minToeic = 700;
    $maxToeic = 990;
    //$minToefl = 71; //2017
    $minToefl = 79;
    $maxToefl = 120;
    $minTeps = 555;
    $maxTeps = 990;

    if ($this->scoreArray[6] === 'toeic'){
      $this->convertedScore[2] = round((20*($this->scoreArray[7] - $minToeic)/($maxToeic-$minToeic)+80)*0.1,2);
    }else if ($this->scoreArray[6] === 'toefl'){
      $this->convertedScore[2] = round((20*($this->scoreArray[7] - $minToefl)/($maxToefl-$minToefl)+80)*0.1,2);
    }else if ($this->scoreArray[6] === 'teps'){
      $this->convertedScore[2] = round((20*($this->scoreArray[7] - $minTeps)/($maxTeps-$minTeps)+80)*0.1,2);
    }
    //2018, 2019

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 실질반영률 수정, 영어 반영방법 수정 완료
class sgu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '서강대';
    $this->schoolId = 8;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = 10 + (0.1*($this->scoreArray[0] + $this->scoreArray[2])); //2017
    //$this->convertedScore[0] = (0.15*($this->scoreArray[0] + $this->scoreArray[2])); //2018
    $this->convertedScore[0] = (0.15*($this->scoreArray[0] + $this->scoreArray[2])); //2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    //$this->convertedScore[1] = $row['100']*0.2 +10; //2017
    //$this->convertedScore[1] = $row['100']*0.1 +20; //2018
    $this->convertedScore[1] = $row['100']*0.1 +20; //2019
  }
  function get_convertedEng(){
    $row = get_table_de("sguengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
      $this->convertedScore[2] = $row['score'];
      //2018, 2019

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 변경없음 수정 완료
class snu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '서울대';
    $this->schoolId = 9;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $this->convertedScore[0] = (0.4*$this->scoreArray[1] + 0.6*$this->scoreArray[3]);
    // 2018, 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $this->convertedScore[1] = $row['100'];
  }
  function get_convertedEng(){
    $minEngScore;
    if ($this->scoreArray[6] === 'toeic'){
      $minEngScore = 1000;
    }else if ($this->scoreArray[6] === 'toefl'){
      $minEngScore = 0;
    }else if ($this->scoreArray[6] === 'teps'){
      $minEngScore = 0;
    }

    if ($this->scoreArray[7]>=$minEngScore){
      $this->convertedScore[2] = "pass";
    } else {
      $this->convertedScore[2] = "fail";
    }
    //2018
    //2019 성적 제한 없어짐. 가지고만 있으면 지원가능
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 학점, 영어 비중 높아짐, 리트 비중 낮춤, 논술 낮춤. 수정 완료
class uos extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '시립대';
    $this->schoolId = 10;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $this->convertedScore[0] = ($this->scoreArray[0]*0.1)+$this->scoreArray[2]*0.1;
    if($this->convertedScore[0] > 15){
      $this->convertedScore[0] = 15;
    }
    // 2018, 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    //$this->convertedScore[1] = $row['100']*0.15; //2017
    //$this->convertedScore[1] = $row['100']*0.20; //2018
    $this->convertedScore[1] = $row['100']*0.20; //2019
  }
  function get_convertedEng(){
    $row = get_table("knuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);


      if ($row['toeic']>=935){
      //$this->convertedScore[2] = 15; //2017
      $this->convertedScore[2] = 20;
      }else {
        //$this->convertedScore[2] = $this->scoreArray[7]*0.015+1; //2017
        $this->convertedScore[2] = $row['toeic']*0.015+6; //2018
      }

      //2018,2019


  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 반영률 변경, 리트 식 변경, 영어 테이블 변경, 영어 비중 대폭 축소, 수정 완료
class skku extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '성균관대';
    $this->schoolId = 11;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = ($this->scoreArray[0] + $this->scoreArray[2])*0.5*0.25; //2017
    //$this->convertedScore[0] = ($this->scoreArray[0] + $this->scoreArray[2])*0.5*0.3; //2018
    $this->convertedScore[0] = ($this->scoreArray[0] + $this->scoreArray[2])*0.15; //2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $this->convertedScore[1] = $row['100']*0.15+15; //2019
  }
  function get_convertedEng(){
    $row = get_table("knuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $cvt_eng = $row['toeic'];
    $row = get_table_de("skkuengconverttable", $this->scoreArray[6], $cvt_eng);

      $this->convertedScore[2] = $row['score'];
      //2019 테이블 변경
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 학점, 영어 반영 식 변경 수정 완료
class aju extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '아주대';
    $this->schoolId = 12;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = (($this->scoreArray[0] + $this->scoreArray[2])*0.4 +
    //($this->scoreArray[1]+$this->scoreArray[3])*0.1)*0.25+5; //2018
    $this->convertedScore[0] = (($this->scoreArray[0]*0.4 + $this->scoreArray[2]*0.6)*0.8 + ($this->scoreArray[1]*0.4 + $this->scoreArray[3]*0.6)*0.2)*0.25+5;
    //2019

  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    //$this->convertedScore[1] = $row['100']*0.2*0.5+10; //2017
    $this->convertedScore[1] = $row['100']*0.2*0.75+5; //2018, 2019
  }
  function get_convertedEng(){
    $row = get_table_de("ajuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = $row['score']*0.12+8; //2019
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 변경없음 수정 완료
class ysu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '연세대';
    $this->schoolId = 13;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    //$row = get_table_de("ysuleetconverttable", 'leet', $this->scoreArray[0]+$this->scoreArray[2]); //2018
    $row = get_table_de("ysuleetconverttable", '100', $this->scoreArray[1]);
    $leeta = $row['leeta'];
    $row = get_table_de("ysuleetconverttable", '100', $this->scoreArray[3]);
    $leetb = $row['leetb'];
    $this->convertedScore[0] = $leeta + $leetb;
    //2019

  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $row = get_table("ysugpaconverttable", '100', $row['100']);
    $this->convertedScore[1] = $row['score'];
  }

  function get_convertedEng(){
    //$row = get_table_de("ysuengconverttable", $this->scoreArray[6], $this->scoreArray[7]); //2018
    //$this->convertedScore[2] = $row['score']; //2018

    $minEngScore;
    if ($this->scoreArray[6] === 'toeic'){
      $minEngScore = 850;
    }else if ($this->scoreArray[6] === 'toefl'){
      $minEngScore = 99;
    }else if ($this->scoreArray[6] === 'teps'){
      $minEngScore = 700;
    }

    if ($this->scoreArray[7]>=$minEngScore){
      $this->convertedScore[2] = "pass";
    } else {
      $this->convertedScore[2] = "fail";
    }  // 2019

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 영남대 변경 없음 수정 완료
class ynu extends schoolInfo{//2018, 2019
  function __construct($scoreArray){
    $this->schoolName = '영남대';
    $this->schoolId = 14;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $this->convertedScore[0] = round(($this->scoreArray[0]+$this->scoreArray[2])*1.5,2); //2018,2019
  }

  function get_convertedGpa(){
    $value = $this->scoreArray[5]/$this->scoreArray[4]*4.5;
    if ($value >= 4.0){
      $this->convertedScore[1] = 100;
    }elseif ($value >= 3.5){
      $this->convertedScore[1] = 95;
    }elseif ($value >= 3.0){
      $this->convertedScore[1] = 90;
    }else{
      $this->convertedScore[1] = 80;
    }
  }

  function get_convertedEng(){
    $minvalue1;
    $minvalue2;
    if ($this->scoreArray[6] === 'toeic'){
      $minvalue1 = 950;
      $minvalue2 = 600;
    }elseif ($this->scoreArray[6] === 'toefl'){
      $minvalue1 = 111;
      $minvalue2 = 57;
    }elseif ($this->scoreArray[6] === 'teps'){
      $minvalue1 = 860;
      $minvalue2 = 476;
    }
    if ($this->scoreArray[7] >= $minvalue1){
      $this->convertedScore[2] = 100;
    }elseif ($this->scoreArray[7] >=$minvalue2){
      $this->convertedScore[2] = 90;
    }else{
      $this->convertedScore[2] = 0;
    }
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 영어 상하한점수 변경, 수정 완료
class wgu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '원광대';
    $this->schoolId = 15;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $this->convertedScore[0] = ((($this->scoreArray[0]*0.5) + (1.5*$this->scoreArray[2]))/2+75)*2/7;
  }

  function get_convertedGpa(){
    //$this->convertedScore[1] =$this->scoreArray[5]*4.5/$this->scoreArray[4]*3/4.5+17;//2018
    $this->convertedScore[1] =$this->scoreArray[5]*4.5/$this->scoreArray[4]*2/4.5+18;//2019
  }
  function get_convertedEng(){
    $minvalue1;
    $minvalue2;
    if ($this->scoreArray[6] === 'toeic'){
      //$minvalue1 = 900; //2017
      //$minvalue2 = 700; //2017
      $minvalue1 = 950; //2018
      $minvalue2 = 750; //2018
    }elseif ($this->scoreArray[6] === 'toefl'){
      //$minvalue1 = 105; //2017
      $minvalue1 = 112; //105
      //$minvalue2 = 80;  //2017
      $minvalue2 = 85;  //80
    }elseif ($this->scoreArray[6] === 'teps'){
      //$minvalue1 = 768; //2017
      //$minvalue2 = 557 ; //2017
      $minvalue1 = 857; //768
      $minvalue2 = 597; //557
    }
    if ($this->scoreArray[7] >= $minvalue1){
      $this->convertedScore[2] = 20;
    }elseif ($this->scoreArray[7] <=$minvalue2){
      //$this->convertedScore[2] = 16; //2018
      $this->convertedScore[2] = 18; //2019
    }else{
      $this->convertedScore[2] = (($this->scoreArray[7]-$minvalue2)/($minvalue1-$minvalue2)*2)+18;
    }
  }
  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 변경 없음 수정 완료
class ehu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '이화여대';
    $this->schoolId = 16;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    //$row = get_table_de("ehuleetconverttable", 'leet', $this->scoreArray[0]+$this->scoreArray[2]);

    //$this->convertedScore[0] = $row['score']; //2018
    $this->convertedScore[0] = ($this->scoreArray[0]+$this->scoreArray[2]-40)/2; //2019
  }

  function get_convertedGpa(){
    $this->convertedScore[1] =$this->scoreArray[5]/$this->scoreArray[4]*40; //2018, 2019
  }
  function get_convertedEng(){
    $row = get_table_de("ehuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = $row['score'];
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 인하대 요강 없음
class ihu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '인하대';
    $this->schoolId = 17;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = ($this->scoreArray[0]+$this->scoreArray[2])*250/160; //2017
    //$this->convertedScore[0] = ($this->scoreArray[0]+$this->scoreArray[2])*200/160 +50; //2018
    $this->convertedScore[0] = ($this->scoreArray[0]+$this->scoreArray[2])*210/160 +40; //2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $row = get_table_de("ihugpaconverttable", '4.5', $row['4.5']);
    $this->convertedScore[1] = $row['score'];
  }
  function get_convertedEng(){
    $row = get_table_de("ihuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = round($row['toeic']*50/990+50,2);
  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 학점 비중 높아짐 수정 완료 , 20119
class jnu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '전남대';
    $this->schoolId = 18;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $this->convertedScore[0] = ($this->scoreArray[0] + $this->scoreArray[2]) - 40;
    if($this->convertedScore[0] >=100){
      $this->convertedScore[0] = 100;
    }elseif ($this->convertedScore[0] < 30) {
      $this->convertedScore[0] = 30;
    }
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    //$this->convertedScore[1] = $row['100']*60/100+40; //2017
    $this->convertedScore[1] = $row['100']*70/100+30; // 2018, 2019
  }
  function get_convertedEng(){
    $minEngScore;
    $row = get_table_de("jnuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = $row['score'];

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 전북대 영어 테이블 변화, 텝스 토플 점수 후하게 쳐줌. 수정 완료
class jbu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '전북대';
    $this->schoolId = 19;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $sumValue = $this->scoreArray[0] + $this->scoreArray[2];
    $addValue;
    if ($sumValue>=126){
      $addValue = 2;
    }elseif ($sumValue>=121){
      $addValue = 1.5;
    }elseif ($sumValue>=116){
      $addValue = 1;
    }elseif ($sumValue>=110){
      $addValue = 0.5;
    }else{
      $addValue = 0;
    }
    $this->convertedScore[0] = round($sumValue *30/200 + $addValue,2); //2018, 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $row = get_table_de("jbugpaconverttable", "100", $row['100']);
    $this->convertedScore[1] = $row['score'];
  }
  function get_convertedEng(){
    $minEngScore;
    $row = get_table_de("jbuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = round($row['toeic']*10/990,2);

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 제주대 리트 비중 높아짐, 영어 낮아짐, 논술 낮아지고 서류 높아짐. 수정완료
class jju extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '제주대';
    $this->schoolId = 20;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    //$this->convertedScore[0] = ($this->scoreArray[0]*0.4 + $this->scoreArray[2]*0.6)*0.25; //2017
    //$this->convertedScore[0] = ($this->scoreArray[0]*0.4 + $this->scoreArray[2]*0.6)*0.3; //2018
    $this->convertedScore[0] = ($this->scoreArray[0]*0.4 + $this->scoreArray[2]*0.6)*0.3; //2019
  }
  function get_convertedGpa(){
    $row = get_table("jjugpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $this->convertedScore[1] = $row['score']*20/100; //2018, 2019
  }
  function get_convertedEng(){
    $row = get_table_de("jjuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    //$this->convertedScore[2] = $row['score']/100*15; //2017
    $this->convertedScore[2] = $row['score']/100*10; //2018, 2019
  }
  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 중앙대 요강 없음
class jau extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '중앙대';
    $this->schoolId = 21;
    $this->scoreArray = $scoreArray;

  }
  function get_convertedLeet(){
    $sumValue = $this->scoreArray[0] + $this->scoreArray[2];
    if ($sumValue <= 84){
        $this->convertedScore[0] = 80;
    }elseif($sumValue >=135){
      $this->convertedScore[0] = 100;
    }else{
      $this->convertedScore[0] = round(($sumValue-84)*20/51,2)+80;
    } // 2018, 2019
  }

  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    if ($row['4.5'] <= 2.4){
        $this->convertedScore[1] = 80;
    }elseif($row['4.5'] >= 4.4){
      $this->convertedScore[1] = 100;
    }else{
      $this->convertedScore[1] = round(($row['4.5']-2.4)*20/2,2)+80;
    } // 2018, 2019
  }

  function get_convertedEng(){
    $maxValue;
    if($this->scoreArray[6] === 'toefl'){
      $maxValue = 120;
    }else{
      $maxValue = 990;
    }
    $this->convertedScore[2] = round($this->scoreArray[7]/$maxValue*15,2)+85;
  }
  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 변화 없음 수정 완료
class cnu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '충남대';
    $this->schoolId = 22;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $sumValue = $this->scoreArray[0] + $this->scoreArray[2];
      $this->convertedScore[0] = $sumValue*0.7-20;
  }
  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
      $this->convertedScore[1] = $row['100'];
    }
  function get_convertedEng(){
    $row = get_table_de("cnuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = $row['score'];
  }
  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  } // 2018, 2019
}
// 최고점 수정 시 변경 가능, 논술 많이봄, 수정 완료
class cbu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '충북대';
    $this->schoolId = 23;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $sumValue = $this->scoreArray[0]/$this->maxLeetA + $this->scoreArray[2]/$this->maxLeetB;
      //$this->convertedScore[0] = round($sumValue*50,2);//2018
      $this->convertedScore[0] = round($sumValue*75,2);//2019
  }
  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
    $row = get_table_de("cbugpaconverttable", '100', $row['100']);
      $this->convertedScore[1] = $row['score'];
    }
  function get_convertedEng(){
    $row = get_table_de("cbuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = $row['score'];
  }
  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 한국외대 리트 비슷, 학점 낮춤, 영어 낮춤 수정 완료
class hufs extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '한국외대';
    $this->schoolId = 24;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $sumValue = $this->scoreArray[0] + $this->scoreArray[2];
      //$this->convertedScore[0] = $sumValue+50; //2017
      //$this->convertedScore[0] = $sumValue/2+25; //2018
      $this->convertedScore[0] = $sumValue/2+25; //2019
  }
  function get_convertedGpa(){
      //$this->convertedScore[1] = ($this->scoreArray[5] / $this->scoreArray[4])*50+50; //2017
      //$this->convertedScore[1] = ($this->scoreArray[5] / $this->scoreArray[4])*35+65; //2018
      $this->convertedScore[1] = ($this->scoreArray[5] / $this->scoreArray[4])*35+65; //2019
    }
  function get_convertedEng(){
    $maxValue;
    if($this->scoreArray[6] === 'toefl'){
      $maxValue = 120;
    }else{
      $maxValue = 990;
    }
    //$this->convertedScore[2] = round($this->scoreArray[7]/$maxValue*50,2)+50; //2017
    //$this->convertedScore[2] = round($this->scoreArray[7]/$maxValue*30,2)+70; //2018
    $this->convertedScore[2] = round($this->scoreArray[7]/$maxValue*30,2)+70; //2019
  }
  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
// 변경 없음 수정 완료 2018, 2019
class hyu extends schoolInfo{
  function __construct($scoreArray){
    $this->schoolName = '한양대';
    $this->schoolId = 25;
    $this->scoreArray = $scoreArray;
  }
  function get_convertedLeet(){
    $sumValue = ($this->scoreArray[0]/$this->maxLeetA + $this->scoreArray[2]/$this->maxLeetB)/2;
      if ($sumValue>=0.95){
          $this->convertedScore[0] = 30;
      } elseif($sumValue< 0.45){
        $this->convertedScore[0] = 9;
      } else{
        $this->convertedScore[0] = 9+ ($sumValue-0.45)*42;
      }
  }
  function get_convertedGpa(){
    $row = get_table("gpaconverttable", $this->scoreArray[4], $this->scoreArray[5]);
      if ( $row['100']>=70){
          $this->convertedScore[1] = 8+ ($row['100']-70)*0.4;
      } elseif( $row['100']< 70){
        $this->convertedScore[1] = 8;
      }
    }

  function get_convertedEng(){
    $row = get_table_de("hyuengconverttable", $this->scoreArray[6], $this->scoreArray[7]);
    $this->convertedScore[2] = $row['score'];

  }

  function get_applecationRates(){
    //데이터 베이스에서 가져오기
  }
}
?>
