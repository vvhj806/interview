<!--s #bottom_quick-->
<div id="bottom_quick" <?= ($data['option'] ?? false) ? 'class="quick_class"' : '' ?>>

    <!--s qicon01-->
    <div class="bt_qicon qicon01 <?= $data['nowPage'] === 'home' ? 'on' : '' ?>">
        <!--해당페이지 일때 on클래스 추가-->
        <a href="/">
            <div class="icon"><span>홈</span></div>
            <div class="txt">홈</div>
        </a>
    </div>
    <!--e qicon01-->

    <!--s qicon02-->
    <div class="bt_qicon qicon02 <?= $data['nowPage'] === 'recruit' ? 'on' : '' ?>">
        <a href="/jobs/list">
            <div class="icon"><span>채용</span></div>
            <div class="txt">채용</div>
        </a>
    </div>
    <!--e qicon02-->

    <!--s qicon03-->
    <div class="bt_qicon qicon03 <?= $data['nowPage'] === 'company' ? 'on' : '' ?>">
        <a href="/company/explore">
            <div class="icon"><span>기업탐색</span></div>
            <div class="txt">기업탐색</div>
        </a>
    </div>
    <!--e qicon03-->

    <!--s qicon04-->
    <div class="bt_qicon qicon04 <?= $data['nowPage'] === 'report' ? 'on' : '' ?>">
        <a href="/report">
            <div class="icon"><span>AI리포트</span></div>
            <div class="txt">AI리포트</div>
        </a>
    </div>
    <!--e qicon04-->

    <!--s qicon05-->
    <div class="bt_qicon qicon05 <?= $data['nowPage'] === 'scrap' ? 'on' : '' ?>">
        <a href="/my/scrap/recruit">
            <div class="icon"><span>스크랩</span></div>
            <div class="txt">스크랩</div>
        </a>
    </div>
    <!--e qicon05-->
</div>
<!--e #bottom_quick-->
<?php if (($data['option'] ?? false)) : ?>
    <style>
        .quick_class {
            position: relative !important;
            /* padding: 0px !important; */
        }

        .bt_qicon a {
            float: none;
            height: auto !important;
            display: inline-block;
            line-height: unset;
        }
    </style>
<?php endif; ?>