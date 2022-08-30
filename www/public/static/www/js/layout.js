$(document).ready(function () {
	contScroll();

	//해당 스크롤위치에서 클래스적용
	function contScroll() {
		var $toTop = $('.q_topBtn');

		//상단으로 이동
		$('html,body').scrollTop();
		$toTop.click(function (e) {
			e.preventDefault();
			$('html, body').animate({
				scrollTop: 0
			}, 400, 'swing');
		});
	}

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

	//팀원 모집 중
	$('.team_mb_sl').slick({
		dots: false,
		autoplay: false,
		arrows: false,
		infinite: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 250,
		//centerMode: true,
		autoplay: false
	});

	//기업탐색 배너
	$('.cs_bn_sl').slick({
		dots: false,
		autoplay: false,
		arrows: false,
		infinite: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 250,
		//centerMode: true,
		autoplay: false
	});

	//기업상세
	$('.company_sl').slick({
		dots: false,
		autoplay: false,
		arrows: false,
		infinite: false,
		variableWidth: true,
		slidesToShow: 4,
		slidesToScroll: 1,
		speed: 250,
		//centerMode: true,
		autoplay: false
	});

	//기업상세
	$('.guide_sl').slick({
		dots: true,
		autoplay: false,
		arrows: false,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 250,
		//centerMode: true,
		autoplay: false
	});

	//이런 공고 어떠세요 리스트
	$('.acm_sl').slick({
		dots: false,
		autoplay: false,
		arrows: false,
		infinite: false,
		slidesToShow: 2,
		slidesToScroll: 2,
		speed: 250,
		variableWidth: true,
		//centerMode: true,
		autoplay: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}
		]
	});

	//이런 기업 어떠세요 리스트
	$('.cpt_sl').slick({
		dots: false,
		autoplay: false,
		arrows: false,
		infinite: false,
		slidesToShow: 2,
		slidesToScroll: 2,
		speed: 250,
		variableWidth: true,
		//centerMode: true,
		autoplay: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}
		]
	});

	//답변별 점수 영상리스트
	$('.id_video_sl').slick({
		dots: false,
		autoplay: false,
		arrows: false,
		infinite: false,
		slidesToShow: 2,
		slidesToScroll: 2,
		speed: 250,
		variableWidth: true,
		//centerMode: true,
		autoplay: false,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}
		]
	});


	//채용 뷰페이지 슬라이드 배너
	var $status = $('.rcm_vslBox .pagingInfo');
	var $slickElement = $('.rcm_vslBox .rcm_vsl');
	$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
		//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
		var i = (currentSlide ? currentSlide : 0) + 1;
		//$status.text(i + '/' + slick.slideCount);
		$('.rcm_vslBox .control_box').find('.pagingInfo').html('<span class="slideCountAll">' + slick.slideCount + '</span> / <span class="slideCountItem">' + i + '</span>');
	});
	var $slickCount = $(".main_slBox02 .msec_slider .item").length;
	var $slickDots = $(".main_slBox02").find(".slick-dots").html("");
	for (i = 0; i < $slickCount; i++) {
		if (i == 0)
			$('<li class="slick-active"><button type="button" tabindex="0">1a</button></li>').appendTo($slickDots);
		else
			$('<li><button type="button" tabindex="' + i + '">' + (i + 1) + 'a</button></li>').appendTo($slickDots);
	}
	//$slickSlideToShow=$(window).width()>4000?4:$(window).width()>1000?3:3;
	//console.log($slickSlideToShow)
	$slickElement.slick({
		dots: false,
		arrows: false,
		//slidesToShow: $slickSlideToShow,
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		autoplay: false,
		speed: 250,
		//autoplaySpeed: 3500
	});

	//탭기능
	$(function () {
		$(".tab_content").hide();
		$(".tab_content.fast").show();

		$("ul.tabs li").click(function () {
			$("ul.tabs li").removeClass("active");
			//$(this).addClass("active").css({"color": "darkred","font-weight": "bolder"});
			$(this).addClass("active");
			$(".tab_content").hide()
			var activeTab = $(this).attr("rel");
			$("#" + activeTab).fadeIn()
		});
	});

	//탭기능
	$(function () {
		$(".all_tab_content").hide();
		$(".all_tabsBox").each(function () {
			$(this).children(".all_tabs li:first").addClass("active"); //Activate first tab
			$(this).children(".all_tab_content").first().show();
		});

		$(".all_tabs li a").click(function () {
			$(this).parent().siblings("li").removeClass("active");
			$(this).parent().addClass("active"); $(this).parent().parent().parent().parent().find(".all_tab_content").hide();
			var activeTab = $(this).attr("rel");
			$("#" + activeTab).fadeIn();
		});
	});
});

//2차모달 (공통)
function fnShowPop(sGetName) {
	var $layer = $("#" + sGetName);
	var mHeight = $layer.find(".md_pop_content").height() / 2;
	$layer.addClass("on");
	// $('body').css('overflow', 'hidden');
}

function fnHidePop(sGetName) {
	$("#" + sGetName).removeClass("on");
	// $('body').css('overflow', 'auto');
}
