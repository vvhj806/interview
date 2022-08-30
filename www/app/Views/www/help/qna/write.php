<!--s #scontent-->
<div id="scontent">
    <!--s top_tltBox-->
    <div class="top_tltBox c">
        <!--s top_tltcont-->
        <div class="top_tltcont">
            <a href="javascript:" onclick="fnShowPop('mypage_inquiry_close_pop')">
                <div class="backBtn"><span>뒤로가기</span></div>
            </a>
            <div class="tlt">새 문의 작성하기</div>
        </div>
        <!--e top_tltcont-->
    </div>
    <!--e top_tltBox-->

    <!--s contBox-->
    <div class="cont">
        <form id='frm' method='post' action='write/action' enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input id='input_file1' type="file" name='file1' class='hide' accept='.image/.jpeg,.png,.jpg'>
            <input id='input_file2' type="file" name='file2' class='hide' accept='.image/.jpeg,.png,.jpg'>
            <input id='input_file3' type="file" name='file3' class='hide' accept='.image/.jpeg,.png,.jpg'>
            <input id='input_file4' type="file" name='file4' class='hide' accept='.image/.jpeg,.png,.jpg'>
            <div class="stlt">어떤 점이 궁금하신가요?</div>
            <input type='text' name='title' class='qnaInput' placeholder='제목을 입력해 주세요.'>
            <textarea type='text' name="question" class="ht_40 qnaInput" placeholder="문의하실 내용을 입력해 주세요"></textarea>

            <div class="stlt mg_t50">사진 첨부 <span class="point">*선택</span></div>

            <!--s pic_fileBox-->
            <div class="pic_fileBox">

                <!--s pic_file-->
                <div class="pic_file">
                    <label id='addImg' for='input_file1'>
                        <!--s pic_file_cont-->
                        <div class="pic_file_cont">
                            <!--s pic_file_plus_iconBox-->
                            <div class="pic_file_plus_iconBox">
                                <div class="pic_file_plus_icon"><img src="/static/www/img/sub/pic_file_plus_icon.png"></div>
                                <p>최대 4장</p>
                            </div>
                            <!--sepic_file_plus_iconBox-->
                        </div>
                        <!--e pic_file_cont-->
                    </label>
                </div>
                <!--e pic_file-->
                <span class='mini_fileBox'>

                </span>
            </div>
            <!--e pic_fileBox-->

            <!--s fix_btBox-->
            <div class="fix_btBox fix_btBtn2">
                <div class="fix_btBtn">
                    <div class="gray_txt c ">확인 후 빠른 시일 내에 답변해드릴게요! (평균 2일 소요) </div>

                    <a href="javascript:" class="fix_btn01 fix_btn01_gray2 wps_100">문의 등록하기</a>
                    <!--s fix_btn01_gray2 빼면 on 됩니다.-->
                </div>
            </div>
            <!--e fix_btBox-->
        </form>
    </div>
    <!--e contBox-->
</div>
<!--e #scontent-->

<!--s 글쓰기닫기 모달-->
<div id="mypage_inquiry_close_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="txt mg_b0">
                작성하신 내용이 사라집니다!<br />
                문의 등록을 취소하시겠어요?
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <a href="javascript:" class="spop_btn01" onclick="fnHidePop('mypage_inquiry_close_pop')">더 쓸래요</a>
            <a href="/help/qna" class="spop_btn02">네</a>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 글쓰기닫기 모달-->

<!--s 글쓰기 모달-->
<div id="mypage_inquiry_write_pop" class="pop_modal2">
    <!--s pop_Box-->
    <div class="spop_Box c">
        <!--s pop_cont-->
        <div class="spop_cont">
            <div class="txt mg_b0">
                문의를 등록하시겠어요?
            </div>
        </div>
        <!--e pop_cont-->

        <!--s spopBtn-->
        <div class="spopBtn radius_none">
            <a href="javascript:" class="spop_btn01" onclick="fnHidePop('mypage_inquiry_write_pop')">더 쓸래요</a>
            <a href="javascript:" class="spop_btn02" onclick="$('#frm').submit()">네</a>
        </div>
        <!--e spopBtn-->
    </div>
    <!--e pop_Box-->
</div>
<!--s 글쓰기 모달-->

<script>
    $("#frm").validate({
        ignore: [],
        rules: {
            title: {
                required: true,
            },
            question: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "제목은 필수 입력입니다.",
            },
            question: {
                required: "질문은 필수 입력입니다.",
            },
        },
        submitHandler: function(form) {
            // form 전송 이외에 ajax등 어떤 동작이 필요할 때
            form.submit();
        }
    });

    function item(img, index) {
        let item =
            `<div class="pic_file">
            <div class="pic_file_close" data-idx="${index}"><img src="/static/www/img/sub/list_close.png"></div>
            <div class="pic_file_cont">
                <div class="img"><img src="${img}"></div>
            </div>
        </div>`;
        return item;
    }

    function setImageFromFile(input, id) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('.mini_fileBox').append(item(e.target.result, id));
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $('.fix_btn01').on('click', function() {
            if ($(this).hasClass('fix_btn01_gray2')) {
                $('#frm').submit();
            } else {
                fnShowPop('mypage_inquiry_write_pop');
            }
        });

        $('.qnaInput').on('change', function() {
            $('.fix_btn01').removeClass('fix_btn01_gray2');

            $('.qnaInput').each(function() {
                if (!$(this).val()) {
                    return $('.fix_btn01').addClass('fix_btn01_gray2');
                }
            });
        });

        //첨부파일
        $('#addImg').on('click', function() {
            if ($('.pic_file_close').length >= 4) {
                alert('최대 4개만 선택 가능합니다.');
                return false;
            }
            const _this = $(this);
            $('input[type = "file"]').each(function() {
                if (!$(this).val()) {
                    _this.attr('for', $(this).attr('id'));
                }
            });
        });

        $('input[type="file"]').on('change', function(e) {
            setImageFromFile(this, $(this).attr('id'));
        });

        $(document).on('click', '.pic_file_close', function() { // 삭제
            const _this = $(this);
            _this.closest('.pic_file').remove();
            const id = _this.data('idx');
            $(`#${id}`).val("");
        })
    });
</script>