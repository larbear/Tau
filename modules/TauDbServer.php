<?php
/**
 * Information about a database server to pass to TauDb::init
 *
 * @Author          theyak
 * @Copyright       2012
 * @Project Page    None!
 * @Dependencies    TauError, TauFS
 * @Documentation   None!
 *
 */

if (!defined('TAU'))
{
	exit;
}

class TauDbServer
{
	public $host;
	public $port;
	public $username;
	public $password;
	public $database = '';
	public $connection = false;
	public $terminate_on_error = false;

	function __construct(
		$database = '',
		$username = 'root',
		$password = '',
		$host = '127.0.0.1',
		$port = 0
	)
	{
		$this->database = $database;
		$this->username = $username;
		$this->password = $password;
		$this->host = $host;
		$this->port = $port;
	}
}
