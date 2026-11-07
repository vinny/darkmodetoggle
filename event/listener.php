<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\config\config     $config   Config object
	* @param \phpbb\template\template $template Template object
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->template = $template;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	*/
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header'	=> 'add_page_header_vars',
		];
	}

	/**
	* Load common language file during user setup
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'vinny/darkmodetoggle',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Assign template variables for Dark Mode Toggle
	*
	* @return void
	*/
	public function add_page_header_vars()
	{
		$enabled = !empty($this->config['darkmodetoggle_enable']);
		$appearance = $this->config['darkmodetoggle_appearance'] ?? 'toggle';
		if (!in_array($appearance, ['toggle', 'slider'], true))
		{
			$appearance = 'toggle';
		}

		$position = $this->config['darkmodetoggle_position'] ?? 'breadcrumbs';
		if (!in_array($position, ['breadcrumbs', 'navbar', 'footer'], true))
		{
			$position = 'breadcrumbs';
		}

		$this->template->assign_vars([
			'S_DARKMODETOGGLE_ENABLED'			=> $enabled,
			'DARKMODETOGGLE_APPEARANCE'			=> $appearance,
			'DARKMODETOGGLE_POSITION'			=> $position,
			'S_DARKMODETOGGLE_POS_BREADCRUMBS'	=> $position === 'breadcrumbs',
			'S_DARKMODETOGGLE_POS_NAVBAR'		=> $position === 'navbar',
			'S_DARKMODETOGGLE_POS_FOOTER'		=> $position === 'footer',
			'S_DARKMODETOGGLE_SHOW_LABELS'		=> !empty($this->config['darkmodetoggle_show_labels']),
		]);
	}
}
