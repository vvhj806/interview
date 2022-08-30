var win = $(window), doc = $(document);
var divWidth;

$(document).ready(function () {
	contScroll();

	$('.mu_2').each(function () {
		const thisEle = $(this);
		if (thisEle.hasClass('on')) {
			thisEle.closest('.detail_list').siblings('.tlt').addClass('on');
		}
	});

	//왼쪽네비
	$('.tlt').each(function () {
		const thisEle = $(this);
		if (thisEle.hasClass('on')) {
			thisEle.siblings('.detail_list').show();
		}
	});

	//탭 슬라이드 (공통으로 사용)
	$(".depth").slick({
		dots: false,
		arrows: false,
		infinite: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 250,
		autoplay: false,
		variableWidth: true
	});

	//탭2 더보기 (공통으로 사용)
	$(function () {
		$(".depth2 li").slice(0, 12).show(); //12부분에 보이는 탭버튼 숫자
		$("#tab_more").click(function (e) {
			e.preventDefault();
			$(".depth2 li:hidden").slice(0, 100).show(); //더보기 누르면 100개씩 보임
			if ($(".depth2 li:hidden").length == 0) {
				$('#tab_more').hide();
			}
		});
	});

	// 탭 컨텐츠 숨기기
	$(".tab_content").hide();

	// 첫번째 탭콘텐츠 보이기
	$(".tabsBox").each(function () {
		$(this).children(".tabs li:first").addClass("active"); //Activate first tab
		//$(this).children(".tab_content").first().show();
		$(this).children(".tab_content.fast").show();
	});
	//탭메뉴 클릭 이벤트
	$(".tabs li a").click(function () {

		$(this).parent().siblings("li").removeClass("active");
		$(this).parent().addClass("active"); $(this).parent().parent().parent().parent().find(".tab_content").hide();
		var activeTab = $(this).attr("rel");
		$("#" + activeTab).fadeIn();
	});

	/*셀렉트 검색 여러개사용할때*/
	$('.dropdown2').hide();
	$('.dropdown dt a').click(function () {
		$(this).toggleClass("myclass");
		$(this).closest('.dropdown').find('.dropdown2').toggle();
	});

	$('.dropdown dd ul li a').click(function (e) {
		$(this).closest('.dropdown').find('.dropdown2').toggle();
		var text = $(this).html();
		$(this).closest('.dropdown').find('dt a').toggleClass('myclass');
		$(this).closest('.dropdown').find('dt a').html(text);
		$(this).closest('.dropdown').find('.dropdown2').hide();
		//$("#result").html("Selected value is: " + getSelectedValue("sample"));
	});
});

//왼쪽네비
$(document).on('click', '.tlt', function () {
	$(this).toggleClass('on').siblings('.detail_list').slideToggle();
	$(this).parent('li').siblings('li').find('.detail_list').slideUp().siblings('.tlt').removeClass('on');
});

//2차모달 (공통)
function fnShowPop(sGetName) {
	var $layer = $("#" + sGetName);
	var mHeight = $layer.find(".md_pop_content").height() / 2;
	$layer.addClass("on");
}

function fnHidePop(sGetName) {
	$("#" + sGetName).removeClass("on");
}

//해당 스크롤위치에서 클래스적용
function contScroll() {
	var $body = $('body');

	$(window).scroll(function () {
		if ($(this).scrollTop() > 30) {
			$body.addClass("top_scroll");
		} else {
			$body.removeClass("top_scroll");
		}
	});
}