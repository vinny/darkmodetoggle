<?php
/**
*
* Dark Mode Toggle extension for the phpBB Forum Software package.
*
* @copyright (c) 2026 _Vinny_ <https://github.com/vinny>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_DARKMODETOGGLE_TITLE'					=> 'Alternador de modo escuro',
	'ACP_DARKMODETOGGLE_SETTINGS'				=> 'Configurações',
	'ACP_DARKMODETOGGLE_EXPLAIN'				=> 'Configure como e onde o botão de modo escuro é exibido no fórum.',
	'ACP_DARKMODETOGGLE_ENABLE'					=> 'Ativar alternador de modo escuro',
	'ACP_DARKMODETOGGLE_ENABLE_EXPLAIN'			=> 'Permite que usuários e visitantes alternem entre os modos claro e escuro. No primeiro acesso, o tema segue a preferência do sistema do usuário.',
	'ACP_DARKMODETOGGLE_APPEARANCE'				=> 'Aparência do botão',
	'ACP_DARKMODETOGGLE_APPEARANCE_EXPLAIN'		=> 'Exibe um botão de ícone único ou uma chave deslizante (slider).',
	'ACP_DARKMODETOGGLE_APPEARANCE_TOGGLE'		=> 'Toggle (ícone único)',
	'ACP_DARKMODETOGGLE_APPEARANCE_SLIDER'		=> 'Slider (chave deslizante)',
	'ACP_DARKMODETOGGLE_POSITION'				=> 'Posição do botão',
	'ACP_DARKMODETOGGLE_POSITION_EXPLAIN'		=> 'Escolha onde o botão será exibido na página.',
	'ACP_DARKMODETOGGLE_POS_BREADCRUMBS'		=> 'Barra de breadcrumbs',
	'ACP_DARKMODETOGGLE_POS_NAVBAR'				=> 'Barra de navegação principal',
	'ACP_DARKMODETOGGLE_POS_FOOTER'				=> 'Barra de navegação do rodapé',
	'ACP_DARKMODETOGGLE_SHOW_LABELS'			=> 'Mostrar rótulos de texto',
	'ACP_DARKMODETOGGLE_SHOW_LABELS_EXPLAIN'	=> 'Exibe os textos “Claro” e “Escuro” ao lado dos ícones.',
	'ACP_DARKMODETOGGLE_SAVED'					=> 'As configurações do alternador de modo escuro foram salvas.',
	'LOG_ACP_DARKMODETOGGLE_SETTINGS'			=> '<strong>Configurações do alternador de modo escuro atualizadas</strong>',
]);
