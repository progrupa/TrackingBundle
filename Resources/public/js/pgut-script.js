/**
 * User tracking script
 *
 * postMessage works > IE7
 * http://caniuse.com/#search=postMessage
 *
 * Include like this (with 3 params: URL, ID, HASH):

<script>
    (function(m,o,d,e,l){
        window._pgut={'id':o,'hash':d};e=document.createElement('script'),l=document.getElementsByTagName('script')[0];e.src=m;l.parentNode.insertBefore(e,l);
    })('http://md.dev/js/pgut-script.js','md','{{ app.request.cookies.get('mdutr') }}');
</script>

 * TODO: fix direct links
 **/

(function() {

    'use strict';

    var messageReceived = function(e) {
        var data;
        // Only allow messages from central tracker
        // Needs to be a regexp, not a direct match
        // if (e.origin !== "http://www.models.dev") {
        //     return;
        // }

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
            window.location.href = window._pgut.base + 'pgut-set';
            return;
        }
        if (data.event === 'pgTrackingSaved') {
            //  Tracking was saved, no need to do it again,
            //  do not include the iframe anymore?
            if (typeof window.localStorage !== 'undefined') {
                var tmp = new Date();
                var future = new Date(tmp.setDate(tmp.getDate() + 365));
                window.localStorage.setItem('_pgut_cookie', future);
            }
            return;
        }
    };

    var appendIframe = function() {
        if (window._pgut.hash) {
            if (typeof window.localStorage !== 'undefined') {
                var cookies = window.localStorage.getItem('_pgut_cookie');
                if (typeof cookies !== 'undefined' && cookies !== null) {
                    var now = new Date();
                    var future = new Date(cookies);
                    if (now.getTime() < future.getTime()) { //  future hasn't passed yet, return
                        return false;
                    }
                }
            }

            var iframe = document.createElement('iframe');
            iframe.style.display = "none";
            iframe.src = window._pgut.base + 'pgut-store/' + window._pgut.id + '/' + window._pgut.hash;
            document.body.appendChild(iframe);
        }
    };

    // Create IE + others compatible event handler
    var eventMethod = window.addEventListener ? 'addEventListener' : 'attachEvent';
    var eventer = window[eventMethod];

    // Append iframe to body
    var loadEvent = (eventMethod === 'attachEvent') ? 'onload' : 'load';
    eventer(loadEvent, appendIframe, false);

    // Listen to message from child window
    var messageEvent = (eventMethod === 'attachEvent') ? 'onmessage' : 'message';
    eventer(messageEvent, messageReceived, false);
})(window);
