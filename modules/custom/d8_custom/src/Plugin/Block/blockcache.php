<?php
namespace Drupal\d8_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Block(
 * 	 id = "d8_custom.block_cache",
 * 	 admin_label = @Translation("Cache Block"),
 * 	 category = @Translation("Custom")
 * )
 */

class blockcache extends BlockBase implements ContainerFactoryPluginInterface
{

	private $database;
	public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database)
	{
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->database = $database;
	}

	public function build()
	{
		$build = $tags = [];
		$output = '';

		$query = $this->database->select('node_field_data', 'nfd')
		->fields('nfd', ['nid', 'title'])
		->range(0,3)
		->orderBy('nid', 'DESC')
		->execute();

		$results = $query->fetchAll();

		foreach ($results as $result)
		{
			$output .= '|' . $result->title;
			$tags[] = 'node:' . $result->nid;
		}

		$build['#markup'] = $output;
		$build['#cache']['tags'] = $tags + ['node_list'];

		return $build;
	}

	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
	{
		return new static($configuration, $plugin_id, $plugin_definition, $container->get('database'));

	}

}
?>