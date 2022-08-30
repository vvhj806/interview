<div class="t1">
    <div class="content_title">
        <h3>메뉴 추가</h3>
        <?= csrf_field() ?>
    </div>

    <div style="display: flex;">
        <div>
            <div style="margin-bottom:20px">
                <input type="text" name="depth1Name" id="depth1Name" value="" placeholder="depth1 메뉴 추가"><a href="javascript:getAjax('depth1','create')" class="btn btn01" style="margin-right:10px">추가</a>
            </div>
            <div style="margin-bottom:15px; display:none">
                현재 선택된 depth1 메뉴 [<span id="depth1_txt"></span>] (<span id="depth1_idx"></span>)
            </div>
            <div>
                <?php foreach ($data['menuList'] as $key => $val) : ?>
                    <div style="display: flex" id="depth1_<?= $key ?>">
                        <?php foreach ($val as $key2 => $val2) : ?>
                            <?php if ($key2 == 0) : ?>
                                <div style="margin-right:5px; ">
                                    <a href="javascript:menuList(<?= $val2['menu_depth_1'] ?>,'<?= $val2['menu_depth_txt'] ?>',<?= $val2["idx"] ?>)">
                                        <h2><input type="text" value="<?= $val2['menu_depth_txt'] ?>" id="depth_<?= $val2["idx"] ?>" style="cursor:pointer" readonly></h2>
                                    </a>
                                </div>
                                <div style="margin-right:5px; ">
                                    <a href="javascript:void(0)">
                                        <h2><input type="number" value="<?= $val2['menu_priority'] ?>" id="priority_<?= $val2["idx"] ?>" style="width: 50px;text-align: center;cursor:pointer" readonly></h2>
                                    </a>
                                </div>
                                <div style="margin-right:5px">
                                    <a href="javascript:menuModify('<?= $val2["idx"] ?>','depth1')" class="btn btn01" style="padding: 0 10px;"><i class="fas fa-edit"></i></a>
                                </div>
                                <div style="margin-right:5px">
                                    <a href="javascript:getAjax('depth1','delete',<?= $val2["idx"] ?>)" class="btn btn01" style="padding: 0 10px;"><i class="fas fa-plus make-x"></i></a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div>
            <div style="margin-bottom:20px">
                <input type="text" name="depth2Name" id="depth2Name" value="" placeholder="depth2 메뉴 추가"><a href="javascript:getAjax('depth2', 'create')" class="btn btn01" style="margin-right:10px">추가</a>
            </div>
            <div style="margin-bottom:15px; display:none">
                현재 선택된 depth2 메뉴 [<span id="depth2_txt"></span>] (<span id="depth2_idx"></span>)
            </div>
            <div id="depth2">
                depth1를 선택해주세요.
            </div>
        </div>

        <!-- <div>
            <div style="margin-bottom:20px">
                <input type="text" name="linkAdd" id="linkAdd" value="" placeholder="메뉴 링크 추가"><a href="javascript:getAjax('link','create')" class="btn btn01" style="margin-right:10px">추가</a>
            </div>
            <div style="margin-bottom:15px">
                현재 선택된 메뉴의 링크
            </div>
            <div id="linkTxt">
                link 출력
            </div>
        </div> -->


    </div>

</div>

<script>
    let getMenu = <?php echo json_encode($data['menuList']) ?>;
    const emlCsrf = $("input[name='csrf_highbuff']");
    let checkModify = true;

    function menuList(depth1, txt, idx) {
        $('#depth1_txt').text(txt);
        $('#depth1_idx').text(idx);
        
        $('#depth2').empty();
        for (i = 0; i < getMenu.length; i++) {
            for (j = 0; j < getMenu[i].length; j++) {

                if(idx == getMenu[i][j]['idx']){
                    $('#depth_' + idx).css('border', '1px solid #505bf0');
                } else {
                    $('#depth_' + getMenu[i][j]['idx']).css('border', '1px solid #ddd');
                }

                if (j != 0) {
                    if (getMenu[i][j]['menu_depth_1'] == depth1) {
                        $('#depth2').append(
                            `<div style="display:flex" id="depth2_${j}"><div style="margin-right:5px; "><a href="javascript:void(0)"><h2><input type="text" value="${getMenu[i][j]['menu_depth_txt']}" id="depth_${getMenu[i][j]['idx']}" style="cursor:pointer" readonly></h2></a></div>

                            <div style="margin-right:5px; ">
                                <a href="javascript:void(0)"><h2><input type="text" value="${getMenu[i][j]['menu_link']}" id="link_${getMenu[i][j]['idx']}" style="cursor:pointer" readonly></h2></a>
                            </div>
                            <div style="margin-right:5px ; ">
                                    <a href="javascript:void(0)">
                                        <h2><input type="number" value="${getMenu[i][j]['menu_priority']}" id="priority_${getMenu[i][j]['idx']}" style="width: 50px;text-align: center; cursor:pointer" readonly></h2>
                                    </a>
                                </div>
                            <div style="margin-right:5px">
                                <a href="javascript:menuModify(${getMenu[i][j]['idx']},'depth2')" class="btn btn01" style="padding: 0 10px;"><i class="fas fa-edit"></i></a>
                            </div>
                            <div style="margin-right:5px">
                                <a href="javascript:getAjax('depth2','delete',${getMenu[i][j]['idx']})" class="btn btn01" style="padding: 0 10px;"><i class="fas fa-plus make-x"></i></a>
                            </div>
                            </div>`

                        );
                    }
                }
            }
        }
    }

    function menuModify(idx, check) {
        if (checkModify) {
            if (!confirm('수정하시겠습니까?')) {
                return;
            }
            for (i = 0; i < getMenu.length; i++) {
                for (j = 0; j < getMenu[i].length; j++) {
                    if (getMenu[i][j]['idx'] == idx) {
                        $('#depth_' + idx).attr('readonly', false);
                        $('#link_' + idx).attr('readonly', false);
                        $('#priority_' + idx).attr('readonly', false);
                        
                        
                        $('#depth_' + idx).css('cursor', '');
                        $('#link_' + idx).css('cursor', '');
                        $('#priority_' + idx).css('cursor', '');
                        if (check == 'depth1') {
                            $('#depth1_' + i).append(
                                `<div style="margin-right:15px" id="div_${getMenu[i][j]['idx']}"><a href="javascript:getAjax('${check}','modify',${getMenu[i][j]['idx']})" class="btn btn01"style="padding: 0 10px;" ><i class="fas fa-check"></i></a></div>`
                            )
                        } else if (check == 'depth2') {
                            $('#depth2_' + j).append(
                                `<div id="div_${getMenu[i][j]['idx']}"><a href="javascript:getAjax('${check}','modify',${getMenu[i][j]['idx']})" class="btn btn01"style="padding: 0 10px;" ><i class="fas fa-check"></i></a></div>`
                            )
                        }

                    }
                }
            }
            checkModify = false;
        } else {
            if (!confirm('수정을 취소하시겠습니까?')) {
                return;
            }
            for (i = 0; i < getMenu.length; i++) {
                for (j = 0; j < getMenu[i].length; j++) {
                    if (getMenu[i][j]['idx'] == idx) {
                        $('#depth_' + idx).attr('readonly', true);
                        $('#link_' + idx).attr('readonly', true);
                        $('#priority_' + idx).attr('readonly', true);

                        $('#depth_' + idx).css('cursor', 'pointer');
                        $('#link_' + idx).css('cursor', 'pointer');
                        $('#priority_' + idx).css('cursor', 'pointer');

                        $('#div_' + idx).remove();
                        // if (check == 'depth1') {
                        //     $('#depth1_' + i).append(
                        //         `<div style="margin-right:15px"><a href="javascript:getAjax('${check}','modify',${getMenu[i][j]['idx']})" class="btn btn01"style="padding: 0 10px;" ><i class="fas fa-check"></i></a></div>`
                        //     )
                        // } else if (check == 'depth2') {
                        //     $('#depth2_' + j).append(
                        //         `<div><a href="javascript:getAjax('${check}','modify',${getMenu[i][j]['idx']})" class="btn btn01"style="padding: 0 10px;" ><i class="fas fa-check"></i></a></div>`
                        //     )
                        // }

                    }
                }
            }
            checkModify = true;
        }


    }

    // function linkList(idx, txt) {
    //     $('#depth2_txt').text(txt);
    //     $('#depth2_idx').text(idx);
    //     $('#linkTxt').empty();
    //     for (i = 0; i < getMenu.length; i++) {
    //         for (j = 0; j < getMenu[i].length; j++) {
    //             if (j != 0) {
    //                 if (getMenu[i][j]['idx'] == idx) {
    //                     $('#linkTxt').append(
    //                         `<div style="display:flex" id="linkList_${j}"><div><a href="javascript:void(0)"><h2><input type="text" value="${getMenu[i][j]['menu_link']}" id="link_${getMenu[i][j]['idx']}" readonly></h2></a></div>
    //                         <div>
    //                             <a href="javascript:linkModify('${getMenu[i][j]['idx']}')" class="btn btn01" style="padding: 0 10px;" ><i class="fas fa-edit"></i></a>
    //                         </div>
    //                         </div>`
    //                     );
    //                 }
    //             }
    //         }
    //     }
    // }

    // function linkModify(link) {
    //     if (!confirm('수정하시겠습니까?')) {
    //         return;
    //     }

    //     for (i = 0; i < getMenu.length; i++) {
    //         for (j = 0; j < getMenu[i].length; j++) {
    //             if (getMenu[i][j]['idx'] == link) {
    //                 $('#link_' + getMenu[i][j]['idx']).attr('readonly', false);
    //                 $('#linkList_' + j).append(
    //                     `<div><a href="javascript:getAjax('link','modify',${getMenu[i][j]['idx']})" class="btn btn01"style="padding: 0 10px;" ><i class="fas fa-check"></i></a></div>`
    //                 )
    //             }
    //         }
    //     }
    // }

    function getAjax(dstnc, crud, idx = null) { //link, depth1, depth2 구분해서 ajax 돌리기, 삭제인지 수정인지 구분, idx로 수정
        let ajaxUrl = `/api/admin/menu/${crud}`;
        let ajaxData = {
            '<?= csrf_token() ?>': emlCsrf.val()
        }

        if (crud == 'create') {
            if (!confirm('정말로 추가 하시겠습니까?')) {
                return;
            }
            if (dstnc == 'depth1') { // 큰 메뉴 추가
                ajaxData['menuTxt'] = $('#depth1Name').val();
            } else if (dstnc == 'depth2') { // 세부 메뉴 추가
                if ($('#depth1_idx').text() == '' || $('#depth1_idx').text() == null) {
                    alert('depth1를 선택해주세요.');
                    return;
                }
                ajaxData['menuIdx'] = $('#depth1_idx').text();
                ajaxData['menuTxt'] = $('#depth2Name').val();
            }

            ajaxData['dstnc'] = dstnc;
            console.log(ajaxData);

        } else if (crud == 'modify') {
            if (!confirm('정말로 변경 하시겠습니까?')) {
                return;
            }
            if (idx == null) {
                alert('잘못된 접근입니다.')
                return;
            }

            ajaxData['linkTxt'] = "";
            if (dstnc != 'depth1') {
                ajaxData['linkTxt'] = $('#link_' + idx).val();
            }

            ajaxData['menuPriority'] = $('#priority_' + idx).val();
            ajaxData['menuIdx'] = idx;
            ajaxData['menuTxt'] = $('#depth_' + idx).val();

            console.log(ajaxData);

        } else if (crud == 'delete') {
            let alertTxt = '정말로 삭제 하시겠습니까?';

            if (idx == null) {
                alert('잘못된 접근입니다.')
                return;
            }

            if (dstnc == 'depth1') {
                alertTxt = '정말로 삭제 하시겠습니까? \n*하위 메뉴까지 전부 삭제 상태가 됩니다.';
            }

            if (!confirm(alertTxt)) {
                return;
            }

            ajaxData['menuIdx'] = idx;
            ajaxData['dstnc'] = dstnc;

            console.log(ajaxData);
        }

        // return;
        $.ajax({
            url: ajaxUrl,
            type: 'post',
            dataType: "json",
            data: ajaxData,
            success: function(res) {
                emlCsrf.val(res.code.token);

                if (crud == 'create') {

                } else if (crud == 'update') {
                    // exParam2.addClass('make-x');
                } else if (crud == 'delete') {}
                alert(res.messages);
                location.reload();
            },
            error: function(e) {
                console.log(e);
                alert(e.responseJSON.messages);
                // location.reload();
            },
        });

    }


    function categoryAjax(crud, exParam1 = null, exParam2 = null) {
        let ajaxUrl = `/api/category/${crud}/${categoryIdx}`;
        let ajaxObjData = {
            '<?= csrf_token() ?>': emlCsrf.val()
        };
        if (crud == 'create') {
            if (!confirm('정말로 추가 하시겠습니까?')) {
                return;
            }

            ajaxUrl = `/api/category/${crud}/${exParam1}`;

            ajaxObjData['jobText'] = exParam2;
            ajaxObjData['depth1'] = nowDpeth1;
            ajaxObjData['depth2'] = nowDpeth2;
        } else if (crud == 'update') {
            if (!confirm('정말로 변경 하시겠습니까? 변경시 자동으로 open상태가 됩니다.')) {
                return;
            }
            ajaxObjData['jobText'] = exParam1;
        } else if (crud == 'delete') {
            if (!confirm('정말로 close 하시겠습니까? \n*하위 카테고리, 질문까지 전부 close상태가 됩니다.')) {
                return;
            }
        }
        if (flag) {
            flag = false;
            $.ajax({
                url: ajaxUrl,
                type: 'post',
                dataType: "json",
                cache: false,
                async: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: ajaxObjData,
                success: function(res) {
                    flag = true;
                    emlCsrf.val(res.code.token);

                    if (crud == 'create') {

                    } else if (crud == 'update') {
                        // exParam2.addClass('make-x');
                    } else if (crud == 'delete') {}
                    alert(res.messages);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                }
            });
        }
    }
</script>

<style>
    input::-webkit-inner-spin-button {
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
    }
</style>