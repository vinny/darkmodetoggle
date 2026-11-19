<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\tests\language;

class language_test extends \phpbb_test_case
{
	/** @var string */
	protected $ext_dir;

	public function setUp(): void
	{
		parent::setUp();
		$this->ext_dir = dirname(__DIR__, 2);
	}

	protected function load_language_file(string $lang_iso, string $filename): array
	{
		$path = $this->ext_dir . '/language/' . $lang_iso . '/' . $filename;
		$this->assertFileExists($path);

		$lang = [];
		include $path;

		return $lang;
	}

	public function test_english_files_loaded()
	{
		$en_common = $this->load_language_file('en', 'common.php');
		$this->assertNotEmpty($en_common);

		$en_info_acp = $this->load_language_file('en', 'info_acp_darkmodetoggle.php');
		$this->assertNotEmpty($en_info_acp);

		$en_acp = $this->load_language_file('en', 'acp_darkmodetoggle.php');
		$this->assertNotEmpty($en_acp);
	}

	public function test_translations_coverage()
	{
		$files = [
			'common.php',
			'info_acp_darkmodetoggle.php',
			'acp_darkmodetoggle.php',
		];

		foreach ($files as $file)
		{
			$en = $this->load_language_file('en', $file);
			$pt = $this->load_language_file('pt_br', $file);

			$this->assertSame(
				array_keys($en),
				array_keys($pt),
				sprintf('Asserting that pt_br/%1$s has the exact same language keys as en/%1$s', $file)
			);
		}
	}

	public function test_all_declared_keys_are_used_in_codebase()
	{
		$en_common = $this->load_language_file('en', 'common.php');
		$en_info_acp = $this->load_language_file('en', 'info_acp_darkmodetoggle.php');
		$en_acp = $this->load_language_file('en', 'acp_darkmodetoggle.php');
		$declared_keys = array_merge(array_keys($en_common), array_keys($en_info_acp), array_keys($en_acp));

		$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->ext_dir));
		$codebase_text = '';

		/** @var \SplFileInfo $file */
		foreach ($files as $file)
		{
			if ($file->isFile())
			{
				$path = str_replace('\\', '/', $file->getPathname());
				if (strpos($path, '/language/') === false &&
					strpos($path, '/vendor/') === false &&
					strpos($path, '/node_modules/') === false &&
					strpos($path, '/tests/') === false &&
					strpos($path, '/.git/') === false)
				{
					$codebase_text .= file_get_contents($file->getPathname()) . "\n";
				}
			}
		}

		$unused_keys = [];
		foreach ($declared_keys as $key)
		{
			if (strpos($codebase_text, $key) === false)
			{
				$unused_keys[] = $key;
			}
		}

		$this->assertEmpty(
			$unused_keys,
			'All declared language keys should be in use. Unused keys: ' . implode(', ', $unused_keys)
		);
	}
}
