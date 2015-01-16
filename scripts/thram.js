/**
 * Created by thram on 12/01/15.
 */
var Thram = (function () {
    var page = 'home', $mainSection, $body;

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

    function _applyPageAnimation() {
        page = $body.data('page');
        var totalAnimations = 0;
        var elements = undefined;
        var delay = 300;
        var duration = 400;
        switch (page) {
            case 'home':
                var leftElements = $mainSection.find('#sp_left .sp_block_section, #sp_left .sp_block_section_last');
                var centerElements = $mainSection.find('#sp_center .sp_block_section, #sp_center .sp_article_content, #sp_center .sp_page_index');
                var rightElements = $mainSection.find('#sp_right .sp_block_section, #sp_right .sp_block_section_last');
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
                elements = $mainSection.find('fieldset');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'login':
                elements = $mainSection.find('#sp_main');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'register':
                elements = $mainSection.find('.registration-agreement, #confirm_buttons');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'board':
                elements = $mainSection.find('.pagesection, .table_grid,  #topic_icons, #forumposts, #sp_main .navigate_section, #moderationbuttons, .plainbox');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            case 'post':
                elements = $mainSection.find('.pagesection, #sp_main form, .navigate_section, .plainbox');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
                break;
            default :
                elements = $mainSection.find('.pagesection, .table_list, .actions, .info-center, .navigate_section');
                _animateSequence(elements, 'fadeInUp', delay, duration);
                totalAnimations = elements.length;
        }
        _animateElement($('#footer_section'), 'fadeInUp', delay * totalAnimations, duration);
    }

    function _initLoginForm() {
        var loginForm = $('#guest_form');

        function _closeLoginForm(e) {
            if (!loginForm.is(e.target) // if the target of the click isn't the container...
                && loginForm.has(e.target).length === 0) // ... nor a descendant of the container
            {
                loginForm.removeClass('show');
                $('#login-tab').removeClass('show');
                $(document).off('mouseup', _closeLoginForm)
            }
        }

        $('#login-tab').click(function () {
            $(this).addClass('show');
            loginForm.addClass('show');
            $(document).on('mouseup', _closeLoginForm);
        });
    }

    function _initInputs() {
        $('input:not(:checkbox):not(:button):not(:submit):not(:radio)').addClass('form-control input-sm');
    }

    function init() {
        $body = $('body');
        $body.scrollTop(0);
        $mainSection = $('#content_section');
        $mainSection.show();
        _applyPageAnimation();
        _initLoginForm();
        _initInputs();
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