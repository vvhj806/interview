<!--s duty_pop-->
<div id="duty_pop" class="pop_modal2 ard_md">
	<!--s pop_full_cont-->
	<div class="pop_full_cont pop_full">
		<!--s pop_full_cont2-->
		<div class="pop_full_cont2">
			<!--s top_tltBox-->
			<div class="top_tltBox c">
				<div class="top_tltcont">
					<!--s top_shBox-->
					<?= view_cell('\App\Libraries\CategoryLib::jobSearch') ?>
					<!--e top_shBox-->
				</div>

				<!--s top_tltcont-->
				<div class="top_tltcont">
					<!-- <div class="tlt l">산업군/직무 선택</div> -->
					<div class="countBox"><span class="point jobPoint">0</span>/10</div>
				</div>
				<!--e top_tltcont-->
			</div>
			<!--e top_tltBox-->

			<!--s search_box-->
			<div class='cate_search_pop'>
				<ul class='cate_search_list'>

				</ul>
			</div>
			<!--e search_box-->
		</div>
		<!--e pop_full_cont2-->

		<!--s ardBox-->
		<div class="ardBox">
			<?= view_cell('\App\Libraries\CategoryLib::jobCategory', ['option' => 'muti', 'checked' => $data['aJobs'] ?? []]) ?>
		</div>
		<!--e ardBox-->
	</div>
	<!--e pop_full_cont-->
	<!--s ard_btnBox-->
	<div id='jobsArd' class="ard_btnBox fix_btnMod">
		<!--s ard_btn_cont-->
		<div class="ard_btn_cont">
			<!--s keywords_box-->
			<div class="keywords_box">
				<!--s depth-->
				<ul class="depth jobDepth">

				</ul>
				<!--e depth-->
			</div>
			<!--e keywords_box-->

			<!--s ard_btn-->
			<div class="BtnBox mg_t40 ">
				<button type='button' class="btn btn02 jobBtn" value='no'>닫기</button>
				<button type='button' class="btn btn01 jobBtn" value='ok'>확인</button>
			</div>
			<!--e ard_btn-->
		</div>
		<!--e ard_btn_cont-->
	</div>
	<!--e ard_btnBox-->
</div>
<!--e duty_pop-->

<script>
	$(document).on('change', 'input[name="depth3[]"]', function() { //depth3
		const thisValue = $(this).val();

		if (!getListLength('job')) {
			$(this).prop('checked', false);
			return;
		};

		if ($(this).is(':checked')) {
			appendList('job', thisValue, $(this).next('label').text(), $(this).attr('id'));
		} else {
			$(`li[data-jobIdx="${thisValue}"]`).remove();
		}

		const bottomHeight = $('#jobsArd').outerHeight();
		$('.jobDepth2').css("padding-bottom", `${bottomHeight+50}px`);
		$('.jobDepth1').css("padding-bottom", `${bottomHeight+50}px`);
	});

	$('.jobBtn').on('click', function() {
		let thisValue = $(this).val();

		if (thisValue == 'ok') {

		} else if (thisValue == 'no') {
			if (!confirm('초기화 하시겠습니까?')) {
				return;
			}
			resetModal('duty');
		}
		fnHidePop('duty_pop');
	});
</script>

<style>
	.jobDepth1 label::after,
	.jobDepth2 label::after {
		display: none !important;
	}
</style>