<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle;

/**
* Extension base class
*/
class ext extends \phpbb\extension\base
{
	/**
	* Check whether the extension can be enabled.
	*
	* @return bool
	*/
	public function is_enableable()
	{
		return phpbb_version_compare(PHPBB_VERSION, '4.0.0-a1', '>=');
	}
}
