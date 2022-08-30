function encodeUnicode(convertString) {
    let unicodeString = '';
    for (let i = 0, max = convertString.length; i < max; i++) {
        let theUnicode = convertString.charCodeAt(i).toString(16);

        while (theUnicode.length < 4) {
            theUnicode = '0' + theUnicode;
        }

        theUnicode = 'u' + theUnicode;
        unicodeString += theUnicode;
    }

    return unicodeString;
}

function decodeUnicode(unicodeString) {
    var r = /\u([\d\w]{4})/gi;
    unicodeString = unicodeString.replace(r, function (match, grp) {
        return String.fromCharCode(parseInt(grp, 16));
    });
    return unescape(unicodeString);
}

function in_array(needle, haystack) {
    const length = haystack.length;
    for (let i = 0; i < length; i++) {
        if (haystack[i] == needle) return true;
    }
    return false;
}

function leftNavToggle() {
    const paddingLeft = $('#container_wrap').css('padding-left');
    let paddingLeftValue = '';
    if (paddingLeft == '220px') {
        paddingLeftValue = '0px';
    } else if (paddingLeft == '0px') {
        paddingLeftValue = '220px';
    }
    $('body').toggleClass('on');
    $('#container_wrap').css('padding-left', paddingLeftValue);
    $('.naviBox').toggle();
}

$(document).on('click', '.nav_con', function () {
    leftNavToggle();
});