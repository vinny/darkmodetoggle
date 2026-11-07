<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_DARKMODETOGGLE_TITLE'					=> 'Dark mode toggle',
	'ACP_DARKMODETOGGLE_SETTINGS'				=> 'Settings',
	'ACP_DARKMODETOGGLE_EXPLAIN'				=> 'Configure how and where the dark mode toggle appears on the board.',
	'ACP_DARKMODETOGGLE_ENABLE'					=> 'Enable dark mode toggle',
	'ACP_DARKMODETOGGLE_ENABLE_EXPLAIN'			=> 'Allow users and guests to switch between light and dark modes. On first visit, the theme follows the user’s system preference.',
	'ACP_DARKMODETOGGLE_APPEARANCE'				=> 'Button appearance',
	'ACP_DARKMODETOGGLE_APPEARANCE_EXPLAIN'		=> 'Display a single icon button or a sliding switch.',
	'ACP_DARKMODETOGGLE_APPEARANCE_TOGGLE'		=> 'Toggle (single icon)',
	'ACP_DARKMODETOGGLE_APPEARANCE_SLIDER'		=> 'Slider (switch)',
	'ACP_DARKMODETOGGLE_POSITION'				=> 'Button position',
	'ACP_DARKMODETOGGLE_POSITION_EXPLAIN'		=> 'Choose where the button is shown on the page.',
	'ACP_DARKMODETOGGLE_POS_BREADCRUMBS'		=> 'Breadcrumbs bar',
	'ACP_DARKMODETOGGLE_POS_NAVBAR'				=> 'Main navigation bar',
	'ACP_DARKMODETOGGLE_POS_FOOTER'				=> 'Footer navigation bar',
	'ACP_DARKMODETOGGLE_SHOW_LABELS'			=> 'Show text labels',
	'ACP_DARKMODETOGGLE_SHOW_LABELS_EXPLAIN'	=> 'Display “Light” and “Dark” labels next to the icons.',
	'ACP_DARKMODETOGGLE_SAVED'					=> 'Dark mode toggle settings have been saved.',
	'LOG_ACP_DARKMODETOGGLE_SETTINGS'			=> '<strong>Dark mode toggle settings updated</strong>',
]);
