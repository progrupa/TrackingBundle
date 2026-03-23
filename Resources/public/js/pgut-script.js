/** ProGroup User Tracking script */
(function() {
    'use strict';

    var LS = window.localStorage;
    var UT = window._pgut;
    var TXT = {
        loop: 'pgut-redirect-loop',
        date: 'pgut-refresh-date'
    };
    var redirecting = false;

    function messageReceived (e) {
        var data;
        try { data = JSON.parse(e.data); } catch (err) { return; }
        if (data === null || typeof data !== 'object' || typeof data.event !== 'string' || typeof data.data === 'undefined') { return; }

        if (typeof LS !== 'undefined') {
            if (data.event === 'pgTrackingSaved') { /** Tracking was saved, no need to do it again, do not include the iframe anymore */
                var now = new Date();
                LS.setItem(TXT.date, new Date(now.setDate(now.getDate() + 365)).toString());
                LS.removeItem(TXT.loop);
            }

            if (data.event === 'pgSetCookie' && !redirecting) {
                var loop = LS.getItem(TXT.loop) ? parseInt(LS.getItem(TXT.loop), 10) : 0;
                if (loop < 2) { /** max two refresh */
                    redirecting = true;
                    var ref = (typeof UT.referer !== 'undefined') ? ('?referer='+ UT.referer) : '';
                    LS.setItem(TXT.loop, (++loop).toString());
                    window.location.href = UT.base +'pgut-set'+ ref;
                }
            }
        }
    }

    function appendIframe () {
        if (typeof UT.hash !== 'undefined') {
            var $frame = document.createElement('iframe');
            $frame.style.cssText = 'display:none !important;width:1px !important;height:1px !important;opacity:0 !important;pointer-events:none !important;';
            $frame.src = UT.base +'pgut-store/'+ UT.id +'/'+ UT.hash;
            var $body = document.body;

            if (typeof LS !== 'undefined') {
                var future = LS.getItem(TXT.date);
                if (typeof future !== 'undefined' && future !== null) {
                    var now = new Date();
                    if (now.getTime() >= new Date(future).getTime()) {
                        LS.removeItem(TXT.loop);
                        LS.removeItem(TXT.date);
                        $body.appendChild($frame);
                    }
                } else {
                    $body.appendChild($frame);
                }
            } else {
                $body.appendChild($frame);
            }
        }
    }

    var method = window.addEventListener ? 'addEventListener' : 'attachEvent';
    var trigger = window[method];
    trigger(((method === 'attachEvent') ? 'onload' : 'load'), appendIframe, false); /** Append iframe to body */
    trigger(((method === 'attachEvent') ? 'onmessage' : 'message'), messageReceived, false); /** Listen to message from child window */
})(window);
