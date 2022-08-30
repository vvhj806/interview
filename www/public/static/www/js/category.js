function depth1IsOn(detph1Value) {
    $('.second_duty>li').hide();
    if ($(`li[data-depth1="${detph1Value}"]`).length) {
        $(`li[data-depth1="${detph1Value}"]`).show();
    }
}

function depth2IsOn(depth2Label) {
    const icon = depth2Label.find('i');
    const ul = depth2Label.next('ul');

    ul.slideDown();
    icon.removeClass('la-plus');
    icon.addClass('la-minus');
}

function depth2IsOff(depth2Label) {
    const icon = depth2Label.find('i');
    const ul = depth2Label.next('ul');

    ul.slideUp();
    icon.addClass('la-plus');
    icon.removeClass('la-minus');
}

function depth2IsOnType(depth2Label) {
    depthValue = $(depth2Label).prev('input').val();

    const depth1 = $(depth2Label).closest('li').data('depth1');
    // $('.depth2').removeClass('on');
    // depth2IsOff($('.depth2'));
    depth2Label.addClass('on');
    $(`[data-depth1=${depth1}]`).find('input[name="depth3[]"]').each(function () {
        if ($(this).closest('ul').closest('li').find('input').val() != depthValue) {
            $(this).prop('checked', false).trigger('change');
        }
    });
    depth2IsOn(depth2Label);
}

function depth2IsOffType(depth2Label) {
    depth2Label.removeClass('on');
    depth2IsOff(depth2Label);
}

function depth2Toggle(depth2Label) {
    const icon = depth2Label.find('i');
    const ul = depth2Label.next('ul');

    ul.slideToggle();
    icon.toggleClass('la-plus');
    icon.toggleClass('la-minus');
}

function depth3IsOn(depth3Ul) {
    const label = depth3Ul.prev('label');
    const icon = label.find('i');
    label.addClass('on');

    depth3Ul.prev('.depth2').prev('input').prop('checked', true);
    depth3Ul.slideDown();
    icon.removeClass('la-plus');
    icon.addClass('la-minus');
}

function depth3IsOff(depth3Ul) {
    if (depth3Ul.find('input[type="checkbox"]:checked').length == 0) {
        depth3Ul.prev('.depth2').prev('input').prop('checked', false);
        depth2IsOffType(depth3Ul.prev('label'));
    } else {
        depth3Ul.prev('.depth2').prev('input').prop('checked', true);
    }
}

function searchScroll(scrollTap, scrollHeight) {
    scrollTap.animate({
        scrollTop: scrollTap.scrollTop() + scrollHeight
    }, Math.abs(scrollHeight) * 2);
}

function getSearch(keyword) {
    let result = [];

    for (let idx in searchCategory) {
        if (searchCategory[idx].toLowerCase().indexOf(keyword) != -1) {
            result.push({
                'idx': idx,
                'name': searchCategory[idx]
            });
        }
    }

    if (result) {
        $('.cate_search_pop').removeClass('hide');
        $('.cate_search_list').empty();
        for (let idx in result) {
            $('.cate_search_list').append(`<li data-search='${result[idx]['idx']}'>${result[idx]['name']}</li>`);
        }
    }
}