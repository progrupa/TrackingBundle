/** ProGroup User Tracking script */
(function() {
    'use strict';

    const LS = window.localStorage;
    const UT = window._pgut;
    const TX = {
        loop: 'pgut-redirect-loop',
        date: 'pgut-refresh-date'
    };

    function messageReceived (e) {
        let data;
        try { data = JSON.parse(e.data); } catch (err) { return; }
        if (typeof data !== 'object' || typeof data.event !== 'string' || typeof data.data === 'undefined') { return; }

        if (typeof LS !== 'undefined') {
            if (data.event === 'pgTrackingSaved') { /** Tracking was saved, no need to do it again, do not include the iframe anymore */
            const now = new Date();
                LS.setItem(TX.date, new Date(now.setDate(now.getDate() + 365)).toString());
            }

            if (data.event === 'pgSetCookie') {
                let loop = LS.getItem(TX.loop) ? parseInt(LS.getItem(TX.loop), 10) : 0;
                if (loop < 2) { /** max two refresh */
                const ref = (typeof UT.referer !== 'undefined') ? ('?referer='+ UT.referer) : '';
                    LS.setItem(TX.loop, (++loop).toString());
                    window.location.href = UT.base +'pgut-set'+ ref;
                }
            }
        }
    }

    function appendIframe () {
        if (typeof UT.hash !== 'undefined') {
            const $frame = document.createElement('iframe');
            $frame.style.cssText = 'display:none !important;width:1px !important;height:1px !important;opacity:0 !important;pointer-events:none !important;';
            $frame.src = UT.base +'pgut-store/'+ UT.id +'/'+ UT.hash;
            const $body = document.body;

            if (typeof LS !== 'undefined') {
                const future = LS.getItem(TX.date);
                if (typeof future !== 'undefined' && future !== null) {
                    const now = new Date();
                    if (now.getTime() >= new Date(future).getTime()) {
                        LS.removeItem(TX.loop);
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

    const method = window.addEventListener ? 'addEventListener' : 'attachEvent';
    const trigger = window[method];
    trigger(((method === 'attachEvent') ? 'onload' : 'load'), appendIframe, false); /** Append iframe to body */
    trigger(((method === 'attachEvent') ? 'onmessage' : 'message'), messageReceived, false); /** Listen to message from child window */
})(window);
