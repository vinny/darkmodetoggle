<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\migrations\v100;

class install_darkmodetoggle extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['darkmodetoggle_enable']);
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v400\v400a1'];
	}

	public function update_data()
	{
		return [
			['config.add', ['darkmodetoggle_enable', 1]],
			['config.add', ['darkmodetoggle_appearance', 'toggle']],
			['config.add', ['darkmodetoggle_position', 'breadcrumbs']],
			['config.add', ['darkmodetoggle_show_labels', 0]],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_DARKMODETOGGLE_TITLE',
			]],
			['module.add', [
				'acp',
				'ACP_DARKMODETOGGLE_TITLE',
				[
					'module_basename'	=> '\vinny\darkmodetoggle\acp\darkmodetoggle_module',
					'modes'				=> ['settings'],
				],
			]],
		];
	}
}
