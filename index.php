

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>로스쿨 모의 지원</title>
  </head>
  <body>
    <br><br>
    <div class="" align="center">
      <a href="http://www.megals.co.kr/prof/prof_main.asp?bCode=kalitsma&sub_cd=26#tab1" target="_blank">
        <img src="./banner_2.png" alt="황변과 함께하는 법학적 사고력" style="width: 600px;">
      </a><br><br><br><br>
    <a href="http://www.megals.co.kr/prof/prof_main.asp?bCode=kalitsma&sub_cd=26#tab1" target="_blank">
      <img src="./quot_1.png" alt="황변과 함께하는 법학적 사고력" style="width: 700px;">
    </a>
  </div><br>
    <div class="container">
      <div class="jumbotron" style="background: #fff5d3;">
        <!-- form 부분 -->
        <form class="" action="pre_process.php" method="post" name="score">
          <div class="row">
            <div class="col-md-6">
          <label class="field-label-2" for="leetAscore">언어이해 표준점수</label>
          <input class="form-control" data-name="leetAscore" id="leetAscore" maxlength="256" name="leetAscore" placeholder="언어이해 표준점수 입력란"
          required="required" type="text">
         </div>
          <div class="col-md-6">
          <label class="field-label-2" for="leetAPscore">언어이해 백분위</label>
          <input class="form-control" data-name="leetAPscore" id="leetAPscore" maxlength="256" name="leetAPscore" placeholder="언어이해 백분위 입력란"
          required="required" type="text">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
          <label class="field-label-2" for="leetBscore">추리논증 표준점수</label>
          <input class="form-control" data-name="leetBscore" id="leetBscore" maxlength="256" name="leetBscore" placeholder="추리논증 표준점수 입력란"
          required="required" type="text">
        </div>
          <div class="col-md-6">
          <label class="field-label-2" for="leetBPscore">추리논증 백분위</label>
          <input class="form-control" data-name="leetBPscore" id="leetBPscore" maxlength="256" name="leetBPscore" placeholder="추리논증 백분위 입력란"
          required="required" type="text">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">

              <label class="field-label-2" for="schoolScore">학부성적 원점수</label>
              <div>
                <div class="radio-button-field w-radio">
                  <input class="w-radio-input" data-name="radioSchool" id="40" name="radio" type="radio" value="4.0">
                  <label class="w-form-label" for="40">4.0</label>
                </div>
                <div class="radio-button-field w-radio">
                  <input class="w-radio-input" data-name="radioSchool" id="43" name="radio" type="radio" value="4.3">
                  <label class="w-form-label" for="43">4.3</label>
                </div>
                <div class="radio-button-field w-radio">
                  <input class="w-radio-input" checked="checked" data-name="radioSchool" id="45" name="radio" type="radio" value="4.5">
                  <label class="w-form-label" for="45">4.5</label>
                </div>
              </div>
              <input class="form-control" data-name="schoolScore" id="schoolScore" maxlength="256" name="schoolScore" placeholder="학부성적 원점수 입력란"
              required="required" type="text">

            </div>
            <div class="col-md-6">
              <label class="field-label-2" for="engScore">영어성적 원점수</label>
              <div>
                <div class="radio-button-field w-radio">
                  <input class="w-radio-input"checked="checked" data-name="radioEng" id="toeic" name="radioEng" type="radio" value="toeic">
                  <label class="w-form-label" for="toeic">TOEIC</label>
                </div>
                <div class="radio-button-field w-radio">
                  <input class="w-radio-input" data-name="radioEng" id="toefl" name="radioEng" type="radio" value="toefl">
                  <label class="w-form-label" for="toefl">TOEFL</label>
                </div>
                <div class="radio-button-field w-radio">
                  <input class="w-radio-input" data-name="radioEng" id="teps" name="radioEng" type="radio" value="teps">
                  <label class="w-form-label" for="teps">TEPS</label>
                </div>
              </div>
              <input class="form-control" data-name="engScore" id="engScore" maxlength="256" name="engScore" placeholder="영어성적 원점수 입력란"
              required="required" type="text">
              <input type="hidden" name="signState" value="">
            </div>
          </div>
          <br>
           <!--
           <a class="btn btn-default btn-lg" href="https://t1.daumcdn.net/cfile/tistory/99AC4F3C5B42EEA33D" onclick="window.open(this.href, '_blanck', 'width=600, height=700'); return false">18학년도 리트 변환표</a>
           -->

                <input type="submit" class=" btn btn-default btn-lg " value="확인" style="float: right;">
                <br><br>

        </form>
        * LEET 표준 점수가 공식적으로 발표되기 전까지는 사설기관의 자료를 활용하시고 
         발표 후에는 개인 성적을 활용하시면 됩니다.
    </div>
    </div>
    <?php
    require("./foot.php"); ?>
