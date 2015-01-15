<?php
/**
 * Simple Machines Forum (SMF)
 *
 * @package Sekai Anime
 * @author Thram
 * @copyright 2015 Thram
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0
 */

/*	This template is, perhaps, the most important template in the theme. It
	contains the main template layer that displays the header and footer of
	the forum, namely with main_above and main_below. It also contains the
	menu sub template, which appropriately displays the menu; the init sub
	template, which is there to set the theme up; (init can be missing.) and
	the linktree sub template, which sorts out the link tree.

	The init sub template should load any data and set any hardcoded options.

	The main_above sub template is what is shown above the main content, and
	should contain anything that should be shown up there.

	The main_below sub template, conversely, is shown after the main content.
	It should probably contain the copyright statement and some other things.

	The linktree sub template should display the link tree, using the data
	in the $context['linktree'] variable.

	The menu sub template should display all the relevant buttons the user
	wants and or needs.

	For more information on the templating system, please see the site at:
	http://www.simplemachines.org/
*/

// Initialize the template... mainly little settings.
function template_init() {
    global $context, $settings, $options, $txt;

    /* Use images from default theme when using templates from the default theme?
        if this is 'always', images from the default theme will be used.
        if this is 'defaults', images from the default theme will only be used with default templates.
        if this is 'never' or isn't set at all, images from the default theme will not be used. */
    $settings['use_default_images'] = 'never';

    /* What document type definition is being used? (for font size and other issues.)
        'xhtml' for an XHTML 1.0 document type definition.
        'html' for an HTML 4.01 document type definition. */
    $settings['doctype'] = 'xhtml';

    /* The version this template/theme is for.
        This should probably be the version of SMF it was created for. */
    $settings['theme_version'] = '2.0';

    /* Set a setting that tells the theme that it can render the tabs. */
    $settings['use_tabs'] = true;

    /* Use plain buttons - as opposed to text buttons? */
    $settings['use_buttons'] = true;

    /* Show sticky and lock status separate from topic icons? */
    $settings['separate_sticky_lock'] = true;

    /* Does this theme use the strict doctype? */
    $settings['strict_doctype'] = false;

    /* Does this theme use post previews on the message index? */
    $settings['message_index_preview'] = false;

    /* Set the following variable to true if this theme requires the optional theme strings file to be loaded. */
    $settings['require_theme_strings'] = false;
}

// The main sub template above the content.
function template_html_above() {
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    // Show right to left and the character set for ease of translating.
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"', $context['right_to_left'] ? ' dir="rtl"' : '', '>
<head>';

    // The ?fin20 part of this link is just here to make sure browsers don't cache it wrongly.
    echo '
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/bootstrap.min.css?fin20" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/animate.css?fin20" />
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/index', $context['theme_variant'], '.css?fin20" />';

    // Some browsers need an extra stylesheet due to bugs/compatibility issues.
    foreach (array('ie7', 'ie6', 'webkit') as $cssfix) if ($context['browser']['is_' . $cssfix]) echo '
	<link rel="stylesheet" type="text/css" href="', $settings['default_theme_url'], '/css/', $cssfix, '.css" />';

    // RTL languages require an additional stylesheet.
    if ($context['right_to_left']) echo '
	<link rel="stylesheet" type="text/css" href="', $settings['theme_url'], '/css/rtl.css" />';

    // Here comes the JavaScript bits!
    echo '
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/jquery.min.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/bootstrap.min.js?fin20"></script>
	<script type="text/javascript" src="', $settings['default_theme_url'], '/scripts/script.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/theme.js?fin20"></script>
	<script type="text/javascript" src="', $settings['theme_url'], '/scripts/thram.js?fin20"></script>
	<script type="text/javascript"><!-- // --><![CDATA[
		var smf_theme_url = "', $settings['theme_url'], '";
		var smf_default_theme_url = "', $settings['default_theme_url'], '";
		var smf_images_url = "', $settings['images_url'], '";
		var smf_scripturl = "', $scripturl, '";
		var smf_iso_case_folding = ', $context['server']['iso_case_folding'] ? 'true' : 'false', ';
		var smf_charset = "', $context['character_set'], '";', $context['show_pm_popup'] ? '
		var fPmPopup = function ()
		{
			if (confirm("' . $txt['show_personal_messages'] . '"))
				window.open(smf_prepareScriptUrl(smf_scripturl) + "action=pm");
		}
		addLoadEvent(fPmPopup);' : '', '
		var ajax_notification_text = "', $txt['ajax_in_progress'], '";
		var ajax_notification_cancel_text = "', $txt['modify_cancel'], '";
	// ]]></script>';

    echo '
	<meta http-equiv="Content-Type" content="text/html; charset=', $context['character_set'], '" />
	<meta name="description" content="', $context['page_title_html_safe'], '" />', !empty($context['meta_keywords']) ? '
	<meta name="keywords" content="' . $context['meta_keywords'] . '" />' : '', '
	<title>', $context['page_title_html_safe'], '</title>';

    // Please don't index these Mr Robot.
    if (!empty($context['robot_no_index'])) echo '
	<meta name="robots" content="noindex" />';

    // Present a canonical url for search engines to prevent duplicate content in their indices.
    if (!empty($context['canonical_url'])) echo '
	<link rel="canonical" href="', $context['canonical_url'], '" />';

    // Show all the relative links, such as help, search, contents, and the like.
    echo '
	<link rel="help" href="', $scripturl, '?action=help" />
	<link rel="search" href="', $scripturl, '?action=search" />
	<link rel="contents" href="', $scripturl, '" />';

    // If RSS feeds are enabled, advertise the presence of one.
    if (!empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged'])) echo '
	<link rel="alternate" type="application/rss+xml" title="', $context['forum_name_html_safe'], ' - ', $txt['rss'], '" href="', $scripturl, '?type=rss;action=.xml" />';

    // If we're viewing a topic, these should be the previous and next topics, respectively.
    if (!empty($context['current_topic'])) echo '
	<link rel="prev" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=prev" />
	<link rel="next" href="', $scripturl, '?topic=', $context['current_topic'], '.0;prev_next=next" />';

    // If we're in a board, or a topic for that matter, the index will be the board's index.
    if (!empty($context['current_board'])) echo '
	<link rel="index" href="', $scripturl, '?board=', $context['current_board'], '.0" />';

    // Output any remaining HTML headers. (from mods, maybe?)
    echo $context['html_headers'];
    $page = $_GET['action'] ? $_GET['action'] : ($_GET['board'] ? 'board' : ($_GET['topic'] ? 'topic' : 'home'));
    echo '
</head>
<body data-page="', $page, '" class="', $page, '">';
}

function template_body_above() {
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    // Show the menu here, according to the menu sub template.
    template_menu();
    $page = $_GET['action'] ? $_GET['action'] : ($_GET['board'] ? 'board' : ($_GET['topic'] ? 'topic' : 'home'));
    if (!empty($context['show_login_bar']) && $page != 'login') {
        echo '
				<script type="text / javascript" src="', $settings['default_theme_url'], ' / scripts / sha1 . js"></script>
 				<a id="login-tab" class="slide-panel-tab">', $txt['login'], '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>
				<form id="guest_form" class="slide-panel form-inline" action="', $scripturl, ' ? action = login2" method="post" accept-charset="', $context['character_set'], '" ', empty($context['disable_login_hashing']) ? ' onsubmit="hashLoginPassword(this, \'' . $context['session_id'] . '\');"' : '', '>
					<div class="info">', sprintf($txt['welcome_guest'], $txt['guest_title']), '</div>
					<input type="text" name="user" size="10" class="input_text" placeholder="Nick"/>
					<input type="password" name="passwrd" size="10" class="input_password" placeholder="****" />
					<select id="cookielength" name="cookielength">
						<option value="60">', $txt['one_hour'], '</option>
						<option value="1440">', $txt['one_day'], '</option>
						<option value="10080">', $txt['one_week'], '</option>
						<option value="43200">', $txt['one_month'], '</option>
						<option value="-1" selected="selected">', $txt['forever'], '</option>
					</select>

					<input type="submit" value="', $txt['login'], '" class="btn btn-primary btn-xs" /><br />
					<div class="info">', $txt['quick_login_dec'], '</div>';

        if (!empty($modSettings['enableOpenID'])) echo '
					<br /><input type="text" name="openid_identifier" id="openid_url" size="25" class="input_text openid_login" />';

        echo '
					<input type="hidden" name="hash_passwrd" value="" />
				</form>';
    }

    echo !empty($settings['forum_width']) ? '<div id="wrapper">' : '', '<div id="header" class="', $context['show_login_bar'] ? 'login-on' : '', '"><div class="frame">
		<a href="', $scripturl, '" id="top_section"></a>
		<div id="upper_section" class="middletext container-fluid"', empty($options['collapse_header']) ? '' : ' style="display: none;"', '>';

    // Show the navigation tree.
    theme_linktree();
    echo '
			<div class="news normaltext col-md-4 col-xs-12">
				<a href="https://www.facebook.com/pages/Sekai-Anime-Argentina/70737919050" title="Likeanos en Facebook :D" class="socicon socicon-facebook pull-left">b</a>
				<form id="search_form" class="col-lg-11 pull-right" action="', $scripturl, '?action=search2" method="post" accept-charset="', $context['character_set'], '">
					<div class="input-group">
					  <input type="text" name="search" value="" placeholder="', $txt['search'], '..." class="form-control" placeholder="Search for...">
					  <span class="input-group-btn">
						<button class="btn btn-sm btn-default" type="submit"><span style="padding: 3px 0;" class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					  </span>
					</div>
					<input type="hidden" name="advanced" value="0" />';

    // Search within current topic?
    if (!empty($context['current_topic'])) echo '
					<input type="hidden" name="topic" value="', $context['current_topic'], '" />'; // If we're on a certain board, limit it to this board ;).
    elseif (!empty($context['current_board'])) echo '
					<input type="hidden" name="brd[', $context['current_board'], ']" value="', $context['current_board'], '" />';

    echo '</form>';

    // Show a random news item? (or you could pick one from news_lines...)
    if (!empty($settings['enable_news'])) echo '
				<h2>', $txt['news'], ': </h2>
				<p>', $context['random_news_line'], '</p>';

    echo '
			</div>
		</div>';

    // Define the upper_section toggle in JavaScript.
    echo '
		<script type="text/javascript"><!-- // --><![CDATA[
			var oMainHeaderToggle = new smc_Toggle({
				bToggleEnabled: true,
				bCurrentlyCollapsed: ', empty($options['collapse_header']) ? 'false' : 'true', ',
				aSwappableContainers: [
					\'upper_section\'
				],
				aSwapImages: [
					{
						sId: \'upshrink\',
						srcExpanded: smf_images_url + \'/upshrink.png\',
						altExpanded: ', JavaScriptEscape($txt['upshrink_description']), ',
						srcCollapsed: smf_images_url + \'/upshrink2.png\',
						altCollapsed: ', JavaScriptEscape($txt['upshrink_description']), '
					}
				],
				oThemeOptions: {
					bUseThemeSettings: ', $context['user']['is_guest'] ? 'false' : 'true', ',
					sOptionName: \'collapse_header\',
					sSessionVar: ', JavaScriptEscape($context['session_var']), ',
					sSessionId: ', JavaScriptEscape($context['session_id']), '
				},
				oCookieOptions: {
					bUseCookie: ', $context['user']['is_guest'] ? 'true' : 'false', ',
					sCookieName: \'upshrink\'
				}
			});
		// ]]></script>';


    echo '
	</div></div>';

    // The main content should go here.
    echo '
	<div id="content_section" class="container-fluid"><div class="frame">
		<div id="main_content_section">';

    // Custom banners and shoutboxes should be placed here, before the linktree.

}

function template_body_below() {
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    echo '
		</div>
	</div></div>';

    // Show the "Powered by" and "Valid" logos, as well as the copyright. Remember, the copyright must be somewhere!
    echo '
	<div id="footer_section"><div class="frame">
		<ul class="reset">
			<li class="copyright">', theme_copyright(), '</li>
			<li><a id="button_xhtml" href="http://validator.w3.org/check?uri=referer" target="_blank" class="new_win" title="', $txt['valid_xhtml'], '"><span>', $txt['xhtml'], '</span></a></li>
			', !empty($modSettings['xmlnews_enable']) && (!empty($modSettings['allow_guestAccess']) || $context['user']['is_logged']) ? '<li><a id="button_rss" href="' . $scripturl . '?action=.xml;type=rss" class="new_win"><span>' . $txt['rss'] . '</span></a></li>' : '', '
			<li class="last"><a id="button_wap2" href="', $scripturl, '?wap2" class="new_win"><span>', $txt['wap2'], '</span></a></li>
		</ul>';

    // Show the load time?
    if ($context['show_load_time']) echo '
		<p>', $txt['page_created'], $context['load_time'], $txt['seconds_with'], $context['load_queries'], $txt['queries'], '</p>';

    echo '
	</div></div>', !empty($settings['forum_width']) ? '
</div>' : '';
}

function template_html_below() {
    global $context, $settings, $options, $scripturl, $txt, $modSettings;

    echo '
</body></html>';
}

// Show a linktree. This is that thing that shows "My Community | General Category | General Discussion"..
function theme_linktree($force_show = false) {
    global $context, $settings, $options, $shown_linktree;

    // If linktree is empty, just return - also allow an override.
    if (empty($context['linktree']) || (!empty($context['dont_default_linktree']) && !$force_show)) return;

    echo '
	<div class="navigate_section col-md-8 col-xs-12">
		<ul>';

    // Each tree item has a URL and name. Some may have extra_before and extra_after.
    foreach ($context['linktree'] as $link_num => $tree) {
        echo '
			<li', ($link_num == count($context['linktree']) - 1) ? ' class="last"' : '', '>';

        // Show something before the link?
        if (isset($tree['extra_before'])) echo $tree['extra_before'];

        // Show the link, including a URL if it should have one.
        echo $settings['linktree_link'] && isset($tree['url']) ? '
				<a href="' . $tree['url'] . '"><span>' . $tree['name'] . '</span></a>' : '<span>' . $tree['name'] . '</span>';

        // Show something after the link...?
        if (isset($tree['extra_after'])) echo $tree['extra_after'];

        // Don't show a separator for the last one.
        if ($link_num != count($context['linktree']) - 1) echo ' &#187;';

        echo '
			</li>';
    }
    echo '
		</ul>
	</div>';

    $shown_linktree = true;
}

// Show the menu up top. Something like [home] [help] [profile] [logout]...
function template_menu() {
    global $context, $settings, $options, $scripturl, $txt;

    echo '
		<div id="main_menu" class="navbar navbar-inverse navbar-fixed-top animated fadeIn">
  			<div class="container-fluid">
  			<div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">Sekai Anime</a>
	        </div>
  			<div id="navbar" class="navbar-collapse collapse">
  			<ul class="nav navbar-nav" id="menu_nav">';

    foreach ($context['menu_buttons'] as $act => $button) {
        $hasChildren = !empty($button['sub_buttons']);
        echo '<li id="button_', $act, '" class="', $button['active_button'] ? 'active ' : '', $hasChildren ? 'dropdown' : '', '">
			<a href="', $button['href'], '"', $hasChildren ? 'class="dropdown-toggle" role="menu" aria-expanded="false"' : '', isset($button['target']) ? ' target="' . $button['target'] . '"' : '', '>
				<span class="', isset($button['is_last']) ? 'last ' : '', '">', $button['title'], '</span>', $hasChildren ? '<span class="caret"></span>' : '', '</a>';
        template_render_dropdown($button);
        echo '</li>';
    }

    echo '</ul></div></div></div>';
}

function template_render_dropdown($menu) {
    $hasChildren = !empty($menu['sub_buttons']);
    if ($hasChildren) {
        echo '<ul class="dropdown-menu" role="menu">';
        foreach ($menu['sub_buttons'] as $item) {
            echo '<li class="', $button['active_button'] ? 'active ' : '', '">
					<a href="', $item['href'], '"', $hasChildren ? 'class="dropdown-toggle" role="menu" aria-expanded="false"' : '', isset($item['target']) ? ' target="' . $item['target'] . '"' : '', '>
						<span', isset($item['is_last']) ? ' class="last"' : '', '>', $item['title'], !empty($item['sub_buttons']) ? '...' : '', '</span>', $hasChildren ? '<span class="caret"></span>' : '', '
					</a>';
            template_render_dropdown($item);
            echo '</li>';
        }
        echo '</ul>';
    }
}

// Generate a strip of buttons.
function template_button_strip($button_strip, $direction = 'top', $strip_options = array()) {
    global $settings, $context, $txt, $scripturl;

    if (!is_array($strip_options)) $strip_options = array();

    // List the buttons in reverse order for RTL languages.
    if ($context['right_to_left']) $button_strip = array_reverse($button_strip, true);

    // Create the buttons...
    $buttons = array();
    foreach ($button_strip as $key => $value) {
        if (!isset($value['test']) || !empty($context[$value['test']])) $buttons[] = '
				<li><a' . (isset($value['id']) ? ' id="button_strip_' . $value['id'] . '"' : '') . ' class="button_strip_' . $key . (isset($value['active']) ? ' active' : '') . '" href="' . $value['url'] . '"' . (isset($value['custom']) ? ' ' . $value['custom'] : '') . '><span>' . $txt[$value['text']] . '</span></a></li>';
    }

    // No buttons? No button strip either.
    if (empty($buttons)) return;

    // Make the last one, as easy as possible.
    $buttons[count($buttons) - 1] = str_replace('<span>', '<span class="last">', $buttons[count($buttons) - 1]);

    echo '
		<div class="buttonlist', !empty($direction) ? ' float' . $direction : '', '"', (empty($buttons) ? ' style="display: none;"' : ''), (!empty($strip_options['id']) ? ' id="' . $strip_options['id'] . '"' : ''), '>
			<ul>', implode('', $buttons), '
			</ul>
		</div>';
}

?>