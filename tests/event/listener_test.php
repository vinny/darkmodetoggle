<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\tests\event;

use vinny\darkmodetoggle\event\listener;

class listener_test extends \phpbb_test_case
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template|\PHPUnit\Framework\MockObject\MockObject */
	protected $template;

	public function setUp(): void
	{
		parent::setUp();

		$this->config = new \phpbb\config\config([
			'darkmodetoggle_enable'			=> 1,
			'darkmodetoggle_appearance'		=> 'toggle',
			'darkmodetoggle_position'		=> 'breadcrumbs',
			'darkmodetoggle_show_labels'	=> 0,
		]);

		$this->template = $this->getMockBuilder('\phpbb\template\template')
			->disableOriginalConstructor()
			->getMock();
	}

	protected function get_listener(): listener
	{
		return new listener(
			$this->config,
			$this->template
		);
	}

	public function test_get_subscribed_events()
	{
		$events = listener::getSubscribedEvents();

		$this->assertIsArray($events);
		$this->assertArrayHasKey('core.user_setup', $events);
		$this->assertArrayHasKey('core.page_header', $events);
		$this->assertSame('load_language_on_setup', $events['core.user_setup']);
		$this->assertSame('add_page_header_vars', $events['core.page_header']);
	}

	public function test_load_language_on_setup()
	{
		$listener = $this->get_listener();
		$event = new \ArrayObject([
			'lang_set_ext' => [],
		]);

		$listener->load_language_on_setup($event);

		$this->assertCount(1, $event['lang_set_ext']);
		$this->assertSame('vinny/darkmodetoggle', $event['lang_set_ext'][0]['ext_name']);
		$this->assertSame('common', $event['lang_set_ext'][0]['lang_set']);
	}

	public function test_add_page_header_vars_defaults()
	{
		$this->template->expects($this->once())
			->method('assign_vars')
			->with([
				'S_DARKMODETOGGLE_ENABLED'			=> true,
				'DARKMODETOGGLE_APPEARANCE'			=> 'toggle',
				'DARKMODETOGGLE_POSITION'			=> 'breadcrumbs',
				'S_DARKMODETOGGLE_POS_BREADCRUMBS'	=> true,
				'S_DARKMODETOGGLE_POS_NAVBAR'		=> false,
				'S_DARKMODETOGGLE_POS_FOOTER'		=> false,
				'S_DARKMODETOGGLE_SHOW_LABELS'		=> false,
			]);

		$listener = $this->get_listener();
		$listener->add_page_header_vars();
	}

	public function test_add_page_header_vars_slider_navbar_with_labels()
	{
		$this->config['darkmodetoggle_enable'] = 1;
		$this->config['darkmodetoggle_appearance'] = 'slider';
		$this->config['darkmodetoggle_position'] = 'navbar';
		$this->config['darkmodetoggle_show_labels'] = 1;

		$this->template->expects($this->once())
			->method('assign_vars')
			->with([
				'S_DARKMODETOGGLE_ENABLED'			=> true,
				'DARKMODETOGGLE_APPEARANCE'			=> 'slider',
				'DARKMODETOGGLE_POSITION'			=> 'navbar',
				'S_DARKMODETOGGLE_POS_BREADCRUMBS'	=> false,
				'S_DARKMODETOGGLE_POS_NAVBAR'		=> true,
				'S_DARKMODETOGGLE_POS_FOOTER'		=> false,
				'S_DARKMODETOGGLE_SHOW_LABELS'		=> true,
			]);

		$listener = $this->get_listener();
		$listener->add_page_header_vars();
	}

	public function test_add_page_header_vars_footer_and_disabled()
	{
		$this->config['darkmodetoggle_enable'] = 0;
		$this->config['darkmodetoggle_appearance'] = 'toggle';
		$this->config['darkmodetoggle_position'] = 'footer';
		$this->config['darkmodetoggle_show_labels'] = 0;

		$this->template->expects($this->once())
			->method('assign_vars')
			->with([
				'S_DARKMODETOGGLE_ENABLED'			=> false,
				'DARKMODETOGGLE_APPEARANCE'			=> 'toggle',
				'DARKMODETOGGLE_POSITION'			=> 'footer',
				'S_DARKMODETOGGLE_POS_BREADCRUMBS'	=> false,
				'S_DARKMODETOGGLE_POS_NAVBAR'		=> false,
				'S_DARKMODETOGGLE_POS_FOOTER'		=> true,
				'S_DARKMODETOGGLE_SHOW_LABELS'		=> false,
			]);

		$listener = $this->get_listener();
		$listener->add_page_header_vars();
	}

	public function test_add_page_header_vars_invalid_values_fallback()
	{
		$this->config['darkmodetoggle_appearance'] = 'invalid_appearance';
		$this->config['darkmodetoggle_position'] = 'all';

		$this->template->expects($this->once())
			->method('assign_vars')
			->with([
				'S_DARKMODETOGGLE_ENABLED'			=> true,
				'DARKMODETOGGLE_APPEARANCE'			=> 'toggle',
				'DARKMODETOGGLE_POSITION'			=> 'breadcrumbs',
				'S_DARKMODETOGGLE_POS_BREADCRUMBS'	=> true,
				'S_DARKMODETOGGLE_POS_NAVBAR'		=> false,
				'S_DARKMODETOGGLE_POS_FOOTER'		=> false,
				'S_DARKMODETOGGLE_SHOW_LABELS'		=> false,
			]);

		$listener = $this->get_listener();
		$listener->add_page_header_vars();
	}
}

