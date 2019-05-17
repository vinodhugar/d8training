<?php
namespace Drupal\d8_custom;


use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;
use Drupal\Component\Serialization\Json;

class weatherconfig
{
	private $client;
	private $config_factory;

	public function __construct(Client $client, ConfigFactory $config_factory)
	{
		$this->Client = $client;
		$this->ConfigFactory = $config_factory;
	}
	public function fetch($city)
	{
		$First_Name = $this->ConfigFactory->get('d8_custom.weather_form')->get('First_Name');
		$url_string = "http://localhost/drupal-8.7.1/" . $city .".json?app_id=". $First_Name;
		//return $url_string;


		$res = $this->Client->request('GET', $url_string);

		// 'application/json; charset=utf8'
		return Json::decode($res->getBody()->getContents())['main'];

	}
}
?>