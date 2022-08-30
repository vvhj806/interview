<!--s area_pop-->
<div id="area_pop" class="pop_modal2 ard_md">
	<!--s pop_full_cont-->
	<div class="pop_full_cont pop_full">
		<!--s pop_full_cont2-->
		<div class="pop_full_cont2">
			<!--s top_tltBox-->
			<div class="top_tltBox c">
				<!--s top_tltcont-->
				<div class="top_tltcont">
					<div class="tlt l">지역 선택</div>
					<div class="countBox">
						<span class="point areaPoint">0</span>/10
					</div>
				</div>
				<!--e top_tltcont-->
			</div>
			<!--e top_tltBox-->
		</div>
		<!--e pop_full_cont2-->

		<!--s ardBox-->
		<div class="ardBox">
			<!--s ard_1th-->
			<div class="ard_1th">
				<div class="ard_tlt c">시/도</div>

				<!--s ard_list-->
				<ul class="ard_list areaDepth1">
					<?php for ($i = 1, $max = count($data['areaCategory']); $i <= $max; $i++) : ?>
						<li class='<?= $i === 1 ? 'on' : '' ?>' value='<?= $i ?>'>
							<a><?= $data['areaCategory'][$i]['all']['areaName'] ?></a>
						</li>
					<?php endfor; ?>
				</ul>
				<!--e ard_list-->
			</div>
			<!--e ard_1th-->

			<!--s ard_2th-->
			<div class="ard_2th">
				<div class="ard_tlt c">시/구/군</div>
				<!--s ard_list-->
				<?php for ($i = 1, $max = count($data['areaCategory']); $i <= $max; $i++) : ?>
					<ul id='areaLists<?= $i ?>' class="ard_list areaDepth2">
						<?php foreach ($data['areaCategory'][$i] as $key => $val) : ?>
							<li>
								<input id='A<?= $val['idx'] ?>' type='checkBox' name='aArea[A<?= $val['idx'] ?>]' value='<?= $val['idx'] ?>' <?= isset($data['aArea']["A{$val['idx']}"]) ? 'checked' : '' ?> style='display:none'>

								<label for='A<?= $val['idx'] ?>'>
									<?= $val['areaName'] ?><?= $key === 'all' ? ' 전체' : '' ?>
								</label>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endfor; ?>
				<!--e ard_list-->
			</div>
			<!--e ard_2th-->


		</div>
		<!--e ardBox-->
	</div>
	<!--e pop_full_cont-->
	<!--s ard_btnBox-->
	<div id='areaArd' class="ard_btnBox fix_btnMod">
		<!--s ard_btn_cont-->
		<div class="ard_btn_cont">
			<!--s keywords_box-->
			<div class="keywords_box">
				<!--s depth-->
				<ul class="depth areaDepth">

				</ul>
				<!--e depth-->
			</div>
			<!--e keywords_box-->
			<!--s ard_btn-->
			<div class="BtnBox mg_t40">
				<button type='button' class="btn btn02 areaBtn" value='no'>닫기</button>
				<button type='button' class="btn btn01 areaBtn" value='ok'>확인</button>
			</div>
			<!--e ard_btn-->

		</div>
		<!--e ard_btn_cont-->
	</div>
	<!--e ard_btnBox-->
</div>
<!--e area_pop-->
<script>
	let jsonArea = '<?= json_encode($data['areaCategory']) ?>';
	let areaName = [];

	jsonArea = JSON.parse(jsonArea);

	for (let key in jsonArea) {
		for (let val in jsonArea[key]) {
			areaName[jsonArea[key][val].idx] = jsonArea[key][val].areaName;
		}
	}

	$('.areaBtn').on('click', function() {
		let thisValue = $(this).val();

		if (thisValue == 'ok') {

		} else if (thisValue == 'no') {
			if (!confirm('초기화 하시겠습니까?')) {
				return;
			}
			resetModal('area');
		}
		fnHidePop('area_pop');

	});

	$('.areaDepth1').children('li').on('click', function() {
		$('.areaDepth1').children('li').removeClass('on');
		$(this).addClass('on');
		let id = $(this).val();
		$('.areaDepth2').hide();
		$(`#areaLists${id}`).show();
	});

	$('.areaDepth2').find('input:checkBox').on('change', function() {
		if (!getListLength('area')) {
			$(this).prop('checked', false);
			return;
		};

		let thisValue = $(this).val();

		if ($(this).is(':checked')) {
			appendList('area', thisValue, areaName);
		} else {
			$(`li[data-areaIdx="${thisValue}"]`).remove();
		}

		const bottomHeight = $('#areaArd').outerHeight();
		$('.areaDepth2').css("padding-bottom", `${bottomHeight+50}px`);
		$('.areaDepth1').css("padding-bottom", `${bottomHeight+50}px`);
	});
</script>