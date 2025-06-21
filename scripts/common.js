/* common.js  */
//toaster
! function (p) {
    "use strict";

    function t() { }
    t.prototype.send = function (t, i, o, e, n, a, s, r) {
        var c = {
            heading: t,
            text: i,
            position: o,
            loaderBg: e,
            icon: n,
            hideAfter: a = a || 3e3,
            stack: s = s || 1
        };
        r && (c.showHideTransition = r), console.log(c), p.toast().reset("all"), p.toast(c)
    }, p.NotificationApp = new t, p.NotificationApp.Constructor = t
}(window.jQuery),
    function (i) {
        "use strict";
        
        //trigered on page load
        i.NotificationApp.send("Title", "On load success message", "top-center", "#5ba035", "success")
        //end on load code

        i("#toastr-three").on("click", function (t) {
            i.NotificationApp.send("Title", "Body message for success", "top-right", "#5ba035", "success")
        }), i("#toastr-four").on("click", function (t) {
            i.NotificationApp.send("Title for error", "Body message for error", "top-right", "#bf441d", "error")
        })
    }(window.jQuery);

//end toaster