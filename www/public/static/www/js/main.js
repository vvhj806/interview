//메인 슬라이드
function setProgressbar(totalSlide, currentSlide) {
	var calc = 100 / totalSlide;
	calc *= (currentSlide + 1);

	$('.progress')
		.css('background-size', calc + '% 100%')
		.attr('aria-valuenow', calc);
	$('.slider__label').text(calc + '% completed');
}
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

	//메인 슬라이드
	var $slider = $('.main_sl');
	$slider.on('init', function (event, slick) {
		setProgressbar(slick.slideCount, 0);
	});
	$slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
		setProgressbar(slick.slideCount, nextSlide);
	});

	$slider.slick({
		//dots: true,
		arrows: false,
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 250,
		autoplay: true,
		autoplaySpeed: 3500
	});


	//내 맘에 쏙 드는 회사 찾기
	$('.company_fd_sl').slick({
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

	//웹기획.PM 찾는중
	$('.lkf_sl').slick({
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


	//실제 면접 질문 연습하기
	$('.qs_sl').slick({
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
					slidesToShow: 2,
					slidesToScroll: 2,
				}
			}
		]
	});

	//AI 레포트 구경가기
	$('.ai_report_sl').slick({
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

	//하단배너
	var $status = $('.mbottom_bn_slBox .pagingInfo');
	var $slickElement = $('.mbottom_bn_slBox .mbottom_bn_sl');
	$slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
		//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
		var i = (currentSlide ? currentSlide : 0) + 1;
		//$status.text(i + '/' + slick.slideCount);
		//   $('.mbottom_bn_slBox .control_box').find('.pagingInfo').html('<span class="slideCountAll">' + slick.slideCount  + '</span> / <span class="slideCountItem">' + i + '</span>');
		$('.mbottom_bn_slBox .control_box').find('.pagingInfo').html('<span class="slideCountAll">' + i + '</span> / <span class="slideCountItem">' + slick.slideCount + '</span>');
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
		autoplay: true,
		speed: 250,
		autoplaySpeed: 3500
	});
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