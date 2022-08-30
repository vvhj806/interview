<form id='frm' method='post' action='write/action'>
	<?= csrf_field() ?>
	<div class="content_title">
		<h3>지원하기</h3>

		<div class="top_btnBox">
			<button type='submit' class="btn btn01">지원하기</button>
			<a href="mock_list.php" class="btn btn02">취소하기</a>
		</div>
	</div>

	<label for='member_input'>
		<h4>지원자 선택</h4>
	</label>
	<!--s cont_searchBox-->
	<div class="cont_searchBox ov_none">
		<!--s sch_inp_borderBox-->
		<div class="sch_inp_borderBox">
			<span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
			<input id='member_input' type="text" class="search_input" placeholder="이름을 검색 후 등록해 주세요">
		</div>
		<!--e sch_inp_borderBox-->

		<!--s sch_kwdBox-->
		<!-- 검색시 나타나는 박스 -->
		<div class="sch_kwdBox" style="display:none">
			<!--s sch_kwdcont-->
			<div class="sch_kwdcont">
				<ul id='member_search'>
				</ul>
			</div>
			<!--e sch_kwdcont-->
		</div>
		<!--e sch_kwdBox-->
	</div>
	<!--e cont_searchBox-->

	<!--s t1-->
	<div class="t1 c">
		<table>
			<colgroup>
				<col class="wps_10">
				<col class="wps_25">
				<col class="wps_15">
				<col class="wps_20">
				<col class="wps_20">
				<col class="wps_10">
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>전화번호</th>
					<th>인터뷰 선택</th>
					<th>삭제</th>
				</tr>
			</thead>
			<tbody id='member_table'>
			</tbody>
		</table>
	</div>
	<!--e t1-->

	<label for='recruit_input'>
		<h4>공고 선택</h4>
	</label>
	<!--s cont_searchBox-->
	<div class="cont_searchBox ov_none">
		<!--s sch_inp_borderBox-->
		<div class="sch_inp_borderBox">
			<span class="icon"><img src="/static/www/img/main/m_sh_icon.png"></span>
			<input id='recruit_input' type="text" class="search_input" placeholder="이름을 검색 후 등록해 주세요">
		</div>
		<!--e sch_inp_borderBox-->

		<!--s sch_kwdBox-->
		<!-- 검색시 나타나는 박스 -->
		<div class="sch_kwdBox" style="display:none">
			<!--s sch_kwdcont-->
			<div class="sch_kwdcont">
				<ul id='recruit_search'>
				</ul>
			</div>
			<!--e sch_kwdcont-->
		</div>
		<!--e sch_kwdBox-->
	</div>
	<!--e cont_searchBox-->

	<!--s t1-->
	<div class="t1 c">
		<table>
			<colgroup>
				<col class="wps_10">
				<col class="wps_20">
				<col class="wps_20">
				<col class="wps_10">
				<col class="wps_10">
				<col class="wps_10">
				<col class="wps_10">
				<col class="wps_10">
			</colgroup>
			<thead>
				<tr>
					<th>번호</th>
					<th>기업번호</th>
					<th>기업명</th>
					<th>공고명</th>
					<th>직군/직무</th>
					<th>지역</th>
					<th>인터뷰<br />분류</th>
					<th>접수 마감일</th>
					<th>삭제</th>
				</tr>
			</thead>
			<tbody id='recruit_table'>

			</tbody>
		</table>
	</div>
	<!--e t1-->
</form>
<!--s 취소 모달-->
<div id="pop_applier" class="pop_modal2">
	<!--s pop_Box-->
	<div class="spop_Box c">
		<!--s pop_cont-->
		<div class="spop_cont">
			<div class="txt mg_b0">
				종합리포트만 표시됩니다.
			</div>
			<input id='member_idx' type='hidden' value=''>
			<ul id='applier_list'>
			</ul>
		</div>
		<!--e pop_cont-->

		<!--s spopBtn-->
		<div class="spopBtn radius_none">
			<a href="javascript:void(0)" class="spop_btn01" onclick="fnHidePop('pop_applier')">취소</a>
			<a id='selete_interview' href="javascript:void(0)" class="spop_btn02" onclick="fnHidePop('pop_applier')">선택</a>
		</div>
		<!--e spopBtn-->
	</div>
	<!--e pop_Box-->
</div>
<!--e 취소 모달-->

<script>
	let ajaxFlag = true;
	let objMemberList = {};
	let selectedMemberIdx = [];
	let selectedApplierIdx = {};
	const memberInput = $('#member_input');
	const memberSearch = $('#member_search')
	let selectedRecruitIdx = [];
	const recruitInput = $('#recruit_input');
	const recruitSearch = $('#recruit_search');
	const memberBox = $('#member_idx');

	$(document).on('click', function() { //클릭시 검색 박스 안보이게
		if (event.target.id != 'member_input') {
			memberSearch.closest('.sch_kwdBox').hide();
		}
		if (event.target.id != 'recruit_input') {
			recruitSearch.closest('.sch_kwdBox').hide();
		}
	});

	memberInput.on('click', function() {
		memberSearch.closest('.sch_kwdBox').show();
	});

	memberInput.on('input', function() { //지원자 검색
		const text = $(this).val();
		const successFunction = function(result) {
			const table = memberSearch;
			ajaxFlag = true;
			if (result.status === 200) {
				table.empty();
				for (row in result.item) {
					const memIdx = result.item[row]['idx'];
					let obj = {};

					for (column in result.item[row]) {
						obj[column] = result.item[row][column];
					}
					objMemberList[memIdx] = obj;
					table.append(getMemberSearchList(memIdx, obj));
				}
				table.closest('.sch_kwdBox').show();
			} else {
				table.closest('.sch_kwdBox').hide();
			}
		}
		if (ajaxFlag) {
			getAjax({
				'search-text': text
			}, '/api/member/read', successFunction);
		}
	});

	$(document).on('click', '.member_item', function() { //검색한 리스트 클릭
		const memIdx = $(this).data('idx-member1')
		const table = $('#member_table');

		if (in_array(memIdx, selectedMemberIdx)) {
			alert('이미 선택된 지원자 입니다.');
			return;
		}
		selectedMemberIdx.push(memIdx);
		table.append(selectedMemberList(objMemberList[memIdx]));
	});

	$(document).on('click', '.interview_modal', function() { //인터뷰 선택 모달
		const memIdx = $(this).val();
		const successFunction = function(result) {
			const table = $('#applier_list');
			memberBox.val(memIdx);
			ajaxFlag = true;
			table.empty();
			fnShowPop('pop_applier');
			if (result.status === 200) {
				for (row in result.item) {
					table.append(`
					<li>
						<input type='radio' name='applier' value='${result.item[row]['idx']}' 
						${result.item[row]['idx'] == selectedApplierIdx[memIdx] ? 'checked' : ''}>
						<a href='/prime/interview/view/detail/${result.item[row]['idx']}' target='_blank'>보러가기</a>
					</li>`);
				}
			} else {
				table.append('<li>인터뷰 없음</li>');
			}
		}
		if (ajaxFlag) {
			getAjax({
				'mem-idx': memIdx
			}, '/api/applier/read', successFunction);
		}
	});

	$('#selete_interview').on('click', function() {
		const applierIdx = $('#applier_list').find('input[name="applier"]:checked').val();
		const memberIdx = memberBox.val();
		selectedApplierIdx[memberIdx] = applierIdx;
		$(`[data-idx-member2="${memberIdx}"]`).append(`<input type='hidden' name='app_idx[]' value='${applierIdx}'>`);
	});

	recruitInput.on('click', function() {
		recruitSearch.closest('.sch_kwdBox').show();
	});

	recruitInput.on('input', function() { //공고 검색
		const text = $(this).val();
		const successFunction = function(result) {
			const table = recruitSearch;
			ajaxFlag = true;
			if (result.status === 200) {
				table.empty();
				for (row in result.item) {
					const recIdx = result.item[row]['idx'];
					let obj = {};

					for (column in result.item[row]) {
						obj[column] = result.item[row][column];
					}
					objMemberList[recIdx] = obj;
					table.append(getRecruitSearchList(recIdx, obj));
				}
				table.closest('.sch_kwdBox').show();
			} else {
				table.closest('.sch_kwdBox').hide();
			}
		}
		if (ajaxFlag) {
			getAjax({
				'search-text': text,
				'type': 'list'
			}, '/api/recruit/read', successFunction);
		}
	});

	$(document).on('click', '.recruit_item', function() {
		const recIdx = $(this).data('idx-recruit1')
		const table = $('#recruit_table');

		if (in_array(recIdx, selectedRecruitIdx)) {
			alert('이미 선택된 공고 입니다.');
			return;
		}
		selectedRecruitIdx.push(recIdx);

		const successFunction = function(result) {
			ajaxFlag = true;
			if (result.status === 200) {
				table.append(selectedRecruitList(result.item));
			}
		}

		if (ajaxFlag) {
			getAjax({
				'recruit-idx': recIdx,
				'type': 'detail'
			}, '/api/recruit/read', successFunction);
		}
	});

	$(document).on('click', '.member_delete_btn', function() {
		$(this).closest('tr').remove();
		const memIdx = $(this).data('idx-member2');
		const index = selectedMemberIdx.indexOf(memIdx);
		selectedMemberIdx.splice(index);
	});
	$(document).on('click', '.recruit_delete_btn', function() {
		$(this).closest('tr').remove();
		const recIdx = $(this).data('idx-recruit2');
		const index = selectedRecruitIdx.indexOf(recIdx);
		selectedRecruitIdx.splice(index);
	});

	//validate
	$.validator.setDefaults({
		onkeyup: false,
		onclick: false,
		onfocusout: false,
		showErrors: function(errorMap, errorList) {
			if (this.numberOfInvalids()) {
				// 에러가 있으면
				alert(errorList[0].message); // 경고창으로 띄움
			}
		}
	});

	$("#frm").validate({
		ignore: [],
		rules: {
			'app_idx[]': {
				required: true
			},
			'rec_idx[]': {
				required: true
			},
		},
		messages: {
			'app_idx[]': {
				required: "인터뷰를 선택해 주세요.",
			},
			'rec_idx[]': {
				required: "공고를 선택해 주세요.",
			},
		},
		submitHandler: function(form) {
			// form 전송 이외에 ajax등 어떤 동작이 필요할 때

			const memberCount = $('input[name="mem_idx[]"]').length;
			const applierCount = $('input[name="app_idx[]"]').length;

			if (!memberCount) {
				alert('지원자를 선택해 주세요.');
				return false;
			}

			if (memberCount != applierCount) {
				alert('선택한 지원자들의 인터뷰를 선택해 주세요.');
				return false;
			}

			if (!($('input[name="rec_idx[]"]').length)) {
				alert('공고를 선택해 주세요');
				return false;
			}

			form.submit();
		}
	});

	function arrayToString(array, type) {
		let string = '';
		if (type === 1) {
			for (i in array) {
				string += `<td>${array[i]}</td>`;
			}
		} else if (type === 2) {
			for (i in array) {
				string += `<span>${array[i]} | </span>`;
			}
		}
		return string;
	}

	function getMemberSearchList(idx, item) {
		const string = arrayToString(item, 2);
		const result = `<li class='member_item' data-idx-member1='${idx}'><a href="javascript:void(0)">${string}</a></li>`
		return result;
	}

	function getRecruitSearchList(idx, item) {
		const string = arrayToString(item, 2);
		const result = `<li class='recruit_item' data-idx-recruit1='${idx}'><a href="javascript:void(0)">${string}</a></li>`
		return result;
	}

	function selectedMemberList(array) {
		let string = arrayToString(array, 1);
		string += `<td><button type="button" class='interview_modal' value='${array['idx']}'>인터뷰 선택</button></td>`;
		string += `<td class='member_delete_btn' data-idx-member2='${array['idx']}'>삭제 <input type='hidden' name='mem_idx[]' value='${array['idx']}'></td>`;
		const result = `<tr>${string}</tr>`
		return result;
	}

	function selectedRecruitList(array) {
		let string = arrayToString(array, 1);
		string += `<td class='recruit_delete_btn' data-idx-recruit2='${array['recIdx']}'>삭제
		 <input type='hidden' name='rec_idx[]' value='${array['recIdx']}'>
		 <input type='hidden' name='com_idx[]' value='${array['comIdx']}'>
		 </td>`;
		const result = `<tr>${string}</tr>`
		return result;
	}

	function getAjax(aData, url, success) {
		ajaxFlag = false;
		$.ajax({
			url: url,
			type: 'get',
			dataType: "json",
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			data: aData,
			success: success,
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(textStatus);
			}
		});
	}
</script>