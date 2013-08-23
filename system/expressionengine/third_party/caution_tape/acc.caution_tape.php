<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------
 
/**
 * Caution Tape Accessory
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Accessory
 * @author		Jason Varga
 * @link		http://pixelfear.com
 */
 
class Caution_tape_acc {
	
	public $name			= 'Caution Tape';
	public $id				= 'caution_tape';
	public $version			= '1.0';
	public $description		= 'Adds caution tape to the top of your Control Panel';
	public $sections		= array();

	public $config;
	public $env;
	public $enabled;
	

	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->EE =& get_instance();

		// Grab config settings
		require PATH_THIRD.'caution_tape/config.php';
		$this->config = $config;

		// Config override setting
		$enabled_in_config = config_item('caution_tape_enabled') ? (bool) preg_match('/1|on|yes|y|true/i', config_item('caution_tape_enabled')) : FALSE;
		// Addon's config setting
		$enabled_local = (bool) preg_match('/1|on|yes|y|true/i', $config['enabled']);

		// Enabled?
		$enabled = config_item('caution_tape_enabled') ?
		           (bool) preg_match('/1|on|yes|y|true/i', config_item('caution_tape_enabled')) :
		           (bool) preg_match('/1|on|yes|y|true/i', $config['enabled']);           

		// Only continue if it's enabled
		if ($enabled)
		{ 
			$this->_set_environment();
		}
	} 
	
	/**
	 * Set Sections
	 */
	public function set_sections()
	{
		// Hide accessory tab
		$this->sections[] = '<script type="text/javascript">$("#accessoryTabs a.caution_tape").parent().remove();</script>';

		// Show the caution tape
		if ($this->enabled)
		{
			$this->_show_tape();
		}
	}

	/**
	 * Show Caution Tape
	**/
	private function _show_tape()
	{
		// Theme loader
		if(!isset($this->EE->theme_loader))
		{
			$this->EE->load->library('theme_loader');
		}
		$this->EE->theme_loader->module_name = 'caution_tape';
		
		// Load css
		$this->EE->theme_loader->css('caution_tape');

		// Label alignment
		$align = (empty($this->config['align'])) ? 'right' : $this->config['align'];

		// Label
		$label = ($this->env_label) ? "<span>".$this->env_label."</span>" : "";

		// Output js
		$this->EE->theme_loader->output('
			$("#branding").before("<div id=\'caution_tape\' class=\''.$align.'\'>'.$label.'</div>");
		');
	}
	
	/**
	 * Set Environment
	 */
	private function _set_environment()
	{
		// Detect if Focus Lab's Master Config Bootstrap is being used
		$using_bootstrap = (defined('ENV')) ? TRUE : FALSE;

		// Using FL's Bootstrap
		if ($using_bootstrap)
		{
			$env_label = (defined('ENV_TAPE_LABEL')) ? ENV_TAPE_LABEL : ENV_FULL;
			$env_show = (defined('ENV_SHOW_TAPE')) ? ENV_SHOW_TAPE : TRUE;
		}
		// Not using FL's Bootstrap
		else
		{
			$env_conf = isset($this->config['environments']) ? $this->config['environments'] : FALSE;

			// Environments array specified?
			if ($env_conf) {
				// Get lookup method, default to http_host (only support for http_host at the moment)
				$method_val = (isset($env_conf['method'])) ? $env_conf['method'] : $_SERVER['HTTP_HOST'];

				// Get current environment's label.
				// If it's not in the array, assume it's a dev environment
				$env = (isset($env_conf[$method_val])) ? $env_conf[$method_val] : $env_conf['development'];
				$env_label = $env['label'];

				// Show the tape for this environment?
				$env_show = $env['show'];
			}
			// No environments specified?
			else {
				$env_label = (config_item('caution_tape_label')) ? config_item('caution_tape_label') : FALSE;
				$env_show = true;
			}
		}

		// Set the environment vars
		$this->env_label = $env_label;
		$this->enabled = $env_show;
	}
	
	// ----------------------------------------------------------------
	
}
 
/* End of file acc.caution_tape.php */
/* Location: /system/expressionengine/third_party/caution_tape/acc.caution_tape.php */