<?php

namespace Drupal\d8_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxy;

/**
 * @Block(
 * 	 id = "d8_user_email",
 * 	 admin_label = @Translation("User Email Block"),
 * 	 category = @Translation("Custom")
 * )
 */

class blockplugin extends BlockBase implements ContainerFactoryPluginInterface
{
	private $account;

	public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxy $account )
	{
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->account = $account;
	}

	public function build()
	{
		return [
				'#markup' =>$this->account->getEmail(),
				'#cache' =>['contexts'=> ['user'],],
		];
	}

	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
	{
		return new static($configuration, $plugin_id, $plugin_definition, $container->get('current_user'));
	}
}

?>