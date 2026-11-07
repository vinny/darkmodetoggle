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
	public $u_action;

	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbb\config\config $config */
		$config = $phpbb_container->get('config');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		/** @var \phpbb\request\request $request */
		$request = $phpbb_container->get('request');

		/** @var \phpbb\template\template $template */
		$template = $phpbb_container->get('template');

		/** @var \phpbb\user $user */
		$user = $phpbb_container->get('user');

		/** @var \phpbb\log\log $log */
		$log = $phpbb_container->get('log');

		$language->add_lang('info_acp_darkmodetoggle', 'vinny/darkmodetoggle');

		$this->tpl_name = 'acp_darkmodetoggle';
		$this->page_title = $language->lang('ACP_DARKMODETOGGLE_TITLE');

		$form_key = 'acp_darkmodetoggle';
		add_form_key($form_key);

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$enable = $request->variable('darkmodetoggle_enable', 1);
			$appearance = $request->variable('darkmodetoggle_appearance', 'toggle');
			if (!in_array($appearance, ['toggle', 'slider'], true))
			{
				$appearance = 'toggle';
			}

			$position = $request->variable('darkmodetoggle_position', 'breadcrumbs');
			if (!in_array($position, ['breadcrumbs', 'navbar', 'footer'], true))
			{
				$position = 'breadcrumbs';
			}

			$show_labels = $request->variable('darkmodetoggle_show_labels', 0);

			$config->set('darkmodetoggle_enable', $enable ? 1 : 0);
			$config->set('darkmodetoggle_appearance', $appearance);
			$config->set('darkmodetoggle_position', $position);
			$config->set('darkmodetoggle_show_labels', $show_labels ? 1 : 0);

			$log->add('admin', $user->data['user_id'], $user->ip, 'LOG_ACP_DARKMODETOGGLE_SETTINGS');

			trigger_error($language->lang('ACP_DARKMODETOGGLE_SAVED') . adm_back_link($this->u_action));
		}

		$appearance = $config['darkmodetoggle_appearance'] ?? 'toggle';
		if (!in_array($appearance, ['toggle', 'slider'], true))
		{
			$appearance = 'toggle';
		}

		$position = $config['darkmodetoggle_position'] ?? 'breadcrumbs';
		if (!in_array($position, ['breadcrumbs', 'navbar', 'footer'], true))
		{
			$position = 'breadcrumbs';
		}

		$template->assign_vars([
			'DARKMODETOGGLE_ENABLE'			=> !empty($config['darkmodetoggle_enable']),
			'DARKMODETOGGLE_APPEARANCE'		=> $appearance,
			'DARKMODETOGGLE_POSITION'		=> $position,
			'DARKMODETOGGLE_SHOW_LABELS'	=> !empty($config['darkmodetoggle_show_labels']),
			'U_ACTION'						=> $this->u_action,
		]);
	}
}
