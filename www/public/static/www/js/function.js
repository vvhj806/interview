const filter = ["ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ", "ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ"];
const chartColors = ['#525DF5', '#25bcc1', '#a19090', '#b51616', '#246376', '#925fb9', '#81bd53', '#81bd53', '#81bd53', '#81bd53', '#f3ff00dd', '#8eb1ff', '#f36565'];
function alert2(text) {
    const box = $('#alert');
    box.finish();
    box.fadeIn(300, 'swing');
    box.text(text);
    setTimeout(function () {
        box.fadeOut(1500, 'swing');
    }, 1000);
}

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

function resumeDelBtnSet(cloneForm) {
    cloneForm.find('.del_btn').removeClass('hide');
    cloneForm.find('.del_btn').find('a').addClass('remove_btn');
    cloneForm.find('.del_btn').find('a').attr('href', 'javascript:void(0)')
}

function arrayIsEmpty2D(array) {
    result = false;
    for (i in aSpeech) {
        if (aSpeech[i].length) {
            result = false;
            break;
        }
        result = true;
    }

    return result;
}