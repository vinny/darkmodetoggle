<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\controller;

use vinny\darkmodetoggle\event\listener;

/**
* Dark Mode Toggle ACP controller
*/
class acp_controller
{
	/** @var string Custom form action */
	protected string $u_action = '';

	/**
	* Constructor
	*
	* @param \phpbb\config\config     $config   Config object
	* @param \phpbb\language\language $language Language object
	* @param \phpbb\log\log           $log      Log object
	* @param \phpbb\request\request   $request  Request object
	* @param \phpbb\template\template $template Template object
	* @param \phpbb\user              $user     User object
	*/
	public function __construct(
		protected \phpbb\config\config $config,
		protected \phpbb\language\language $language,
		protected \phpbb\log\log $log,
		protected \phpbb\request\request $request,
		protected \phpbb\template\template $template,
		protected \phpbb\user $user
	)
	{
	}

	/**
	* Set custom form action
	*
	* @param string $u_action Custom form action
	* @return $this
	*/
	public function set_page_url(string $u_action): self
	{
		$this->u_action = $u_action;

		return $this;
	}

	/**
	* Display and process the ACP settings form
	*
	* @return void
	*/
	public function display_options(): void
	{
		$this->language->add_lang('acp_darkmodetoggle', 'vinny/darkmodetoggle');

		$form_key = 'acp_darkmodetoggle';
		add_form_key($form_key);

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$enable = $this->request->variable('darkmodetoggle_enable', 1);
			$appearance = listener::sanitize_appearance($this->request->variable('darkmodetoggle_appearance', 'toggle'));
			$position = listener::sanitize_position($this->request->variable('darkmodetoggle_position', 'breadcrumbs'));
			$show_labels = $this->request->variable('darkmodetoggle_show_labels', 0);

			$this->config->set('darkmodetoggle_enable', $enable ? 1 : 0);
			$this->config->set('darkmodetoggle_appearance', $appearance);
			$this->config->set('darkmodetoggle_position', $position);
			$this->config->set('darkmodetoggle_show_labels', $show_labels ? 1 : 0);

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_DARKMODETOGGLE_SETTINGS');

			trigger_error($this->language->lang('ACP_DARKMODETOGGLE_SAVED') . adm_back_link($this->u_action));
		}

		$appearance = listener::sanitize_appearance($this->config['darkmodetoggle_appearance'] ?? 'toggle');
		$position = listener::sanitize_position($this->config['darkmodetoggle_position'] ?? 'breadcrumbs');

		$this->template->assign_vars([
			'DARKMODETOGGLE_ENABLE'			=> !empty($this->config['darkmodetoggle_enable']),
			'DARKMODETOGGLE_APPEARANCE'		=> $appearance,
			'DARKMODETOGGLE_POSITION'		=> $position,
			'DARKMODETOGGLE_SHOW_LABELS'	=> !empty($this->config['darkmodetoggle_show_labels']),
			'U_ACTION'						=> $this->u_action,
		]);
	}
}
