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

class darkmodetoggle_module
{
	/** @var string */
	public string $u_action = '';

	/** @var string */
	public string $tpl_name = '';

	/** @var string */
	public string $page_title = '';

	/**
	* Main ACP module
	*
	* @param int|string $id   The module ID
	* @param string     $mode The module mode
	* @return void
	*/
	public function main($id, $mode): void
	{
		global $phpbb_container;

		/** @var \vinny\darkmodetoggle\controller\acp_controller $acp_controller */
		$acp_controller = $phpbb_container->get('vinny.darkmodetoggle.controller.acp');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		$this->tpl_name = 'acp_darkmodetoggle';
		$this->page_title = $language->lang('ACP_DARKMODETOGGLE_TITLE');

		$acp_controller->set_page_url($this->u_action)->display_options();
	}
}
