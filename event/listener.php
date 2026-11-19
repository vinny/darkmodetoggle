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
	public const ALLOWED_APPEARANCES = ['toggle', 'slider'];
	public const ALLOWED_POSITIONS = ['breadcrumbs', 'navbar', 'footer'];

	/**
	* Constructor
	*
	* @param \phpbb\config\config     $config   Config object
	* @param \phpbb\template\template $template Template object
	*/
	public function __construct(
		protected \phpbb\config\config $config,
		protected \phpbb\template\template $template
	)
	{
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	*/
	public static function getSubscribedEvents(): array
	{
		return [
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header'	=> 'add_page_header_vars',
		];
	}

	/**
	* Sanitize button appearance value
	*
	* @param string $appearance Raw appearance value
	* @return string
	*/
	public static function sanitize_appearance(string $appearance): string
	{
		return in_array($appearance, self::ALLOWED_APPEARANCES, true) ? $appearance : 'toggle';
	}

	/**
	* Sanitize button position value
	*
	* @param string $position Raw position value
	* @return string
	*/
	public static function sanitize_position(string $position): string
	{
		return in_array($position, self::ALLOWED_POSITIONS, true) ? $position : 'breadcrumbs';
	}

	/**
	* Load common language file during user setup
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	*/
	public function load_language_on_setup($event): void
	{
		if (empty($this->config['darkmodetoggle_enable']))
		{
			return;
		}

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
	public function add_page_header_vars(): void
	{
		if (empty($this->config['darkmodetoggle_enable']))
		{
			$this->template->assign_vars([
				'S_DARKMODETOGGLE_ENABLED' => false,
			]);
			return;
		}

		$appearance = self::sanitize_appearance((string) ($this->config['darkmodetoggle_appearance'] ?? 'toggle'));
		$position = self::sanitize_position((string) ($this->config['darkmodetoggle_position'] ?? 'breadcrumbs'));

		$this->template->assign_vars([
			'S_DARKMODETOGGLE_ENABLED'			=> true,
			'DARKMODETOGGLE_APPEARANCE'			=> $appearance,
			'DARKMODETOGGLE_POSITION'			=> $position,
			'S_DARKMODETOGGLE_POS_BREADCRUMBS'	=> $position === 'breadcrumbs',
			'S_DARKMODETOGGLE_POS_NAVBAR'		=> $position === 'navbar',
			'S_DARKMODETOGGLE_POS_FOOTER'		=> $position === 'footer',
			'S_DARKMODETOGGLE_SHOW_LABELS'		=> !empty($this->config['darkmodetoggle_show_labels']),
		]);
	}
}
