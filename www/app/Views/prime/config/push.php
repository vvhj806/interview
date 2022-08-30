<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">푸시/알림</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="box">
                    <div class="mg_b20">
                        <form id="frm" method="post" action="/prime/config/push">
                            <?= csrf_field() ?>
                            <input type="text" id="search_keyword" name="search_keyword" placeholder="ID, 이름, 연락처">
                            <input type="submit" value="검색" class="btn btn-dark wps_10">
                        </form>
                    </div>
                    <div class="card card-secondary wps_60 table_height" style="float:left;">
                        <table class="table" style="margin-bottom: 0rem;">
                            <colgroup>
                                <col class="wps_7">
                                <col class="">
                                <col class="wps_20">
                                <col class="wps_20">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-left"><input type="checkbox" class="chk_list" id="chk_all" name="chk_list" value="a"></th>
                                    <th class="text-left">ID</th>
                                    <th class="text-left">이름</th>
                                    <th class="text-left">연락처</th>

                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                if (count($memList)) :
                                    foreach ($memList as $row) :
                                ?>
                                        <tr>
                                            <td class="text-left">
                                                <input type="checkbox" class="chk_list" name="chk_list" value="<?= $row['idx'] ?>">
                                                <input type="hidden" id="id_<?= $row['idx'] ?>" value="<?= $row['mem_id'] ?>">
                                            </td>
                                            <td class="text-left">
                                                <?= $row['mem_id'] ?>
                                            </td>
                                            <td class="text-left">
                                                <?= $row['mem_name'] ?>
                                            </td>
                                            <td class="text-left">
                                                <?= $row['mem_tel'] ?>
                                            </td>

                                        </tr>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="wps_10" style="float:left;position:relative;top: 200px;">
                        <div class="hc vc" style="">
                            <div class="arrow-next" style="cursor:pointer"></div>
                        </div>
                    </div>
                    <div class="card card-secondary wps_30 table_height" style="float:left;">
                        <table class="table" style="margin-bottom: 0rem;">
                            <colgroup>
                                <col class="">

                            </colgroup>
                            <thead>
                                <tr>

                                    <th class="text-left">ID</th>


                                </tr>

                            </thead>
                            <tbody id='senddatalist'>

                            </tbody>
                        </table>


                    </div>
                    <form id="frm" method="post" action="/prime/config/push/action">
                        <?= csrf_field() ?>
                        <input type="hidden" id="send_data" name='send_data' value="">
                        <table class="table" style="margin-bottom: 0rem;">
                            <colgroup>
                                <col class="wps_10">
                                <col class="">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th class="text-left">제목</th>
                                    <td class="text-left"><input type="text" id="push_title" name="push_title" class="wps_50"></td>
                                </tr>
                                <tr>
                                    <th class="text-left">내용</th>
                                    <td class="text-left"><input type="text" id="push_message" name="push_message" class="wps_100"></td>
                                </tr>
                                <tr>
                                    <th class="text-left">이미지URL</th>
                                    <td class="text-left"><input type="text" id="push_imgurl" name="push_imgurl" class="wps_100"></td>
                                </tr>
                                <tr>
                                    <th class="text-left">링크</th>
                                    <td class="text-left"><input type="text" id="push_link" name="push_link" class="wps_100" placeholder="도메인 뒤 경로를 적어주세요. ex)help/guide/interview"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><input type="submit" value="전송" class="btn btn-success float-right"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>

                <!-- /.card-body -->
            </div>

        </div>
    </div>
</div>
<!-- /.row -->



<script>
    //checkbox all checked
    $('#chk_all').on('click', function() {
        if ($("#chk_all").is(":checked")) $("input[name=chk_list]").prop("checked", true);
        else $("input[name=chk_list]").prop("checked", false);
    });

    //전송할 데이터 선택
    $('.arrow-next').on('click', function() {
        let htmlData = '';
        let send_data = '';
        let bar = ',';
        $("input[name=chk_list]:checked").each(function(i) {
            let mem_id = $('#id_' + $(this).val()).val();
            htmlData += `<tr><td class='text-left'>${mem_id}</td></tr>`;
            if ($('input[name=chk_list]:checked').length - 1 == i) {
                bar = '';
            }
            send_data += "'" + mem_id + "'" + bar;
        });
        $("#senddatalist").children().remove();
        $('#senddatalist').append(htmlData);

        $('#send_data').val(send_data);
    });
</script>