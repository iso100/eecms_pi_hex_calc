<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hex Calc Plugin
 *
 * @package				ExpressionEngine
 * @subpackage		Addons
 * @category			Plugin
 * @author				Ian Pitts
 * @link					http://iso-100.com
 */

$plugin_info = array(
	'pi_name'				=> 'Hex Calc',
	'pi_version'		=> '1.1',
	'pi_author'			=> 'Ian Pitts',
	'pi_author_url'	=> 'http://iso-100.com',
	'pi_description'=> 'Takes a hex code and returns a lighter or darker version.',
	'pi_usage'			=> Hex_calc::usage()
);


class Hex_calc {

	public $return_data = "";
		
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();

		$source_color = ($this->EE->TMPL->fetch_param('color')) ? ($this->EE->TMPL->fetch_param('color')) : '000000';
		$percent = ($this->EE->TMPL->fetch_param('percent')) ? ($this->EE->TMPL->fetch_param('percent')) : '50';
		$mode = ($this->EE->TMPL->fetch_param('mode')) ? ($this->EE->TMPL->fetch_param('mode')) : 'lighten';

		// trim whitespace
		$source_color = trim( $source_color );

		if ( strpos( $source_color, '#') === FALSE )
		{
			$has_hash = '';
		} else {
			$has_hash = '#';
			$source_color = str_replace('#', '', $source_color);
		}

		// ensure an integer
		$percent = (int)$percent;

		if ($percent > 99)
		{
			$percent = 100;
		}
		
		// Call proper function based on mode function
		if ($mode == 'lighten')
		{
			$modified_color = $this->_hexlighter($source_color, $percent);
		} else {
			$modified_color = $this->_hexdarker($source_color, $percent);
		}

		$this->return_data = $has_hash . $modified_color;
	}

	public function Hex_calc()
	{

	}
	
	private function _hexlighter( $hex, $factor ) 
	{
	$new_hex = '';

	$base['R'] = hexdec($hex{0}.$hex{1});
	$base['G'] = hexdec($hex{2}.$hex{3});
	$base['B'] = hexdec($hex{4}.$hex{5});
	
	foreach ($base as $k => $v)
			{
			$amount = 255 - $v;
			$amount = $amount / 100;
			$amount = round($amount * $factor);
			$new_decimal = $v + $amount;

			$new_hex_component = dechex($new_decimal);
			if(strlen($new_hex_component) < 2) 
					{ $new_hex_component = "0".$new_hex_component; } 
			$new_hex .= $new_hex_component; 
			} 
			 
	return $new_hex;
	} 

	private function _hexdarker( $hex, $factor ) 
	{
	$new_hex = '';

	$base['R'] = hexdec($hex{0}.$hex{1});
	$base['G'] = hexdec($hex{2}.$hex{3});
	$base['B'] = hexdec($hex{4}.$hex{5});
	
	foreach ($base as $k => $v)
			{
			$amount = $v / 100;
			$amount = round($amount * $factor);
			$new_decimal = $v - $amount;

			$new_hex_component = dechex($new_decimal);
			if(strlen($new_hex_component) < 2) 
					{ $new_hex_component = "0".$new_hex_component; } 
			$new_hex .= $new_hex_component; 
			} 
			 
	return $new_hex;
	} 

	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>
Parameters:

* source_color: specify a hexadecimal color. If you provide the #, the # will be returned with the new value. Default is 000000
* percent: percentage of lightening or darkening. Default is 50.
* mode: specify either lighten or darken. 'lighten' is the default if no parameter is specified. Anything else is assumed darken.

{exp:hex_calc color="#16A527" percent="35"} <- this will lighten by 35%, outputting the # as well as new hex value

{exp:hex_calc color="16A527" percent="35" mode="darken"} <- this will darken by 35% and will not include the hash
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.Hex_calc.php */
/* Location: /system/expressionengine/third_party/hex_calc/pi.hex_calc.php */