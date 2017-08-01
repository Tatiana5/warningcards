<?php
/**
*
* @package phpBB Extension - Warning Cards
* @copyright (c) 2016 ??????????????5
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tatiana5\warningcards\migrations;

class warningcards_0_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('warningcards_version', '0.0.1')),
		);
	}
}
