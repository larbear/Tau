<?php
/**
 * Input Module For TAU
 *
 * @Author          theyak
 * @Copyright       2011
 * @Project Page    None!
 * @docs            None!
 *
 */

if (!defined('TAU'))
{
	exit;
}


class TauInput
{
	// Post
	// ---------------------------------------------------------------------------
	public static function post($field)
	{
		return (isset($_POST[$field])) ? $_POST[$field] : false;
	}


	// Get
	// ---------------------------------------------------------------------------
	public static function get($field)
	{
		return (isset($_GET[$field])) ? $_GET[$field] : false;
	}


	// Cookie
	// ---------------------------------------------------------------------------
	public static function cookie($field)
	{
		return (isset($_COOKIE[$field])) ? $_COOKIE[$field] : false;
	}


	// Files
	// ---------------------------------------------------------------------------
	public static function files($field)
	{
		return (isset($_FILES[$field])) ? $_FILES[$field] : false;
	}


	// Request
	// ---------------------------------------------------------------------------
	public static function request($field)
	{
		return (isset($_REQUEST[$field])) ? $_REQUEST[$field] : false;
	}

	
	// Exists
	// ---------------------------------------------------------------------------
	public static function exists($field, $post_only = false)
	{
		if ($post_only)
		{
			return isset($_POST[$field]);
		}
		
		return isset($_REQUEST[$field]);
	}
	

	// Integer
	// ---------------------------------------------------------------------------
	public static function int($fields, $default = 0, $post_only = false)
	{
		if (!is_array($fields)) {
			$fields = array($fields);
		}

		foreach ($fields AS $field)
		{
			$result = self::post($field);
			if ($result !== false)
			{
				return (int) $result;
			}

			if (!$post_only)
			{
				$result = self::get($field);
				if ($result !== false)
				{
					return (int) $result;
				}

				$result = self::cookie($field);
				if ($result !== false)
				{
					return (int) $result;
				}
			}
		}

		return (int) $default;
	}

	// String
	// ---------------------------------------------------------------------------
	public static function string($fields, $default = '', $post_only = false)
	{
		if (!is_array($fields)) {
			$fields = array($fields);
		}

		foreach ($fields AS $field)
		{
			$result = self::post($field);

			if ($result !== false)
			{
				return (string) $result;
			}

			if (!$post_only)
			{
				$result = self::get($field);
				if ($result !== false)
				{
					return (string) $result;
				}

				$result = self::cookie($field);
				if ($result !== false)
				{
					return (string) $result;
				}
			}
		}

		return (string) $default;
	}

	// Boolean
	// ---------------------------------------------------------------------------
	static public function boolval( $value )
	{
		if ( (boolean) $value === false ) {
			return false;
		}

		if ( is_string( $value ) )
		{
			$value = strtolower( $value );
			if ( $value === 'no' || $value === 'false' || $value === '0' ) {
				return false;
			}
		}

		return (boolean) $value;
	}


	public static function boolean($fields, $default = false, $post_only = false)
	{
		if (!is_array($fields)) {
			$fields = array($fields);
		}

		foreach ($fields AS $field)
		{
			$result = self::post($field);
			if ($result !== false)
			{
				return static::boolval($result);
			}

			if (!$post_only)
			{
				$result = self::get($field);
				if ($result !== false)
				{
					return static::boolval($result);
				}

				$result = self::cookie($field);
				if ($result !== false)
				{
					return static::boolval($result);
				}
			}
		}

		return (boolean) $default;
	}


	public static function xssString($fields, $default = '', $post_only = false)
	{
		return htmlentities(self::string($fields, $default, $post_only));
	}

}
