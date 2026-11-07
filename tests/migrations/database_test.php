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

class database_test extends \phpbb_database_test_case
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	protected static function setup_extensions()
	{
		return ['vinny/darkmodetoggle'];
	}

	public function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixtures/config.xml');
	}

	public function setUp(): void
	{
		parent::setUp();

		$this->db = $this->new_dbal();
	}

	public function test_default_configs_installed()
	{
		$sql = 'SELECT config_name, config_value
			FROM ' . CONFIG_TABLE . "
			WHERE config_name LIKE 'darkmodetoggle_%'";
		$result = $this->db->sql_query($sql);

		$configs = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$configs[$row['config_name']] = $row['config_value'];
		}
		$this->db->sql_freeresult($result);

		$this->assertArrayHasKey('darkmodetoggle_enable', $configs);
		$this->assertSame('1', (string) $configs['darkmodetoggle_enable']);

		$this->assertArrayHasKey('darkmodetoggle_appearance', $configs);
		$this->assertSame('toggle', $configs['darkmodetoggle_appearance']);

		$this->assertArrayHasKey('darkmodetoggle_position', $configs);
		$this->assertSame('breadcrumbs', $configs['darkmodetoggle_position']);

		$this->assertArrayHasKey('darkmodetoggle_show_labels', $configs);
		$this->assertSame('0', (string) $configs['darkmodetoggle_show_labels']);

		$this->assertArrayNotHasKey('darkmodetoggle_version', $configs);
	}
}

