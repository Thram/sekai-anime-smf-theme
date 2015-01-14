/**
 * Created by thram on 12/01/15.
 */
var Thram = (function () {
    var page = 'home';

    function _animateElement(element, animateClass, delay, duration) {
        element.addClass('animated').addClass(animateClass).css({
            '-webkit-animation-delay': delay + 'ms', /* Safari 4+ */
            '-moz-animation-delay': delay + 'ms', /* Fx 5+ */
            '-o-animation-delay': delay + 'ms', /* Opera 12+ */
            'animation-delay': delay + 'ms'
        });
        if (duration) {
            $(this).css({
                '-webkit-animation-duration': duration + 'ms', /* Safari 4+ */
                '-moz-animation-duration': duration + 'ms', /* Fx 5+ */
                '-o-animation-duration': duration + 'ms', /* Opera 12+ */
                'animation-duration': duration + 'ms'
            });
        }
    }

    function _animateSequence(elements, animateClass, timeDelay, timeDuration) {
        elements.each(function (index) {
            var delay = timeDelay * index;
            _animateElement($(this), animateClass, delay, timeDuration);
        });
    }

    function init() {
        var $body = $('body'), mainSection = $('#content_section');

        $body.scrollTop(0);
        page = $body.data('page');
        //$('.table_grid, .table_list').addClass('animated delayed fadeIn');
        mainSection.show();
        var totalAnimations = 0;
        var elements = undefined;
        var delay = 300;
        var duration = 400;
        switch (page) {
            case 'home':
                var leftElements = mainSection.find('#sp_left .sp_block_section, #sp_left .sp_block_section_last');
                var centerElements = mainSection.find('#sp_center .sp_block_section, #sp_center .sp_article_content, #sp_center .sp_page_index');
                var rightElements = mainSection.find('#sp_right .sp_block_section, #sp_right .sp_block_section_last');
                _animateSequence(leftElements, 'fadeInUp', delay, duration);
                _animateSequence(centerElements, 'fadeInUp', delay, duration);
                _animateSequence(rightElements, 'fadeInUp', delay, duration);
                totalAnimations = Math.max.apply(Math, [leftElements.length, centerElements.length, rightElements.length]);
                break;
            case 'help':
                elements = $('.help #sp_main');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'search':
                elements = mainSection.find('fieldset');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'login':
                elements = mainSection.find('#sp_main');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'register':
                elements = mainSection.find('.registration-agreement, #confirm_buttons');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            default :
                elements = mainSection.find('.table_list, .actions, .info-center');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
        }
        _animateElement($('#footer_section'), 'fadeInUp', delay * totalAnimations, duration);
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