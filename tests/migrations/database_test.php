<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\tests\migrations;

use vinny\darkmodetoggle\migrations\v100\install_darkmodetoggle;

class database_test extends \phpbb_test_case
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface|\PHPUnit\Framework\MockObject\MockObject */
	protected $db;

	/** @var \phpbb\db\tools\tools_interface|\PHPUnit\Framework\MockObject\MockObject */
	protected $db_tools;

	public function setUp(): void
	{
		parent::setUp();

		$this->config = new \phpbb\config\config([]);
		$this->db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$this->db_tools = $this->createMock(\phpbb\db\tools\tools_interface::class);
	}

	protected function get_migration(): install_darkmodetoggle
	{
		return new install_darkmodetoggle(
			$this->config,
			$this->db,
			$this->db_tools,
			'./',
			'php',
			'phpbb_'
		);
	}

	public function test_depends_on()
	{
		$this->assertSame(
			['\phpbb\db\migration\data\v400\v400a1'],
			install_darkmodetoggle::depends_on()
		);
	}

	public function test_effectively_installed()
	{
		$migration = $this->get_migration();
		$this->assertFalse($migration->effectively_installed());

		$this->config['darkmodetoggle_enable'] = 1;
		$this->assertTrue($migration->effectively_installed());
	}

	public function test_update_data()
	{
		$migration = $this->get_migration();
		$data = $migration->update_data();

		$this->assertIsArray($data);

		$configs = [];
		foreach ($data as $entry)
		{
			if ($entry[0] === 'config.add')
			{
				$configs[$entry[1][0]] = $entry[1][1];
			}
		}

		$this->assertSame(1, $configs['darkmodetoggle_enable']);
		$this->assertSame('toggle', $configs['darkmodetoggle_appearance']);
		$this->assertSame('breadcrumbs', $configs['darkmodetoggle_position']);
		$this->assertSame(0, $configs['darkmodetoggle_show_labels']);
		$this->assertArrayNotHasKey('darkmodetoggle_version', $configs);
	}
}
