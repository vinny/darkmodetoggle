<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\acp;

class darkmodetoggle_info
{
	public function module()
	{
		return [
			'filename'	=> '\vinny\darkmodetoggle\acp\darkmodetoggle_module',
			'title'		=> 'ACP_DARKMODETOGGLE_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_DARKMODETOGGLE_SETTINGS',
					'auth'	=> 'ext_vinny/darkmodetoggle && acl_a_board',
					'cat'	=> ['ACP_DARKMODETOGGLE_TITLE'],
				],
			],
		];
	}
}
