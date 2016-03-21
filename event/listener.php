<?php
/**
*
* @package phpBB Extension - Warning Cards
* @copyright (c) 2016 ??????????????5
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tatiana5\warningcards\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_data'	=> 'get_banned_users',
			'core.viewtopic_modify_post_row'	=> 'modify_postrow',
		);
	}
	
	/** @var \phpbb\extension\manager */
	protected $phpbb_extension_manager;

	/**
	* Constructor
	*/
	public function __construct(\phpbb\extension\manager $phpbb_extension_manager)
	{
		$this->phpbb_extension_manager = $phpbb_extension_manager;
		$this->banned_users = array();
		$this->aw_enabled = false;
	}
	
	public function get_banned_users($event) {
		if($this->phpbb_extension_manager->is_enabled('rxu/AdvancedWarnings') == false)
		{
			$user_cache = $event['user_cache'];
			
			$this->banned_users = phpbb_get_banned_user_ids(array_keys($user_cache), true);
		}
		else
		{
			$this->aw_enabled = true;
		}
	}
	
	public function modify_postrow($event)
	{
		if($this->aw_enabled == false)
		{
			$postrow = $event['post_row'];
			$poster_id = $row['user_id'];
			
			$postrow = array_merge($postrow, array(
				'POSTER_BANNED'		=> (in_array($poster_id, $this->banned_users)) ? true : false,
			));
			
			$event['post_row'] = $postrow;
		}
	}
}
