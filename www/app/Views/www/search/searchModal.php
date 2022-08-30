<!--s d_search_mb-->
<div id="d_search_md" class="pop_modal2">
	<!--s pop_full-->
	<div class="pop_full">
		<!--s pop_full_cont-->
		<div class="pop_full_cont">
			<!--s top_tltBox-->
			<div class="top_tltBox c">
				<!--s top_tltcont-->
				<div class="top_tltcont">
					<div class="tlt">상세검색</div>
					<a href="javascript:void(0)" class="close_btn" onclick="fnHidePop('d_search_md')"><img src="/static/www/img/sub/login_close.png"></a>
				</div>
				<!--e top_tltcont-->
			</div>
			<!--e top_tltBox-->

			<!--s pop_full_scroll-->
			<div class="pop_full_scroll">
				<!--s cont_pd-->
				<div class="cont_pd cont_pd_bottom">
					<!--s gray_bline_first-->
					<div class="gray_bline_first mg_t55">
						<!--s contBox-->
						<div class="contBox">
							<div class="stlt">고용형태 (<span class='workTypePoint'>0</span>)</div>

							<!--s position_ckBox-->
							<div class="position_ckBox fl_wd2">
								<ul class='workTypeDepth2'>
									<li>
										<div class="ck_radio">
											<input id='workTypeFullTime' name='aWorkType[fullTime]' type='checkbox' <?= isset($data['aWorkType']['fullTime']) ? 'checked' : '' ?>>
											<label for='workTypeFullTime'>정규직</label>
										</div>
									</li>
									<li>
										<div class="ck_radio">
											<input id='workTypehalfTime' name='aWorkType[halfTime]' type='checkbox' <?= isset($data['aWorkType']['halfTime']) ? 'checked' : '' ?>>
											<label for="workTypehalfTime">계약직</label>
										</div>
									</li>
									<li>
										<div class="ck_radio">
											<input id='workTypeintern' name='aWorkType[intern]' type='checkbox' <?= isset($data['aWorkType']['intern']) ? 'checked' : '' ?>>
											<label for="workTypeintern">인턴직</label>
										</div>
									</li>
									<!-- <li>
										<div class="ck_radio">
											<input id='workTypePartTime' name='aWorkType[partTime]' type='checkbox' <?= isset($data['aWorkType']['partTime']) ? 'checked' : '' ?>>
											<label for="workTypePartTime">아르바이트</label>
										</div>
									</li> -->
									<li>
										<div class="ck_radio">
											<input id='workTypeForeign' name='aWorkType[foreign]' type='checkbox' <?= isset($data['aWorkType']['foreign']) ? 'checked' : '' ?>>
											<label for="workTypeForeign">해외취업</label>
										</div>
									</li>
								</ul>
							</div>
							<!--e position_ckBox-->
						</div>
						<!--s contBox-->
					</div>
					<!--e gray_bline_first-->

					<!--s gray_bline_first-->
					<div class="gray_bline_first gray_bline_top">
						<!--s contBox-->
						<div class="contBox">
							<div class="stltBox">
								<div class="stlt">지역 (<span class='areaPoint'>0</span>)</div>
								<div class="plus_more_btn"><a href="javascript:void(0)" onclick="fnShowPop('area_pop')">더보기 <i class="la la-plus"></i></a></div>
							</div>

							<!--s keywords_box-->
							<div class="keywords_box keywords_box2">
								<!--s depth-->
								<ul id='areaDepth2' class="depth2">

								</ul>
								<!--e depth-->
							</div>
							<!--e keywords_box-->
						</div>
						<!--s contBox-->
					</div>
					<!--e gray_bline_first-->

					<!--s gray_bline_first-->
					<div class="gray_bline_first gray_bline_top">
						<!--s contBox-->
						<div class="contBox">
							<div class="stltBox">
								<div class="stlt">직군/직무 (<span class='jobPoint'>0</span>)</div>
								<div class="plus_more_btn"><a href="javascript:void(0)" onclick="fnShowPop('duty_pop')">더보기 <i class="la la-plus"></i></a></div>
							</div>

							<!--s keywords_box-->
							<div class="keywords_box keywords_box2">
								<!--s depth-->
								<ul id='jobDepth2' class="depth2">

								</ul>
								<!--e depth-->
							</div>
							<!--e keywords_box-->
						</div>
						<!--e contBox-->
					</div>
					<!--e gray_bline_first-->

					<!--s gray_bline_first-->
					<div class="gray_bline_first gray_bline_top">
						<!--s contBox-->
						<div class="contBox">
							<div class="stlt">경력</div>

							<div class="chek_box checkbox mg_b10">
								<input id='careerNew' type='radio' name='strCareer' value='new' <?= (isset($data['strCareer']) && $data['strCareer'] === 'new') ? 'checked' : '' ?>>
								<label for="careerNew" class="lbl black">신입</label>
							</div><br />

							<div class="chek_box checkbox">
								<input id='careerOld' type='radio' name='strCareer' value='old' <?= (isset($data['strCareer']) && $data['strCareer'] === 'old') ? 'checked' : '' ?>>
								<label for="careerOld" class="lbl black">경력</label>
							</div>

							<div class="mg_l15 ds_in_bk">
								<input id='' class='sinp' type='number' name='iCareerMonth' value='<?= (isset($data['iCareerMonth'])) ? $data['iCareerMonth'] : '' ?>' disabled> <span class="ds_in_bk">월 이상</span>
							</div><br />

							<div class="chek_box checkbox">
								<input id="careerNone" name="strCareer" type="radio" onclick="" value="">
								<label for="careerNone" class="lbl black">무관</label>
							</div>
						</div>
						<!--s contBox-->
					</div>
					<!--e gray_bline_first-->

					<!--s gray_bline_first-->
					<div class="gray_bline_first gray_bline_top">
						<!--s contBox-->
						<div class="contBox">
							<div class="stltBox">
								<div class="stlt">
									<span>지원 방식</span>
									<span class="toolp_span"><a href="javascript:void(0)" class="">?</a></span>
								</div>

							</div>

							<!--s position_ckBox-->
							<div class="position_ckBox fl_wd2">
								<ul>
									<li>
										<div class="ck_radio">
											<input id='applyMy' type='radio' name='strApply' value='my' <?= (isset($data['strApply']) && $data['strApply'] === 'my') ? 'checked' : '' ?>>
											<label for="applyMy">내 인터뷰로 지원</label>
										</div>
									</li>
									<li>
										<div class="ck_radio">
											<input id='applyYou' type='radio' name='strApply' value='you' <?= (isset($data['strApply']) && $data['strApply'] === 'you') ? 'checked' : '' ?>>
											<label for="applyYou">기업 인터뷰로 지원</label>
										</div>
									</li>
									<li class="r wps_100" style="display: none;">
										<span class="ds_in_bk">질문</span> <input id='applyCount' type='number' name='iQueCount' value='<?= (isset($data['iQueCount'])) ? $data['iQueCount'] : '' //todo
																																		?>' disabled> <span class="ds_in_bk">개 이하</span>
									</li>
								</ul>
							</div>
							<!--e position_ckBox-->
						</div>
						<!--s contBox-->
					</div>
					<!--e gray_bline_first-->

					<!--더보기해야 나오는 화면 -->
					<div class="pop_moreBox pd_b100">
						<!--s more_tlt-->
						<div class="more_tlt">
							<div class="perfit_moreBtn">
								<a href="javascript:void(0)">상세 검색조건 더보기 <span class="arrow"><i class="la la-angle-down"></i></span></a>
							</div>
						</div>
						<!--e more_tlt-->

						<!--s more_cont-->
						<div class="more_cont">
							<!--s gray_bline_first-->
							<div class="gray_bline_first gray_bline_top">
								<!--s contBox-->
								<div class="contBox">
									<div class="stltBox">
										<div class="stlt">태그 (<span class='tagPoint'>0</span>)</div>
										<div class="plus_more_btn"><a href="javascript:void(0)" onclick="fnShowPop('tag_pop')">더보기 <i class="la la-plus"></i></a></div>
									</div>

									<!--s position_ckBox-->
									<div class="position_ckBox">
										<ul>
											<li>
												<div class="ck_radio">
													<input id='fakeT1' type="checkbox">
													<label for="T1">#자율복장</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='fakeT2' type="checkbox">
													<label for="T2">#유연근무</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='fakeT3' type="checkbox">
													<label for="T3">#정시퇴근</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='fakeT4' type="checkbox">
													<label for="T4">#점심제공</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='fakeT5' type="checkbox">
													<label for="T5">#자유로운연차사용</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='fakeT6' type="checkbox">
													<label for="T6">#야근수당</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='fakeT7' type="checkbox">
													<label for="T7">#재택근무</label>
												</div>
											</li>
										</ul>
									</div>
									<!--e position_ckBox-->
								</div>
								<!--s contBox-->
							</div>
							<!--e gray_bline_first-->

							<!--s gray_bline_first-->
							<div class="gray_bline_first gray_bline_top">
								<!--s contBox-->
								<div class="contBox">
									<!--s stltBox-->
									<div class="stltBox">
										<div class="stlt fl mg_t5">급여</div>
										<div class="chek_box checkbox fr">
											<input id='payTypeAfter' type='checkBox' name='strPayType' value='after' <?= (isset($data['strPayType']) && $data['strPayType'] === 'after') ? 'checked' : '' ?>>
											<label for="payTypeAfter" class="lbl black">협의 후 결정</label>
										</div>
									</div>
									<!--e stltBox-->

									<div class="chek_box radio mg_b10">
										<input id='payTypeMonth' type='radio' name='strPayType' value='month' <?= (isset($data['strPayType']) && $data['strPayType'] === 'month') ? 'checked' : '' ?>>
										<label for="payTypeMonth" class="lbl black">월급</label>
									</div><br />

									<div class="chek_box radio mg_b10">
										<input id='payTypeYear' type='radio' name='strPayType' value='year' <?= (isset($data['strPayType']) && $data['strPayType'] === 'year') ? 'checked' : '' ?>>
										<label for="payTypeYear" class="lbl black">연봉</label>
									</div><br />

									<input id='' type='number' name='iPayUnit' value='<?= (isset($data['iPayUnit'])) ? $data['iPayUnit'] : '' ?>'><span class="ds_in_bk">만원 부터</span>
								</div>
								<!--s contBox-->
							</div>
							<!--e gray_bline_first-->

							<!--s gray_bline_first-->
							<div class="gray_bline_top">
								<!--s contBox-->
								<div class="contBox">
									<div class="stltBox">
										<div class="stlt fl mg_t5">학력</div>
										<div class="chek_box checkbox fr">
											<input id='eduNone' class='' name='aEducation[none]' type='checkbox' <?= isset($data['aEducation']['none']) ? 'checked' : '' ?>>
											<label for="eduNone" class="lbl black">학력 무관</label>
										</div>
									</div>

									<!--s position_ckBox-->
									<div class="position_ckBox">
										<ul id='edu_ul'>
											<li>
												<div class="ck_radio">
													<input id='eduMiddle' class='edu' name='aEducation[middle]' type='checkbox' <?= isset($data['aEducation']['middle']) ? 'checked' : '' ?>>
													<label for="eduMiddle">고졸 이하</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='eduHigh' class='edu' name='aEducation[high]' type='checkbox' <?= isset($data['aEducation']['high']) ? 'checked' : '' ?>>
													<label for="eduHigh">고등학교</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='eduCollege' class='edu' name='aEducation[college]' type='checkbox' <?= isset($data['aEducation']['college']) ? 'checked' : '' ?>>
													<label for="eduCollege">대학(2,3년제)</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='eduUniversity' class='edu' name='aEducation[university]' type='checkbox' <?= isset($data['aEducation']['university']) ? 'checked' : '' ?>>
													<label for="eduUniversity">대학교(4년제)</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='eduMaster' class='edu' name='aEducation[master]' type='checkbox' <?= isset($data['aEducation']['master']) ? 'checked' : '' ?>>
													<label for="eduMaster">석사</label>
												</div>
											</li>
											<li>
												<div class="ck_radio">
													<input id='eduDoctor' class='edu' name='aEducation[doctor]' type='checkbox' <?= isset($data['aEducation']['doctor']) ? 'checked' : '' ?>>
													<label for="eduDoctor">박사</label>
												</div>
											</li>
										</ul>
									</div>
									<!--e position_ckBox-->
								</div>
								<!--s contBox-->
							</div>
							<!--e gray_bline_first-->
						</div>
						<!--e more_cont-->
					</div>
					<!--더보기해야 나오는 화면 -->
				</div>
				<!--e cont_pd-->


			</div>
			<!--e pop_full_scroll-->
		</div>
		<!--e pop_full_cont-->

		<!--s 태그모달-->
		<div id="tag_pop" class="pop_modal2">
			<!--s pop_Box-->
			<div class="spop_Box c">
				<!--s pop_cont-->
				<div class="spop_cont md_pop_content">
					<!--s spop_tltBox-->
					<div class="spop_tltBox mg_b15">
						<div class="spop_tlt">태그선택하기</div>
						<a href="javascript:void(0)" class="spop_close_btn" onclick="fnHidePop('tag_pop')"><img src="/static/www/img/sub/close_btn_icon.png"></a><!-- onclick 누르면 닫히 -->
					</div>
					<!--e spop_tltBox-->

					<!--s position_ckBox-->
					<div class="position_ckBox">
						<ul class='tagDepth2'>
							<?php foreach ($data['tagCategory'] as $val) : ?>
								<li>
									<div class="ck_radio">
										<input id="T<?= $val['idx'] ?>" type="checkbox" name="aTag[T<?= $val['tag_txt'] ?>]" <?= ($data['aTag']["T{$val['tag_txt']}"] ?? false) ? 'checked' : '' ?>>
										<label for="T<?= $val['idx'] ?>">#<?= $val['tag_txt'] ?></label>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<!--e position_ckBox-->
				</div>
				<!--e pop_cont-->

				<!--s spopBtn-->
				<div class="spopBtn">
					<a href="javascript:void(0)" class="spop_btn02 wps_100 spop_close" onclick="fnHidePop('tag_pop')">태그(<span class='tagPoint'>0</span>)개 선택완료</a><!-- onclick 누르면 닫히 -->
				</div>
				<!--e spopBtn-->
			</div>
			<!--e pop_Box-->
		</div>
		<!--e 태그모달-->

	</div>
	<!--e d_search_mb-->
	<!--s fix_btBtn-->
	<div class="fix_btBtn fix_btnMod">
		<label id='reset' class="fix_btn01">초기화</label>

		<label for='deepSearchSubmit' class="fix_btn02 tap"> 적용하기<input id='deepSearchSubmit' name='type' type='radio' value='deepSearch' style='display:none' <?= ($data['type'] === 'deepSearch') ? 'checked' : '' ?>></label>

	</div>
	<!--e fix_btBtn-->
	<script>
		$('.tagDepth2').find('input:checkBox').on('change', function() {
			getListLength('tag');
			let realId = $(this).attr('id');
			let check = $(this).is(':checked');
			$(`#fake${realId}`).prop('checked', check).trigger('change');
		});

		$('.more_tlt').on('click', function() {
			$('.more_tlt').addClass('active');
			$('.more_cont').show();
		})

		// $('#eduNone').on('click', function() {
		// 	$('.edu').prop('checked', false);
		// });

		// $('.edu').on('click', function() {
		// 	$('#eduNone').prop('checked', false);
		// });
	</script>