<?php
/**
 * APC driver for TAU Cache module
 *
 * @Author          theyak
 * @Copyright       2013
 * @Project Page    https://github.com/theyak/Tau
 * @Dependencies    TauError
 */

if (!defined('TAU'))
{
	exit;
}

class TauCacheApc
{
	/**
	 * Reference to cache container
	 */
	private $cache;



	function __construct( $cache )
	{
		$this->cache = $cache;

		if ( ! function_exists( 'apc_store' ) )
		{
			throw new exception( "APC not installed. Can not use for cache." );
		}
	}



	/**
	 * Cache a variable in the data store
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param int $ttl Time to live. 0 to live forever
	 */
	function set( $key, $value, $ttl = 3600 )
	{
		apc_store( $key, $value, $ttl );
	}



	/**
	 * Fetch a stored variable from the cache
	 *
	 * @param string $key
	 *
	 * @return mixed, false on error
	 */
	function get( $key )
	{
		$success = true;
		$value = apc_fetch( $key, $success );
		if ( $success )
		{
			return $value;
		}
		return false;
	}



	/**
	 * Check of a key exists in cache
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	function exists( $key )
	{
		return apc_exists( $key );
	}



	/**
	 * Remove a cached entry
	 *
	 * @param string $key
	 */
	function remove( $key )
	{
		apc_delete( $key );
	}



	/**
	 * Set note for variable. Not valid for apc.
	 *
	 * @param string $note
	 */
	function setNote( $note )
	{
		;
	}



	/**
	 * Add value to key
	 *
	 * @param string $key
	 * @param number $step
	 *
	 * @return number|false
	 */
	function incr( $key, $step = 1 )
	{
		$success = true;
		$value = apc_inc( $key, $step, $success );

		if ( $success )
		{
			return $value;
		}
		return false;
	}
}
