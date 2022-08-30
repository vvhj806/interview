<!--s #scontent-->
<div id="scontent">
	<!--s top_tltBox-->
	<div class="top_tltBox c">
		<!--s top_tltcont-->
		<div class="top_tltcont">
			<a href="javascript:window.history.back();">
				<div class="backBtn"><span>뒤로가기</span></div>
			</a>
			<div class="tlt">하이버프 모의 인터뷰</div>
		</div>
		<!--e top_tltcont-->
	</div>
	<!--e top_tltBox-->

	<!--s top_jbBox-->
	<div class="top_jbBox c">
		<div class="txt">가고싶었던 기업의 실제 면접 질문 연습하기</div>
	</div>
	<!--e top_jbBox-->
	<form method="self" id="frm1">
		<!--s top_tltBox-->
		<div class="top_tltBox mg_t30">
			<!--s top_tltcont-->
			<div class="top_tltcont">
				<!--s top_shBox-->
				<div class="top_shBox top_shBox2">
					<span id="searchclear" class='searchclear' style="display: none;"><img src="/static/www/img/sub/list_close.png"></span>
					<div class="iconBox"><button type="search"><img src="/static/www/img/main/m_sh_icon.png"></button></div>
					<input type="text" id="searchinput" name="searchText" value='<?= $data['search']['text'] ?? '' ?>' class="top_sh_inp" placeholder="기업명을 검색해보세요">
				</div>
				<!--e top_shBox-->
			</div>
			<!--e top_tltcont-->
		</div>
		<!--e top_tltBox-->

		<!--s gray_bline_first-->
		<div class="gray_bline_first gray_bline_top">
			<!--s contBox-->
			<div class="contBox">
				<!--s sub_tab-->
				<div class="sub_tab">
					<!--s depth-->
					<ul class="depth">
						<?php foreach ($data['config']['company']['company_form'] as $key => $val) : ?>
							<input type="checkbox" name="comCheck[]" id="comCheck_<?= $key ?>" value="<?= $val ?>" <?= isset($data['get']['company_form']) && in_array($val, $data['get']['company_form']) ? 'checked' : '' ?> style="display:none">
							<li data-idx="<?= $key ?>" <?= isset($data['get']['company_form']) && in_array($val, $data['get']['company_form']) ? 'class="on"' : '' ?>><a href="javascript:void(0)"><?= $val ?></a></li>
						<?php endforeach; ?>
					</ul>
					<!--e depth-->
				</div>
				<!--e sub_tab-->

				<div class="stlt mg_t60">지역</div>
				<div class="position_ckBox">
					<ul>
						<?php foreach ($data['koreaArea'] as $key => $val) : ?>
							<li>
								<div class="ck_radio">
									<input type="checkbox" id="korea_<?= $val['idx'] ?>" name="korea[]" value="<?= $val['area_depth_text_1'] ?>" <?= isset($data['get']['korea']) && in_array($val['area_depth_text_1'], $data['get']['korea']) ? 'checked' : '' ?>>
									<label for="korea_<?= $val['idx'] ?>"><?= $val['area_depth_text_1'] ?></label>
								</div>
							</li>
						<? endforeach; ?>
					</ul>
				</div>

				<div class="stlt mg_t60">응시직무</div>
				<div class="position_ckBox">
					<ul>
						<?php foreach ($data['category'] as $key => $val) : ?>
							<li>
								<div class="ck_radio">
									<input type="checkbox" id="cate_<?= $key ?>" name="cate[]" value="<?= $val['job_depth_1'] ?>" <?= in_array($val['job_depth_1'], $data['get']['cate'] ?? []) ? 'checked' : '' ?>>
									<label for="cate_<?= $key ?>">
										<?= $val['job_depth_text'] ?>
									</label>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<!--e contBox-->
		</div>
		<!--e gray_bline_first-->
	</form>

	<!--s cont-->
	<div class="cont" id="mock_list">

		<!--s perfitUl-->
		<ul class="perfitUl perfitUl2">
			<!--s 무한루프-->

			<li class="no_list <?= $data['list'] ? 'hide' : '' ?>" style='height: auto'>
				<!-- 리스트없을때 -->
				<div class="ngp"><span>!</span></div>
				해당하는 기업이 없어요!
			</li>

			<?php foreach ($data['list'] as $row) : ?>
				<li>
					<!--s liBox-->
					<div class="liBox">
						<!--s itemBox-->
						<div class="itemBox">
							<a href='/company/detail/<?= $row['comIdx'] ?>'>
								<div class="img">
									<img src="<?= $data['url']['media'] ?><?= $row['fileComLogo'] ?? '/data/no_img.png' ?>" onerror="this.src = '<?= $data['url']['media'] ?>/data/no_img.png'">
								</div>
							</a>

							<!--s txtBox-->
							<div class="txtBox">
								<a href='/company/detail/<?= $row['comIdx'] ?>'>
									<div class="tlt"><?= $row['comName'] ?></div>
								</a>

								<div class="gtxtBox">
									<div class="gtxt"><?= $row['comForm'] ?> <span>|</span> <?= $row['comAddress'] ?></div>
								</div>

								<!--s gBtn_color-->
								<div class="gBtn_color mg_t80">
									<span class="span_txt"><?= $row['job_depth_text'] ?></span>
									<!-- <span class="num">+1</span> -->
								</div>
								<!--e gBtn-->
							</div>
							<!--e gBtn_color-->

							<!--s bookmark_iconBox-->
							<div class="bookmark_iconBox">
								<button type='button' class="bookmark_icon  <?= ($row['scrap'] ?? false) ? 'on' : 'off' ?>" tabindex="0" data-idx='<?= $row['comIdx'] ?>' data-type='company'>
									<span class="blind">스크랩</span>
								</button>
							</div>
							<!--e bookmark_iconBox-->
						</div>
						<!--e itemBox-->
					</div>
					<!--e liBox-->

					<div class="perfit_moreBtn mg_t10">
						<a href="javascript:void(0)" class="point b mockPop" id="mockPop_<?= $row['infoIdx'] ?>">모의 인터뷰 하기 <span class="arrow"><i class="la la-angle-right"></i></span></a>
					</div>
				</li>
			<?php endforeach; ?>
			<!--e 무한루프-->
		</ul>
		<!--e perfitUl-->
		<?= $data['pager']->links('practiceList', 'front_full') ?>
	</div>
	<!--e cont-->
</div>
<!--e #scontent-->

<!--s 기업 인터뷰로 클릭시 모달-->
<div id="mock_test_pop" class="pop_modal2">
	<!--s pop_Box-->
	<div class="spop_Box c">
		<!--s pop_cont-->
		<div class="spop_cont">
			<!--s selBox-->
			<div class="selBox wps_100 mg_b30">
				<div class="selectbox wps_100">
					<div class="wps_100 txt mg_b10" id="MockTitle">[경영.사무] 모의 인터뷰</div>
					<!-- <dl class="dropdown wps_100">
						<dt class="wps_100"><a href="javascript:void(0)" class="myclass">[경영.사무] 모의 인터뷰</a></dt>
						<dd class="wps_100">
							<ul class="dropdown2">
								<li><a href="javascript:void(0)" class="on">[경영.사무] 모의 인터뷰</a></li>
								<li><a href="javascript:void(0)">[경영.사무] 모의 인터뷰</a></li>
								<li><a href="javascript:void(0)">[경영.사무] 모의 인터뷰</a></li>
							</ul>
						</dd>
					</dl> -->
				</div>

			</div>
			<!--e selBox-->

			<div class="txt mg_b10">
				<span id="companyName">KB국민은행</span>에서<br />
				[<span id="jobDepth">경영.사무</span>] 지원자에게 묻는<br />
				<span class="point b" id="QueCount">5</span>개의 질문들로 구성되어 있어요
			</div>

			<!-- <div class="stxt mg_b25">*응시 가능 횟수 : 1회</div> -->
			<div class="stxt black">
				분석 결과는 AI리포트에서 확인하실 수 있습니다
			</div>

			<!--s spop_lineBox-->
			<div class="spop_lineBox mg_t30">
				<div class="spl_tlt">비공개 인터뷰</div>
				<div class="spl_txt">해당 인터뷰는 공개 처리 및 타 공고 지원이 불가능해요</div>
			</div>
			<!--e spop_lineBox-->
		</div>
		<!--e pop_cont-->

		<!--s spopBtn-->
		<div class="spopBtn radius_none">
			<a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('mock_test_pop')">다음에 하기</a>
			<a href="javascript:void(0)" class="spop_btn02" id="nowStart">지금 시작하기</a>
		</div>
		<!--e spopBtn-->
	</div>
	<!--e pop_Box-->
</div>
<!--e 기업 인터뷰로 클릭시 모달-->

<script>
	let i_idx;

	function scrap(state, type, memidx, idx, ele) {
		$.ajax({
			type: "GET",
			url: `/api/my/scrap/${state}/${type}/${memidx}/${idx}`,
			success: function(data) {
				if (data.status == 200) {
					if (state == 'add') {
						ele.removeClass('off');
						ele.addClass('on');
					} else if (state == 'delete') {
						ele.removeClass('on');
						ele.addClass('off');
					}
				} else {
					alert(data.messages);
				}
			},
			error: function(e) {
				alert("데이터 전송 지연이 발생합니다. 잠시후에 시도해주세요.\n같은 현상이 반복되면 고객센터나 카카오톡 채널 '하이버프'로 문의 부탁드립니다.");
				return;
			},
		})
	}
	$(document).ready(function() {
		$('.depth li').on('click', function() {
			$(this).toggleClass("on");
			if ($('#comCheck_' + $(this).data('idx')).is(':checked') == true) {
				$("input:checkbox[id='comCheck_" + $(this).data('idx') + "']").attr("checked", false);
			} else {
				$("input:checkbox[id='comCheck_" + $(this).data('idx') + "']").attr("checked", true);
			}
			$('#frm1').submit();
		});

		$('.ck_radio').on('click', function() {

			$('#frm1').submit();
		});
		$('.bookmark_icon').on('click', function() {
			const emlThis = $(this);
			const type = emlThis.data('type');
			const memidx = '<?= $data['session']['idx'] ?>';
			const idx = emlThis.data('idx');
			if (!memidx) {
				alert('로그인이 필요한 서비스 입니다.');
				location.href = '/login';
				return;
			}
			if ($(this).hasClass('on')) {
				scrap('delete', type, memidx, idx, emlThis);
			} else if ($(this).hasClass('off')) {
				scrap('add', type, memidx, idx, emlThis);
			}
		});
	});

	$('.mockPop').on('click', function() {
		console.log($(this).attr("id"));
		let list = $.parseJSON('<?= $data['enList'] ?>');
		let infoIdx = $(this).attr("id").split('_')[1];
		for (let i = 0; i < list.length; i++) {
			if (list[i]['infoIdx'] == infoIdx) {
				$('#companyName').text(list[i]['comName']);
				$('#jobDepth').text(list[i]['job_depth_text']);
				let interQue = list[i]['interviews'][0]['inter_question'];
				interQue = interQue.split(',');
				$('#QueCount').text(interQue.length);
				$('#MockTitle').text(list[i]['interviews'][0]['inter_name']);
				i_idx = list[i]['i_idx'];
				break;
			}
		}

		fnShowPop('mock_test_pop');
	});

	$('#nowStart').on('click', function() {
		fnHidePop('mock_test_pop');
		location.href = "/interview/ready?cmock=" + i_idx;
	});
</script>