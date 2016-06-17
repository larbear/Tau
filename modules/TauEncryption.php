<?php
/**
 * Encryption module for TAU
 *
 * @Author          theyak
 * @Copyright       2011
 * @Based on        http://stackoverflow.com/questions/1289061/best-way-to-use-php-to-encrypt-and-decrypt
 * @Project Page    None!
 * @docs            None!
 *
 */

/*
Examples:

// Static calls
$encoded = TauEncryption::encrypt( 'bob', 'hi' );
Tau::dump($encoded);
$decoded = TauEncryption::decrypt( $encoded, 'hi' );
Tau::dump($decoded);

// Instance, passing in key
$e = new TauEncryption( 'hi' );
$encoded = $e->encode( 'bob' );
Tau::dump($encoded);
$decoded = $e->decode( $encoded );
Tau::dump($decoded);

// Instance, using key directly in parameters
$e = new TauEncryption();
$encoded = $e->encode( 'bob', 'hi' );
Tau::dump($encoded);
$decoded = $e->decode( $encoded, 'hi' );
Tau::dump($decoded);

// Instance, assign key separately
$e = new TauEncryption();
$e->key = 'hi';
$encoded = $e->encode( 'bob' );
Tau::dump($encoded);
$decoded = $e->decode( $encoded );
Tau::dump($decoded);
*/


if (!defined('TAU'))
{
	exit;
}

class TauEncryption
{
	/**
	 * Default key
	 * @var string
	 */
	public $key = '';


	public function __construct( $key = null )
	{
		if ( ! is_null( $key ) )
		{
			$this->key = $key;
		}
	}

	private static function safe_b64encode($string)
	{
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='), array('-','_',''), $data);
		return $data;
	}

	private static function safe_b64decode($string)
	{
		$data = str_replace(array('-','_'), array('+','/'), $string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public function encode($value, $key = '')
	{
		if (!$value) {
			return false;
		}

		if (empty($key)) {
			$key = $this->key;
		}

		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $iv);

		return trim(static::safe_b64encode($crypttext));
	}

	public function decode($value, $key = '')
	{
		if (!$value) {
			return false;
		}
		if (empty($key)) {
			$key = $this->key;
		}

		$crypttext = static::safe_b64decode($value);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);

		return trim($decrypttext);
	}


	public static function encrypt( $value, $key )
	{
		if ( ! is_string( $value ) || strlen( $value ) <= 0 ) {
			return false;
		}

		if ( ! is_string( $key ) || strlen( $key ) <= 0 ) {
			return false;
		}

		$iv_size = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );
		$iv = mcrypt_create_iv( $iv_size, MCRYPT_RAND );
		$crypttext = mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $iv );

		return static::safe_b64encode( $crypttext );
	}


	public static function decrypt( $value, $key )
	{
		$crypttext = static::safe_b64decode( $value );
		$iv_size = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );
		$iv = mcrypt_create_iv( $iv_size, MCRYPT_RAND );
		$decrypttext = mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv );

		return $decrypttext;
	}
}
