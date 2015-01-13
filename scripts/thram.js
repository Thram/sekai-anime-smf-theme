/**
 * Created by thram on 12/01/15.
 */
var Thram = (function () {
    var currentAction = 'home';

    function _animateSequence(elements, animateClass, timeDelay, timeDuration) {
        elements.each(function (index) {
            var delay = timeDelay * index;
            $(this).addClass('animated').addClass(animateClass).css({
                '-webkit-animation-delay': delay + 'ms', /* Safari 4+ */
                '-moz-animation-delay': delay + 'ms', /* Fx 5+ */
                '-o-animation-delay': delay + 'ms', /* Opera 12+ */
                'animation-delay': delay + 'ms'
            });
            if (timeDuration) {
                $(this).css({
                    '-webkit-animation-duration': timeDuration + 'ms', /* Safari 4+ */
                    '-moz-animation-duration': timeDuration + 'ms', /* Fx 5+ */
                    '-o-animation-duration': timeDuration + 'ms', /* Opera 12+ */
                    'animation-duration': timeDuration + 'ms'
                });
            }
        });
    }

    function init() {
        var $body = $('body'), mainSection = $('#content_section');

        $body.scrollTop(0);
        currentAction = $body.data('page');
        //$('.table_grid, .table_list').addClass('animated delayed fadeIn');
        if (currentAction === 'home') {
            mainSection.show();
            _animateSequence(mainSection.find('#sp_left .sp_block_section, #sp_left .sp_block_section_last .sp_article_content'), 'fadeInUp', 200, 400);
            _animateSequence(mainSection.find('#sp_center .sp_block_section, #sp_center .sp_block_section_last .sp_article_content'), 'fadeInUp', 200, 400);
            _animateSequence(mainSection.find('#sp_right .sp_block_section, #sp_right .sp_block_section_last .sp_article_content'), 'fadeInUp', 200, 400);
        } else {
            mainSection.show();
            _animateSequence(mainSection.find('.table_list, .actions, .info-center'), 'fadeInUp', 200, 400);
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
})
();

$(window).load(function () {
    Thram.init();
});