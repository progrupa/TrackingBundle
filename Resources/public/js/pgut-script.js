/**
 * User tracking script
 *
 * postMessage works > IE7
 * http://caniuse.com/#search=postMessage
 **/

(function() {

    'use strict';

    var messageReceived = function(e) {
        var data;

        try {
            data = JSON.parse(e.data);
        }
        catch (err) {
            return;
        }

        if (typeof data !== 'object' || typeof data.event !== 'string' || typeof data.data === 'undefined') {
            return;
        }

        if (data.event === 'pgSetCookie') {
            var referer = '';
            if (typeof window._pgut.referer !== 'undefined') {
                referer = '?referer=' + window._pgut.referer;
            }
            if (typeof storage !== 'undefined') {
                var loop = storage.getItem('pgut-redirect-loop') || 1;
                if (loop < 3) {
                    storage.setItem('pgut-redirect-loop', ++loop);
                    window.location.href = window._pgut.base + 'pgut-set' + referer;
                }
            } else {
                window.location.href = window._pgut.base + 'pgut-set' + referer;
            }
        }

        if (data.event === 'pgTrackingSaved') {
            /** Tracking was saved, no need to do it again, do not include the iframe anymore */
            if (typeof storage !== 'undefined') {
                var tmp = new Date();
                var future = new Date(tmp.setDate(tmp.getDate() + 365));
                storage.setItem('pgut-refresh-date', future);
            }
        }
    };

    var appendIframe = function() {
        if (typeof window._pgut.hash !== 'undefined') {
            var iframe = document.createElement('iframe');
            iframe.style.cssText = 'display: none !important; width: 1px !important; height: 1px !important; opacity: 0 !important; pointer-events: none !important;';
            iframe.src = window._pgut.base + 'pgut-store/' + window._pgut.id + '/' + window._pgut.hash;

            if (typeof storage !== 'undefined') {
                var cookies = storage.getItem('pgut-refresh-date');
                if (typeof cookies !== 'undefined' && cookies !== null) {
                    var now = new Date();
                    var future = new Date(cookies);
                    if (now.getTime() >= future.getTime()) {
                        storage.removeItem('pgut-redirect-loop');
                        document.body.appendChild(iframe);
                    }
                } else {
                    document.body.appendChild(iframe);

                }
            } else {
                document.body.appendChild(iframe);
            }
        }
    };

    var storage = window.localStorage;

    /** Create IE + others compatible event handler */
    var eventMethod = window.addEventListener ? 'addEventListener' : 'attachEvent';
    var eventer = window[eventMethod];

    /** Append iframe to body */
    var loadEvent = (eventMethod === 'attachEvent') ? 'onload' : 'load';
    eventer(loadEvent, appendIframe, false);

    /** Listen to message from child window */
    var messageEvent = (eventMethod === 'attachEvent') ? 'onmessage' : 'message';
    eventer(messageEvent, messageReceived, false);
})(window);
