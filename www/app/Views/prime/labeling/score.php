<div class="row">
    <div class="col-12">
        <!-- general form elements disabled -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">채점</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div style='display:none'>
                    <?php foreach ($data['label'] as $key => $val) : ?>
                        <input class='hide' name='labels' value='<?= $key ?>' data-kor='<?= $val['name'] ?>'>
                    <?php endforeach; ?>

                    <?php foreach ($data['labelTotal'] as $key => $val) : ?>
                        <input class='hide' name='labels_total' value='<?= $key ?>' data-kor='<?= $val['name'] ?>'>
                    <?php endforeach; ?>
                </div>

                <div class="box">
                    <form method="post" id="frm" action="/prime/labeling/action/<?= $data['appIdx'] ?>">
                        <?= csrf_field() ?>
                        <button id='test' type='submit'>저장</button>
                        <button type='button' class='red_label' value='0' data-idx="0">전체 분석불가</button>
                        <?php foreach ($data['list'] as $key => $row) : ?>

                            <?php if ($row['que_type'] === 'S') : ?>

                                <input class='hide' type='checkbox' name='repo_result_idx[]' value='<?= $row['repo_idx'] ?>' checked style='display:none'>

                                <input class='speech hide' value='<?= $row['repo_speech_txt_detail'] ?>' data-repo-idx='<?= $row['repo_idx'] ?>'>

                                <div class='stt'><button type='button' value='<?= $row['repo_idx'] ?>'>CC</button>
                                    <?= $row['sttLog'] ? "STT 교정 됨: {$row['memId']}" : '교정 안됨' ?></div>

                                <div class='tap'>
                                    <div class='tap_left'>
                                        <div style="padding: 0.5rem">
                                            <?= $key + 1 ?> | <?= $row['repo_idx'] ?> | <?= $row['que_question'] ?>
                                        </div>

                                        <div>
                                            <button type='button' class='red_label' value='0' data-idx="<?= $row['repo_idx'] ?>">분석 불가</button>
                                        </div>
                                        <div>
                                            <button type='button' class='red_label' value='5' data-idx="<?= $row['repo_idx'] ?>">5점</button>
                                        </div>
                                        <div class='custom_box'>
                                            <select class='custom_option'>
                                                <?php for ($i = 1; $i <= 10; $i++) : ?>
                                                    <option value="<?= $i ?>"><?= $i ?>점</option>
                                                <?php endfor; ?>
                                            </select>
                                            <button type='button' class='red_label' data-idx="<?= $row['repo_idx'] ?>">적용</button>
                                        </div>
                                        <video controls playsinline src="<?= "{$data['url']['media']}{$data['videoPath']}{$row['video_record']}" ?>"></video>
                                    </div>

                                    <div class='tap_right' data-repo-num='<?= $key ?>'>
                                        <?php foreach ($data['label'] as $k => $val) : ?>

                                            <div class='link link2'>
                                                <div><?= $val['name'] ?>(적음 → 많음) </div>
                                                <div>

                                                    <?php for ($i = 0; $i <= 10; $i++) : ?>

                                                        <input id='<?= "{$row['repo_idx']}$k$i" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $k ?>]" value='<?= $i ?>' <?= "$i" === ($row['repo_score'][$k] ?? false) ? 'checked' : '' ?>>
                                                        <label for='<?= "{$row['repo_idx']}$k$i" ?>'>
                                                            <?= $i == 0 ? '분석불가' : $i ?>
                                                            <div class='label_text'></div>
                                                        </label>

                                                    <?php endfor; ?>

                                                </div>
                                            </div>

                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if (count($data['list']) - 1 != $key + 1) : ?>
                                    <button type='button' class='bottom_btn' data-repo-next-idx="<?= $data['list'][$key + 1]['repo_idx'] ?>" data-repo-now-idx="<?= $row['repo_idx'] ?>">↓ 점수 적용 ↓</button>
                                <?php endif; ?>

                            <?php elseif ($row['que_type'] === 'T') : ?>

                                <input class='hide' type='checkbox' name='repo_result_idx_total' value='<?= $row['repo_idx'] ?>' checked>
                                <div class='total'>
                                    <div><button type='button' class='red_label' value='0' data-idx="<?= $row['repo_idx'] ?>">분석 불가</button></div>
                                    <?php foreach ($data['labelTotal'] as $key => $val) : ?>
                                        <div class='link'>

                                            <div><?= $val['name'] ?>(<?= $data['type'][$val['type']] ?>)</div>
                                            <div>
                                                <?php if ($key === 'gender') : ?>
                                                    <input id='<?= "{$key}0" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='0' <?= "0" === ($row['repo_score'][$key] ?? false) ? 'checked' : '' ?>>
                                                    <label for='<?= "{$key}0" ?>'>
                                                        분석불가
                                                    </label>
                                                    <input id='<?= "{$key}1" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='male' <?= (($row['repo_score'][$key][0] ?? false) > ($row['repo_score'][$key][1] ?? false)) ? 'checked' : '' ?>>
                                                    <label for='<?= "{$key}1" ?>'>
                                                        남성
                                                    </label>
                                                    <input id='<?= "{$key}2" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='female' <?= (($row['repo_score'][$key][0] ?? false) < ($row['repo_score'][$key][1] ?? false)) ? 'checked' : '' ?>>
                                                    <label for='<?= "{$key}2" ?>'>
                                                        여성
                                                    </label>
                                                <?php elseif ($key === 'age') : ?>
                                                    <?php for ($i = 0; $i <= 7; $i++) : ?>
                                                        <input id='<?= "$key$i" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='<?= $i * 10 ?>' <?= "$i" === ($row['repo_score'][$key] ?? false) ? 'checked' : '' ?>>
                                                        <label for='<?= "$key$i" ?>'>
                                                            <?= $i == 0 ? '분석불가' : $i * 10 ?>
                                                        </label>
                                                    <?php endfor; ?>
                                                <?php elseif ($key === 'glasses') : ?>
                                                    <input id='<?= "{$key}0" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='0' <?= "0" === ($row['repo_score'][$key] ?? false) ? 'checked' : '' ?>>
                                                    <label for='<?= "{$key}0" ?>'>
                                                        분석불가
                                                    </label>
                                                    <input id='<?= "{$key}1" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='false' <?= 'false' == ($row['repo_score'][$key] ?? false) ? 'checked' : '' ?>>
                                                    <label for='<?= "{$key}1" ?>'>
                                                        미착용
                                                    </label>
                                                    <input id='<?= "{$key}2" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='true' <?= 'true' == ($row['repo_score'][$key] ?? false) ? 'checked' : '' ?>>
                                                    <label for='<?= "{$key}2" ?>'>
                                                        착용
                                                    </label>
                                                <?php else : ?>
                                                    <?php for ($i = 0; $i <= 10; $i++) : ?>
                                                        <input id='<?= "$key$i" ?>' class='hide' type='radio' name="<?= $row['repo_idx'] ?>[<?= $key ?>]" value='<?= $i ?>' <?= "$i" === ($row['repo_score'][$key] ?? false) ? 'checked' : '' ?>>
                                                        <label for='<?= "$key$i" ?>'>
                                                            <?= $i == 0 ? '분석불가' : $i ?>
                                                            <div class='label_text'></div>
                                                        </label>
                                                    <?php endfor; ?>
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        <button id='test' type='submit'>저장</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="q_topBtn">
    <a href="javascript:void(0)">
        <i class="la la-angle-up"></i>
        <br />
        TOP
    </a>
</div>

<div id='tip' class='pop_modal'>
    <div class='pop_full2'>
        <div class='pop_con'>
            <div><button onclick="$('#tip').removeClass('on')">닫기</button></div>
            <ul>
            </ul>
        </div>
    </div>
</div>

<!-- 텍스트 교정 팝업 -->
<div id='speech' class='pop_modal'>
    <div class='pop_full2'>
        <div class='pop_con'>
            <div>
                <div><button onclick="$('#speech').removeClass('on')">닫기</button> *색깔있는 문장은 감정점수가 있는 문장</div>
                <div class='reportIdx'></div>
                <div id='speechBox' style="display:flex;flex-wrap: wrap; "></div>
                <button id='stt_save' type='button'>저장</button>
            </div>
        </div>
    </div>
</div>

<!-- 감정 교정 팝업 -->
<div id='emotion' class='pop_modal'>
    <div class='pop_full2'>
        <div class='pop_con'>
            <div>
                <div><button onclick="$('#emotion').removeClass('on')">닫기</button> 최소 점수: -2, 최고 점수: 2 </div>
                <div class='reportIdx'></div>
                <div id='emotionBox' style="display:flex;flex-wrap: wrap; "></div>
                <button id='emotion_save' type='button'>저장</button>
            </div>
        </div>
    </div>
</div>

<script>
    let aRepoIdx = [];
    let iRepoIdxTotal = [];
    let aLables = [];
    let aLablesKor = [];
    let aLableTotals = [];
    let aLableTotalsKor = [];
    let objSpeech = {};
    let objSpeechAfter = {};
    let ajaxFlag = true;
    const emlCsrf = $("input[name='csrf_highbuff']");
    const objDes = {
        'beard': ["육안으로 깨끗하고 여성처럼 수염이 없을때",
            "입꼬리 부분에 약간 검은표가 보일 때 ",
            "남성 하루정도 면도를 하지 않았을 때(중)",
            "남성 하루정도 면도를 하지 않았을 때(상)",
            "수염길이 0.5cm이상(중)",
            "수염길이 0.5cm이상(상)",
            "수염길이 2Cm이상(중)",
            "수염길이 2Cm이상(상)",
            "수염길이 5Cm이상",
            "수염길이 10cm이상 예)산신령급"
        ],
        'blink': ["눈 깜빡임이 없다",
            "눈 깜빡임이  1~2회 정도",
            "눈 깜빡임이 3~4회 정도",
            "눈 깜빡임이 4~6회 정도(중)",
            "눈 깜빡임이 4~6회 정도(상)",
            "눈 깜빡임이 6~8회 정도(중)",
            "눈 깜빡임이 6~8회 정도(상)",
            "눈 깜빡임이 8~12회 정도(중)",
            "눈 깜빡임이 8~12회 정도(상)",
            "눈을 계속 깜빡인다"
        ],
        'dialect': ["완벽한 표준어 구사 예) KBS 아나운서 수준",
            "방언을 사용하지 않고 억양이 표준어에 가까움 예) 현대 서울말",
            "방언을 사용하지 않고 억약을 표준어처럼 하기위해 노력함(상)",
            "방언을 사용하지 않고 억약을 표준어처럼 하기위해 노력함(중)",
            "방언을 사용하지 않지만 억양에서 사투리가 약간 느껴짐(중) <a href='asd'> 예) 000 월00일 000 면접자 영상 참고</a>",
            "방언을 사용하지 않지만 억양에서 사투리가 약간 느껴짐(상)",
            "방언을 조금 사용하고 억양에서 사투리가 느껴짐",
            "방언을 사용하고 억양에서 사투리가 확 느껴짐(중)",
            "방언을 사용하고 억양에서 사투리가 확 느껴짐(상)",
            "의미를 알수 없을 만큼의 사투리 구사 예) 무신 거예 고람 신디 몰르쿠게 ?",
        ],
        'diction': ["얼굴은 보이나 소리가 들리지 않는다(상)",
            "얼굴은 보이나 소리가 들리지 않는다(중)",
            "얼굴은 보이나 소리가 조용하게 들리는 경우 예)가느다란 목소리\t",
            "발음을 할 때 알아들을 수 있는 수준(하)",
            "발음을 할 때 알아들을 수 있는 수준(중)",
            "발음을 정확하게 하면서 가끔 더듬는다(상)",
            "발음을 정확하게 하면서 가끔 더듬는다(중)",
            "발음을 정확하게 하면서 한 번씩 발음이 새나가는 경우",
            "발음은 정확하지만 아나운서처럼 맑은 소리가 나지 않는 수준",
            "아나운서 수준",
        ],
        'eyes': ["시선을 다른곳(옆,위,아래)을 계속 보고 답변하는 경우(상) 예)주위산만\t",
            "시선을 다른곳(옆,위,아래)을 계속 보고 답변하는 경우(중)",
            "시선을 다른 곳을 쳐다보다 한 번씩 정면을 보는 경우(상)",
            "시선을 다른 곳을 쳐다보다 한 번씩 정면을 보는 경우(중)",
            "정면을 쳐다보다 서너번 눈동자가 옆으로 움직이는 경우(중)",
            "정면을 쳐다보다 서너번 눈동자가 옆으로 움직이는 경우(상)",
            "정면을 쳐다 보다 한 두번 눈동자가 옆으로 움직이는 경우(중)",
            "정면을 쳐다 보다 한 두번 눈동자가 옆으로 움직이는 경우(상)",
            "처음부터 끝까지 정면을 주시하며 답변하는 경우(중)",
            "처음부터 끝까지 정면을 주시하며 답변하는 경우(상)",
        ],
        'foreign': ["외국어를 전혀 사용하지 않는다",
            "외국어를 한 단어 정도 사용한다(중)",
            "외국어를 한 단어 정도 사용한다(상)",
            "외국어를 두 단어 정도 사용한다",
            "외국어 단어가 3~4가지 사용한다",
            "외국어를 5~6가지 정도 사용한다(중)",
            "외국어를 5~6가지 정도 사용한다(상)",
            "외국어를 70~80% 사용한다(중)",
            "외국어를 70~80% 사용한다(상)",
            "한국말이 가끔 나오는 수준",
        ],
        'gesture': ["굳은 자세로 움직임이 보이지 않는다(상)",
            "굳은 자세로 움직임이 보이지 않는다(중)",
            "몸은 약간씩 움직이나 손동작과 머리는 움직이지 않는다(상)",
            "몸은 약간씩 움직이나 손동작과 머리는 움직이지 않는다(중)",
            "가끔씩 몸과 손동작을 곁드려 가면서 설명한다(중)",
            "가끔씩 몸과 손동작을 곁드려 가면서 설명한다(상)",
            "몸과 손동작과 머리를 자주 움직인다.(중)",
            "몸과 손동작과 머리를 자주 움직인다.(상)",
            "지속적으로 머리와 손동작을 곁드려 몸을 움직이며 적극적으로 표현한다(중)",
            "지속적으로 머리와 손동작을 곁드려 몸을 움직이며 적극적으로 표현한다(상)",
        ],
        'glow': ["아주 자연스럽고 밝은 표정을 유지한다(상)",
            "아주 자연스럽고 밝은 표정을 유지한다(중)",
            "표정이 약간 굳어있다(상)",
            "표정이 약간 굳어있다(중)",
            "표정은 자연스러우나 약간 더듬거린다(중)",
            "표정은 자연스러우나 약간 더듬거린다(상)",
            "표정이 굳어 있고 말을 더듬거린다(중)",
            "표정이 굳어 있고 말을 더듬거린다(상)",
            "표정이 굳어 있고 말을 더듬거리고 침을 삼킨다(중)",
            "표정이 굳어 있고 말을 더듬거리고 침을 삼킨다(상)",
        ],
        'hair_length': ["머리카락이 없거나 아주 짧은 머리 예)(남자빡빡이)",
            "머리카락이 짧은것 보다 약간 긴 머리",
            "머리카락이 귀 위부분까지 내려온다",
            "머리카락이 귓볼까지 내려온다",
            "머리카락이 목부위 중간까지 내려온다(중)",
            "머리카락이 목부위 중간까지 내려온다(상)",
            "머리카락이 어깨선까지 내려온다(중)",
            "머리카락이 어깨선까지 내려온다(상)",
            "머리카락이 어깨선 이상까지 내려온다(중)",
            "머리카락이 어깨선 이상까지 내려온다(상)",
        ],
        'head_motion': ["움직임이 전혀 없이 정면만 주시한다",
            "움직임이 2~3회정도 움직인다(중)",
            "움직임이 2~3회정도 움직인다(상)",
            "움직임이 3~4정도 움직인다(하)",
            "움직임이 3~4정도 움직인다(중)",
            "움직임이 3~4정도 움직인다(상)",
            "움직임이 6~7회정도 움직인다(중)",
            "움직임이 6~7회정도 움직인다(상)",
            "처음부터 끝까지 도리도리 수준(중) 예)윤석열후보 수준",
            "처음부터 끝까지 도리도리 수준(상)",
        ],
        'mouth_motion': ["입 움직임이 없는 표정",
            "입이 약간 움직이는 표정",
            "입술이 오물거리는 정도(상)",
            "입술이 오물거리는 정도(중)",
            "약간의 치아가 보일 정도의 입모양(중)",
            "약간의 치아가 보일 정도의 입모양(상)",
            "치아가 반이상 보일 정도의 입모양(중)",
            "치아가 반이상 보일 정도의 입모양(상)",
            "치아가 완전히 보이는 정도",
            "치아가 완전히 보이고 잇몸이 보일 정도의 입모양",
        ],
        'quiver': [
            "목소리가 아주 경쾌하다",
            "목소리가 경쾌하다",
            "아주 가끔 떨림이 느껴진다",
            "가끔씩 떨림이 느껴진다(상)",
            "가끔씩 떨림이 느껴진다(중)",
            "중간 중간 떨림이 심하다(중)",
            "중간 중간 떨림이 심하다(상)",
            "처음부터 끝까지 떨림이 심하게 느껴진다(하)",
            "처음부터 끝까지 떨림이 심하게 느껴진다(중)",
            "처음부터 끝까지 떨림이 심하게 느껴진다(극심)",
        ],
        'sincerity': ["질문에 대답을 못한다",
            "질문에 소리만 약간 내는 정도",
            "질문에 이름 정도만 답변할 정도",
            "질문에 이름 나이 정도만 답변할 정도(중)",
            "질문에 이름 나이 정도만 답변할 정도(상)",
            "질문에 적절하게 답변을 하지만 20초 정도만 하고 끝낸다(중)",
            "질문에 적절하게 답변을 하지만 20초 정도만 하고 끝낸다(상)",
            "질문에 30초 가량 답변을 완벽하게 하지만 약간 아쉬움이 남는다(중)",
            "질문에 30초 가량 답변을 완벽하게 하지만 약간 아쉬움이 남는다(상)",
            "질문에 30초를 완벽하게 채우면서 답변을 마무리 한다",
        ],
        'skin': ["피부가 짙은 블랙톤이다",
            "피부가 여린 블랙톤이다",
            "피부가 갈색보다는 어두운톤이다(상)",
            "피부가 갈색보다는 어두운톤이다(중)",
            "피부가 평범한 갈색톤이다(상)",
            "피부가 평범한 갈색톤이다(중)",
            "피부가 갈색보다는 밝은톤이다(중)",
            "피부가 갈색보다는 밝은톤이다(상)",
            "피부가 화이트톤이다(중)",
            "피부가 화이트톤이다(상)",
        ],
        'smile': ["화나서 찡그린 표정",
            "무표정(상)",
            "무표정(중)",
            "편안한 표정(중)",
            "편안한 표정(상)",
            "중간중간 웃는 표정을 짓는 경우(중)",
            "중간중간 웃는 표정을 짓는 경우(상)",
            "처음부터 웃는 표정을 짓다가 중간에 무표정이 섞인 경우(중)",
            "처음부터 웃는 표정을 짓다가 중간에 무표정이 섞인 경우(상)",
            "처음부터 끝까지 웃으며 밝은 표정",
        ],
        'speed': ["상대가 듣기 힘들 정도의 답답한 말",
            "일반적인 말하는 사람보다 조금 느린말(상)",
            "일반적인 말하는 사람보다 조금 느린말(중)",
            "일반적인 사람들의 말하는 속도(하)",
            "일반적인 사람들의 말하는 속도(중)",
            "일반적인 사람들의 말하는 속도(상)",
            "일반적인 사람들의 말보다 조금 빠름(중) 예)뉴스앵커",
            "일반적인 사람들의 말보다 조금 빠름(상) 예)뉴스앵커",
            "아주 빠른말(중)",
            "아주 빠른말(상)",
        ],
        'tone': ["아주 가느다란 목소리 *여기서 남녀 기준은 평가자의 기준에서 정해져야 한다.",
            "일반적인 목소리보다 조금 가늘다(중)",
            "일반적인 목소리보다 조금 가늘다(상)",
            "일반적인 사람들의 목소리 톤(하)",
            "일반적인 사람들의 목소리 톤(중)",
            "일반적인 사람들의 목소리 톤(상)",
            "일반적인 사람들의 목소리보다 조금 굵다(중)",
            "일반적인 사람들의 목소리보다 조금 굵다(상)",
            "성악 바리톤 수준처럼 아주 굵다(중)",
            "성악 바리톤 수준처럼 아주 굵다(상)",
        ],
        'understanding': ["답변에 말을 못하고 있다",
            "답변을 못하고 10초 이상 흐른뒤 답변을 한다",
            "답변을 못하고 6~7초 이상 흐른뒤 답변을 한다(상)",
            "답변을 못하고 6~7초 이상 흐른뒤 답변을 한다(중)",
            "시간이 3초 정도 흐른뒤 답변을 한다",
            "시간이 2초 정도 흐른뒤 답변을 한다",
            "시간이 2초 정도 흐른뒤 답변을 한다",
            "시간이 1초 정도 흐른뒤 답변을 한다",
            "시작과 동시에 답변을 시작은 하나 한 번 정도 짧게 생각하며 답변한다",
            "시작과 동시에 답변을 시작하고 질문에 막힘없이 질의에 대한 내용을 상세하게 설명한다",
        ],
        'volume': ["얼굴은 보이는데  말 소리가 들리지 않는다(상)",
            "얼굴은 보이는데  말 소리가 들리지 않는다(중)",
            "말소리는 들리는데 조용하게 말한다(상)",
            "말소리는 들리는데 조용하게 말한다(중)",
            "일상적인 생활속의 대화정도(중)",
            "일상적인 생활속의 대화정도(상)",
            "일상적인 생활속의 대화정도에서 조금 더 크게 말하는 수준(하)",
            "일상적인 생활속의 대화정도에서 조금 더 크게 말하는 수준(중)",
            "일상적인 생활속의 대화정도에서 조금 더 크게 말하는 수준(상)",
            "크게 말하는 수준(웅변)",
        ]
    };
    $(document).ready(function() {
        $('.speech').each(function() {
            const value = $(this).val();
            if (value) {
                const speechJson = JSON.parse(value);
                const idx = $(this).data('repo-idx');

                objSpeech[idx] = speechJson;
            }
        });
        $('input[name="repo_result_idx[]"]').each(function() {
            aRepoIdx.push($(this).val());
        });
        iRepoIdxTotal = $('input[name="repo_result_idx_total"]').val();
        $(`input[name="labels"]`).each(function() {
            aLables.push($(this).val());
            aLablesKor.push($(this).data('kor'));
        });
        $(`input[name="labels_total"]`).each(function() {
            aLableTotals.push($(this).val());
            aLableTotalsKor.push($(this).data('kor'));
        });
        $(document).on('click', ('.scoreEmotion > button'), function() {
            const idx = $(this).parent('div').parent('div').prevAll('div.reportIdx').text();
            const emotionIdx = $(this).val();
            let objEmotion = objSpeech[idx][emotionIdx]['alternatives'][0]['words'];
            $('#emotionBox').empty();
            for (let k = 0, max = objEmotion.length; k < max; k++) {
                for (var key in objEmotion[k]) {
                    let disabled = "disabled";
                    if (key == "score") {
                        disabled = "";
                    }
                    $('#emotionBox').append(`<div data-emotion-text=${key} data-emotion-idx=${k}>${key}: <input value = '${ objEmotion[k][key]}' ${disabled}></div> `);
                }
            }
            $('#emotion_save').val(emotionIdx);
            $('#emotion').addClass('on');
            // $('#emotion').css('position', 'unset');
            $('#emotion').children('.pop_full2').draggable();
        })
    });

    $('#frm').on('submit', function(event) {
        event.preventDefault();
        for (let i = 0, max = aRepoIdx.length; i < max; i++) {
            for (let j = 0; j < aLables.length; j++) {
                if ($(`input[name= "${aRepoIdx[i]}[${aLables[j]}]"]:checked`).length == 0) {
                    alert(`${aRepoIdx[i]} [${aLablesKor[j]}] 체크해 주세요.`);
                    return false;
                }
            }
        }
        for (let i = 0, max = aLableTotals.length; i < max; i++) {
            if ($(`input[name= "${iRepoIdxTotal}[${aLableTotals[i]}]"]:checked`).length == 0) {
                alert(`${iRepoIdxTotal} [${aLableTotalsKor[i]}] 체크해 주세요.`);
                return false;
            }
        }
        this.submit();
    });
    $('.stt > button').on('click', function() { //텍스트 교정 팝업
        const idx = $(this).val();
        let style = "";
        $('#speechBox').empty();
        $('.reportIdx').text(`${idx}`);
        if (objSpeech[idx]) {
            for (let i = 0, max = objSpeech[idx].length; i < max; i++) {
                for (key in objSpeech[idx][i]['alternatives'][0]['words']) {
                    if (objSpeech[idx][i]['alternatives'][0]['words'][key]['score'] != "" && objSpeech[idx][i]['alternatives'][0]['words'][key]['score'] != null) {
                        style = "background:gold";
                        break;
                    }
                }
                $('#speechBox').append(`<div class="scoreEmotion"><input value = '${objSpeech[idx][i]['alternatives'][0]['content']}' style="${style}"><button type="button" value="${i}">감정점수</button></div>`);
                style = "";
            }
            $('#stt_save').val(idx);
            $('#speech').addClass('on');
            $('#speech').css('position', 'unset');
            $('#speech').children('.pop_full2').draggable();
            $('#speech > .pop_full2').css('top', $(this).position().top);
            $('#speech').css('left', '');
        } else {
            alert('stt 데이터가 없습니다');
        }
    });
    $('#stt_save').on('click', function() {
        const repoIdx = $(this).val();
        let jsonSend = objSpeech[repoIdx];
        $('#speechBox').find('input').each(function(idx) {
            jsonSend[idx]['alternatives'][0]['content'] = $(this).val();
        });
        if (ajaxFlag) {
            ajaxFlag = false;
            $.ajax({
                url: `/api/report/stt/update/${repoIdx}`,
                type: 'post',
                dataType: 'json',
                cache: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                    'speechAfter': JSON.stringify(jsonSend),
                    'emotionUpdate': false
                },
                success: function(res) {
                    if (res.code.stat == 'success') {
                        ajaxFlag = true;
                        emlCsrf.val(res.code.token);
                        objSpeech[repoIdx] = res.code.result;
                        alert(res.messages);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
        }
    });
    $('#emotion_save').on('click', function() {
        const reportidx = $('#emotion .reportIdx').text();
        const jsonIdx = $(this).val();
        let jsonSend = objSpeech[reportidx];
        let jsonChange = jsonSend[jsonIdx]['alternatives'][0]['words'];
        let sum = "";
        $('#emotionBox').find('input').each(function(idx) {
            let emotionKey = $(this).parent('div').data('emotion-text');
            let emotionIndex = $(this).parent('div').data('emotion-idx');
            jsonSend[jsonIdx]['alternatives'][0]['words'][emotionIndex][emotionKey] = $(this).val();
        });
        for (key in jsonChange) {
            if (jsonChange[key]['score'] != "") {
                sum += Number(jsonChange[key]['score']);
            }
        }
        if (sum != "") {
            jsonSend[jsonIdx]['alternatives'][0]['score'] = sum;
        } else {
            if (jsonSend[jsonIdx]['alternatives'][0]['score']) {
                jsonSend[jsonIdx]['alternatives'][0]['score'] = "";
            }
        }

        if (ajaxFlag) {
            ajaxFlag = false;
            $.ajax({
                url: `/api/report/stt/update/${reportidx}`,
                type: 'post',
                dataType: 'json',
                cache: false,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: {
                    '<?= csrf_token() ?>': emlCsrf.val(),
                    'speechAfter': JSON.stringify(jsonSend),
                    'emotionUpdate': true
                },
                success: function(res) {
                    if (res.code.stat == 'success') {
                        ajaxFlag = true;
                        emlCsrf.val(res.code.token);
                        objSpeech[reportidx] = res.code.result;
                        alert(res.messages);
                        $('#emotion').removeClass('on');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
        }
    });

    $('.red_label').on('click', function() {
        const redLabel = $(this);
        const idx = redLabel.data('idx');
        const point = redLabel.siblings('select').val() ? redLabel.siblings('select').val() : redLabel.val();
        checkPoint(idx, point);
    });

    $('.cur_btn').on('click', function() {
        const thisEle = $(this);
        const repoIdx = thisEle.val();
        $('#tip').addClass('on');
    });

    $('.pop_modal').on('click', function() {
        $('#tip').removeClass('on');
    });

    $('label').hover(function() {
        const ele = $(this).children('div');
        if (!ele.text()) {
            const name = $(this).prop('for').replace(/[0-9]/g, "");
            if (in_array(name, ['gender', 'age', 'glasses'])) {
                return;
            }
            const value = parseInt($(this).prev('input').val()) + -1;
            const text = objDes[name][value];
            ele.text(text);
        }
    });

    $('.q_topBtn').on('click', function(e) {
        //상단으로 이동
        $('html,body').scrollTop();
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 400, 'swing');
    });

    $('.bottom_btn').on('click', function() {
        const repoNowIdx = $(this).data('repo-now-idx');
        const repoNextIdx = $(this).data('repo-next-idx');
        let checkedIdx = [];
        
        for (i in aLables) {
            checkedIdx[aLables[i]] = $(`input[name= "${repoNowIdx}[${aLables[i]}]"]:checked`).val();
        }

        for (i in aLables) {
            $(`input[name= "${repoNextIdx}[${aLables[i]}]"]`).each(function() {
                if ($(this).val() == checkedIdx[aLables[i]]) {
                    $(this).prop('checked', true);
                }
            });
        }
    });

    function checkPoint(idx, point) {
        if (idx == 0) {
            $(`input[type = "radio"]`).each(function() {
                if ($(this).val() == point) {
                    $(this).prop('checked', true);
                }
            });
        } else {
            $(`input[name ^= "${idx}"]`).each(function() {
                if ($(this).val() == point) {
                    $(this).prop('checked', true);
                }
            });
        }
    }
</script>

<style>
    .box {
        padding: 0.5rem;
    }

    .active {
        background: red;
    }

    video {
        width: 100%;
        max-height: 400px;
    }

    .stt>button {
        padding: 0.1rem 0.75rem;
        color: white;
        font-weight: bold;
        background: #5161ac;
        border-radius: 0.25rem;
    }

    .tap {
        display: flex;
    }

    .total {
        width: 100%;
    }

    .tap_left {
        min-width: 30%;
        border: 3px solid black;
    }

    .tap_right {
        overflow-y: scroll;
        display: flex;
        flex-wrap: wrap;
        border: 3px solid black;
        justify-content: space-between;
        max-height: 500px;
    }

    .link {
        border: 1px solid #ddd;
    }

    .link2 {
        width: 50%;
    }

    input+label {
        position: relative;
        text-align: center;
        width: 70px;
        line-height: 40px;
    }

    .label_text {
        white-space: nowrap;
        text-align: center;
        z-index: -1;
        position: absolute;
        color: white;
        top: -20px;
        background-color: rgba(0, 0, 0, 0.3);
    }

    input+label:hover {
        background: #ddd;
    }

    input+label:hover div {
        z-index: 2;
    }

    input:checked+label {
        background: greenyellow;
    }

    .red_label {
        width: 100%;
        border: 1px solid black;
    }

    .cur_btn {
        border: 1px black solid;
        border-radius: 50%;
        background: yellow;
        position: relative;
        z-index: 100;
    }

    .cur_btn::after {
        content: '?';
    }

    .pop_con {
        background: #ddd;
        border: 1px solid black;
        padding: 1rem;
    }

    .custom_box {
        display: flex;
    }

    .bottom_btn {
        margin-bottom: 1rem;
        width: 100%;
    }

    @media screen and (max-width:768px) {

        video {
            max-height: 50vh;
        }

        .tap {
            flex-direction: column;
            height: auto;
        }

        .tap_right {
            height: 300px;
            flex-direction: column;
            flex-wrap: nowrap;
        }

        .link2 {
            width: 100%;
        }

        input+label {
            font-size: 1rem;
            width: 20%;
            height: 15%;
            border: 1px blanchedalmond solid;
        }

        .link:nth-child(2):first-child+input+label {
            font-size: 0.5rem;
            background: blue !important;
        }

        video {
            width: 100%;
        }

        .pop_full2 {
            top: 50px;
        }

        #speechBox>input {
            width: 49%;
        }
    }

    @media screen and (max-width:480px) {
        input+label {
            font-size: 0.75rem;
        }
    }
</style>