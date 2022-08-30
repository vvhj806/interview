<?php foreach ($data['report'] as $repoVal) : ?>
    <!--s big_itv_pr_report2-->
    <div class="big_itv_pr_report2">
        <!--s itv_pr_reportBox-->
        <div class="itv_pr_reportBox">
            <?php if ($repoVal['app_share'] == '0') : ?>
                <div class="top_txt">비공개</div>
            <?php else : ?>
                <div class="top_txt">공개</div>
            <?php endif; ?>

            <input type="hidden" name="report" value="<?= $repoVal['idx'] ?>">

            <a href="javascript:void(0)">
                <div class="imgBox"><img src="https://media.highbuff.com<?= $repoVal['file_save_name'] ?>"></div>
            </a>
            <a href="javascript:void(0)">
                <!--s txtBox-->
                <div class="txtBox">
                    <div class="class"><?= $repoVal['repo_analysis'] ?></div>
                    <div class="tlt">[ <?= $repoVal['job_depth_text'] ?> ]</div>
                    <div class="question">질문 <?= $repoVal['queCount'] ?>개</div>
                    <div class="data"><?= $repoVal['app_reg_date'] ?></div>
                </div>
                <!--e txtBox-->
            </a>

            <a href="report/detail<?= $repoVal['idx'] ?>" class="itv_btn"><img src="/static/www/img/sub/itv_pr_pop_arrow_r.png"></a>

            <!--s rs_chkBox-->
            <div class="rs_chkBox hide" data-idx='<?= $repoVal['idx'] ?>'>
                <div class="chk_icon point"><i class="la la-check"></i></div>
            </div>
            <!--e rs_chkBox-->
        </div>
        <!--e itv_pr_reportBox-->
    </div>
    <!--e big_itv_pr_report2-->
<?php endforeach ?>