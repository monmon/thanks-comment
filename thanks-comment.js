if (typeof window.Monmon === "undefined") window.Monmon = {};
if (typeof Monmon.Thanks === "undefined") Monmon.Thanks = {};
Monmon.Thanks.jQuery = jQuery.noConflict(true);

(function($){
    $(function(){
        var currentUrl = location.href.replace(/#(.*)$/, '');
        var thanksParamCode = (/\?/.exec(currentUrl)) ? '&'
                            :                           '?'
                            ;

        var hiddenThanks;
        // there is thanks param in query string.
        //if (thanksParamCode === '&') {
        //    var m = /[\?&]thanks=(comment-\d+)(?:[\d]|$)/.exec(currentUrl);
        //    if (m != null) {
        //        hiddenThanks = m[1];
        //    }
        //}
        var m;
        if ((thanksParamCode === '&')
            && (m = /[\?&]thanks=(comment-\d+)(?:[\d]|$)/.exec(currentUrl))) {
                hiddenThanks = m[1];
        }
    
        $('.row-actions').each(function(){
            $div = $(this);
            var commentId = $div.parents('tr').attr('id');
            if (commentId === hiddenThanks) return;

            var thanksParam = 'thanks=' + commentId;

            $div
            .append("<span>")
            .find(":last")
                .attr("class", "thanks")
                .text(" | ")
                .append("<a>")
                .find(":last")
                    .attr("href", [currentUrl, thanksParamCode, thanksParam].join(''))
                    .append("感謝の意を述べる");

        })
        //$(".row-actions")
        //    .append("<span>")
        //    .find(":last")
        //        .attr("class", "thanks")
        //        .text(" | ")
        //        .append("<a>")
        //        .find(":last")
        //            .attr("href", [currentUrl, thanksParamCode, 'thanks=1'].join(''))
        //            .append("感謝の意を述べる")
    });
})(Monmon.Thanks.jQuery)
