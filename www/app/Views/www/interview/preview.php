<?php

?>

<!--s #scontent-->
<div id="scontent">
  <!--s top_tltBox-->
  <div class="top_tltBox c">
    <!--s top_tltcont-->
    <div class="top_tltcont">
      <a href="javascript:window.history.back();">
        <div class="backBtn"><span>뒤로가기</span></div>
      </a>
      <div class="tlt">실제 면접 질문 엿보기</div>
    </div>
    <!--e top_tltcont-->
  </div>
  <!--e top_tltBox-->

  <!--s cont-->
  <div class="cont cont_pd_bottom">
    <!--s bigtlt-->
    <div class="bigtlt bigtlt_mg_b">
      <!-- <span class="point b">카카오</span>에서 <span class="point b">개발자</span>에게 묻는 <span class="point b">5가지</span> -->
      <span class="point b"><?=$data['mock']['rec_nos_title']?></span>
    </div>
    <!--e bigtlt-->

    <!--s question_viewBox-->
    <div class="question_viewBox">
      <!--s question_viewcont-->
      <div class="question_viewcont">
        <?= $data['mock']['rec_nos_content']; ?><br><br>

        <?php foreach ($data['mockQuestion'] as $key => $val) : ?>
          <?= $key + 1 ?>. <?= $val['que_question'] ?><br>
        <?php endforeach; ?>
      </div>
      <!--e question_viewcont-->
    </div>
    <!--e question_viewBox-->

    <!--s BtnBox-->
    <div class="BtnBox">
      <a href="/interview/ready?mock=<?=$data['mockIdx']?>" class="btn btn01 wps_100"><span class="icon"><img src="/static/www/img/sub/qv_mike_icon.png"></span>모의 인터뷰 시작하기</a>
      <!-- <a href="#n" class="btn btn02 wps_100 mg_t10"><span class="icon"><img src="/static/www/img/sub/qv_If_icon.png"></span>기업 정보 보러가기</a> -->
    </div>
    <!--e BtnBox-->
  </div>
  <!--e cont-->
</div>
<!--e #scontent-->