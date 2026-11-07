<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vinny\darkmodetoggle\tests\functional;

use PHPUnit\Framework\Attributes\Group;

/**
* @group functional
*/
#[Group('functional')]
class darkmodetoggle_test extends \phpbb_functional_test_case
{
	protected static function setup_extensions()
	{
		return ['vinny/darkmodetoggle'];
	}

	public function test_toggle_rendered_on_index()
	{
		$this->request('GET', 'index.php');

		$content = $this->get_content();
		$this->assertStringContainsString('<dark-mode-toggle', $content);
		$this->assertStringContainsString('darkmodetoggle.css', $content);
		$this->assertStringContainsString('dark.css', $content);
		$this->assertStringContainsString('dark-mode-toggle.min.js', $content);
	}

	public function test_acp_module_settings()
	{
		$this->login();
		$this->admin_login();

		$this->add_lang_ext('vinny/darkmodetoggle', 'info_acp_darkmodetoggle');

		$crawler = $this->request('GET', 'adm/index.php?i=-vinny-darkmodetoggle-acp-darkmodetoggle_module&mode=settings&sid=' . $this->sid);
		$this->assertContainsLang('ACP_DARKMODETOGGLE_TITLE', $crawler->filter('#main')->text());
	}
}

