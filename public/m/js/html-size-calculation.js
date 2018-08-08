(function (doc, win) {
    var docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function () {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            docEl.style.fontSize = 16 * (clientWidth / 320) + 'px';
        };
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
    if (/iP(hone|od|ad)/.test(navigator.userAgent)) {  //  就是放到html根节点上的   ios8现在普及率高了，可以省略
        var v = (navigator.appVersion).match(/OS (\d+)_(\d+)_?(\d+)?/), version = parseInt(
                v[1], 10);
        if (version >= 8) {
            document.documentElement.classList.add('hairlines')
        }
    };
})(document, window);