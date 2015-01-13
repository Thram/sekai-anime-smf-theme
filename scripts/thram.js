/**
 * Created by thram on 12/01/15.
 */
var Thram = (function () {
    var currentAction = 'home';

    function init() {
        var $body = $('body'), mainSection = $('#content_section');

        $body.scrollTop(0);
        currentAction = $body.data('page');
        //$('.table_grid, .table_list').addClass('animated delayed fadeIn');
        if (currentAction === 'home') {
            mainSection.addClass('animated fadeInUp').show();
        }else{
            mainSection.show().children().first().addClass('animated fadeIn')
        }
    }

    function setSelect(id, val, label) {
        $(id).val(val);
        $(id + '-value').text(label);
    }

    return {
        setSelect: setSelect,
        init: init
    }
})();

$(window).load(function () {
    Thram.init();
});