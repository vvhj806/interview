<?php if ($data['pageType'] === 'left') : ?>
    <ul class="ard_list first_duty" style="padding-bottom:320px;">
        <?php if (isset($data['job']['job_depth_1'])) : ?>
            <?php foreach ($data['job']['job_depth_1'] as $depth1 => $row) : ?>
                <li>
                    <input id='J<?= $depth1 ?>' class='hide' type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth1[]' value='<?= $row['idx'] ?>' <?= in_array($row['idx'], $data['checked'] ?? [])  ? 'checked' : '' ?>>
                    <label for='J<?= $depth1 ?>' style='white-space:nowrap;'>
                        <?= $row['jobName'] ?> (<?= $row['count'] ?>)
                    </label>
                </li>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>

    <style>
        .ard_list {
            padding-bottom: 0px !important;
        }
    </style>
<?php elseif ($data['pageType'] === 'right') : ?>
    <ul class='ard_list second_duty jobDepth2'>
        <?php foreach ($data['job']['job_depth_1'] as $depth1 => $row1) : ?>
            <?php foreach ($data['job']['job_depth_2'][$depth1] as $depth2 => $row2) : ?>
                <li data-depth1="<?= $depth1 ?>" class='hide'>
                    <input type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth2' class='hide'>
                    <label class='depth2'>
                        <div>
                            <?= $row2['jobName'] ?>
                            <?= $row2['count'] ?>
                            <div><i class="la la-plus"></i></div>
                        </div>
                    </label>
                    <ul class='hide ard_list mini_list'>
                        <?php foreach ($data['job']['job_depth_3'][$depth1][$depth2] as $depth3 => $row3) : ?>
                            <li data-depth3-idx='<?= $row3['idx'] ?>'>
                                <input id='D<?= "{$depth1}{$depth2}{$depth3}" ?>' type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth3[]' class='hide' value='<?= $row3['idx'] ?>' <?= in_array($row3['idx'], $data['checked'] ?? [])  ? 'checked' : '' ?>>
                                <label for='D<?= "{$depth1}{$depth2}{$depth3}" ?>' class='depth3'>
                                    <?= $row3['jobName'] ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>

    <script>
        $(document).on('click', '.depth2', function() { //depth2
            const icon = $(this).find('i');
            $(this).next('ul').slideToggle();
            icon.toggleClass('la-plus');
            icon.toggleClass('la-minus');
        });

        $(document).on('change', 'input[name="depth3[]"]', function() { //depth3
            const ul = $(this).closest('ul');
            const icon = ul.prev('label').find('i');

            if ($(this).is(':checked')) {
                ul.prev('.depth2').prev('input').prop('checked', true);
                ul.slideDown();

                icon.removeClass('la-plus');
                icon.addClass('la-minus');
            } else {
                if (ul.find('input[type="checkbox"]:checked').length == 0) {
                    ul.prev('.depth2').prev('input').prop('checked', false);
                }
            }
        });
    </script>

<?php elseif ($data['pageType'] === 'search') : ?>
    <!--s ard_1th-->
    <div class="ard_1th">
        <div class="ard_tlt c">산업군</div>
        <ul class="ard_list first_duty" style="padding-bottom:320px;">
            <?php if (isset($data['job']['job_depth_1'])) : ?>
                <?php foreach ($data['job']['job_depth_1'] as $depth1 => $row) : ?>
                    <li>
                        <input id='J<?= $depth1 ?>' class='hide' type='radio' name='depth1' value='<?= $depth1 ?>' <?= in_array($row['idx'], $data['checked'] ?? [])  ? 'checked' : '' ?>>
                        <label for='J<?= $depth1 ?>' style='white-space:nowrap;'>
                            <?= $row['jobName'] ?> (<?= $row['count'] ?>)
                        </label>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <!--e ard_1th-->

    <!--s ard_2th-->
    <div class="ard_2th">
        <div class="ard_tlt c">직무</div>
        <ul class='ard_list second_duty jobDepth2'>
            <?php foreach ($data['job']['job_depth_1'] as $depth1 => $row1) : ?>
                <?php if (isset($data['job']['job_depth_2'][$depth1])) : ?>
                    <?php foreach ($data['job']['job_depth_2'][$depth1] as $depth2 => $row2) : ?>
                        <li data-depth1="<?= $depth1 ?>" class='hide'>
                            <input type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth2' class='hide' value='<?= $depth2 ?>'>
                            <label class='depth2'>
                                <div>
                                    <?= $row2['jobName'] ?> (<?= $row2['count'] ?>)
                                    <div><i class="la la-plus"></i></div>
                                </div>
                            </label>
                            <ul class='hide ard_list mini_list'>
                                <?php if (isset($data['job']['job_depth_3'][$depth1][$depth2])) : ?>
                                    <li data-depth3-idx=''>
                                        <input class='hide'>
                                        <label>
                                            <?= $row2['jobName'] ?> 전체
                                        </label>
                                    </li>
                                    <?php foreach ($data['job']['job_depth_3'][$depth1][$depth2] as $depth3 => $row3) : ?>
                                        <li data-depth3-idx='<?= $row3['idx'] ?>'>
                                            <input id='D<?= "{$depth1}{$depth2}{$depth3}" ?>' type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth3[]' class='hide' value='<?= $row3['idx'] ?>' <?= in_array($row3['idx'], $data['checked'] ?? [])  ? 'checked' : '' ?>>
                                            <label for='D<?= "{$depth1}{$depth2}{$depth3}" ?>' class='depth3'>
                                                <?= $row3['jobName'] ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <!--e ard_2th-->

    <script>
        $(document).on('change', 'input[name="depth1"]', function() { //depth1
            const iDepth1 = $(this).val();
            depth1IsOn(iDepth1);
        });

        $(document).on('click', '.depth2', function() { //depth2
            const thisEle = $(this);
            if (thisEle.prev('input').attr('type') == 'radio') {
                if (thisEle.hasClass('on')) {
                    depth2IsOffType(thisEle);
                } else {
                    depth2IsOnType(thisEle);
                }
            } else {
                thisEle.toggleClass('on');
                depth2Toggle(thisEle);
            }
        });

        $(document).on('change', 'input[name="depth3[]"]', function() { //depth3
            const ul = $(this).closest('ul');

            if ($(this).is(':checked')) {
                depth3IsOn(ul);
            } else {
                depth3IsOff(ul);
            }
        });
    </script>
<?php else : ?>
    <!--s ard_1th-->
    <div class="ard_1th">
        <div class="ard_tlt c">산업군</div>
        <ul class="ard_list first_duty" style="padding-bottom:320px;">
            <?php if (isset($data['job']['job_depth_1'])) : ?>
                <?php foreach ($data['job']['job_depth_1'] as $depth1 => $row) : ?>
                    <li>
                        <input id='J<?= $depth1 ?>' class='hide' type='radio' name='depth1' value='<?= $depth1 ?>' <?= in_array($row['idx'], $data['checked'] ?? [])  ? 'checked' : '' ?>>
                        <label for='J<?= $depth1 ?>' style='white-space:nowrap;'>
                            <?= $row['jobName'] ?> (<?= $row['count'] ?>)
                        </label>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
    <!--e ard_1th-->

    <!--s ard_2th-->
    <div class="ard_2th">
        <div class="ard_tlt c">직무</div>
        <ul class='ard_list second_duty jobDepth2'>
            <?php foreach ($data['job']['job_depth_1'] as $depth1 => $row1) : ?>
                <?php if (isset($data['job']['job_depth_2'][$depth1])) : ?>
                    <?php foreach ($data['job']['job_depth_2'][$depth1] as $depth2 => $row2) : ?>
                        <li data-depth1="<?= $depth1 ?>" class='hide'>
                            <input type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth2' class='hide' value='<?= $depth2 ?>'>
                            <label class='depth2'>
                                <div>
                                    <?= $row2['jobName'] ?> (<?= $row2['count'] ?>)
                                    <div><i class="la la-plus"></i></div>
                                </div>
                            </label>
                            <ul class='hide ard_list mini_list'>
                                <?php if (isset($data['job']['job_depth_3'][$depth1][$depth2])) : ?>
                                    <?php foreach ($data['job']['job_depth_3'][$depth1][$depth2] as $depth3 => $row3) : ?>
                                        <li data-depth3-idx='<?= $row3['idx'] ?>'>
                                            <input id='D<?= "{$depth1}{$depth2}{$depth3}" ?>' type='<?= $data['option'] === 'only' ? 'radio' : 'checkbox' ?>' name='depth3[]' class='hide' value='<?= $row3['idx'] ?>' <?= in_array($row3['idx'], $data['checked'] ?? [])  ? 'checked' : '' ?>>
                                            <label for='D<?= "{$depth1}{$depth2}{$depth3}" ?>' class='depth3'>
                                                <?= $row3['jobName'] ?>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <!--e ard_2th-->

    <script>
        <?php if ($data['checked'] ?? []) : ?>
            $(document).ready(function() {
                $('input[name="depth1"]:checked').each(function() {
                    depth1IsOn($(this).val());

                    const depth1ScrollTap = $('.first_duty');
                    const depth1nowTop = $(this).closest('li').position().top;
                    searchScroll(depth1ScrollTap, depth1nowTop);
                });
            });
        <?php endif; ?>

        $(document).on('change', 'input[name="depth1"]', function() { //depth1
            const iDepth1 = $(this).val();
            depth1IsOn(iDepth1);
        });

        $(document).on('click', '.depth2', function() { //depth2
            const thisEle = $(this);
            if (thisEle.prev('input').attr('type') == 'radio') {
                if (thisEle.hasClass('on')) {
                    depth2IsOffType(thisEle);
                } else {
                    depth2IsOnType(thisEle);
                }
            } else {
                thisEle.toggleClass('on');
                depth2Toggle(thisEle);
            }
        });

        $(document).on('change', 'input[name="depth3[]"]', function() { //depth3
            const ul = $(this).closest('ul');

            if ($(this).is(':checked')) {
                depth3IsOn(ul);
            } else {
                depth3IsOff(ul);
            }
        });
    </script>
    <style>
        .ard_list>li>label {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
<?php endif; ?>