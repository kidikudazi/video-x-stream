<?php 

/**
* Connection Section
*/

class DBConnect
{
	protected $serverName;
	protected $serverUser;
	protected $serverPass;
	protected $dbName;

	function __construct()
	{
		# code...

		$this->serverName = 'localhost';
		$this->serverUser = 'root';
		$this->serverPass = '';
		$this->dbName = 'stream';
	}

	/**
	* coonect to database
	*/
	public function iConnect(){
		// connection string
		$connect = mysqli_connect($this->serverName, $this->serverUser, $this->serverPass, $this->dbName);

		if(!$connect){
			die("Connection Failed.");
		}

		return $connect;
	}
}



?>