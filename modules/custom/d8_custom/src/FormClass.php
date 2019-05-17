<?php 
namespace Drupal\d8_custom;

use Drupal\Core\Database\Connection;

class FormClass{
	
	private $database;
	
	public function __construct(Connection $connection)
	{
		$this->database = $connection;
	}
	
	public function read()
	{
		$this->database->select('form', 'f')
		->fields('f', ['Name'])
		->range(0,1)
		->execute()->fetchField();
	}
	public function write($name)
	{
		$this->database->insert('form')
		->fields(['Name'], [$name])
		->execute();
	}
}
?>