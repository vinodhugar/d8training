<?php

namespace Drupal\d8_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\d8_custom\weatherconfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Block(
 * 	 id = "d8_custom_weather_block",
 * 	 admin_label = @Translation("Weather Block"),
 * 	 category = @Translation("Custom")
 * )
 */
class plugin extends BlockBase implements ContainerFactoryPluginInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, weatherconfig $weather_config)
	{
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->weatherconfig = $weather_config;
	}
	/**
	 * Builds and returns the renderable array for this block plugin.
	 *
	 * If a block should not be rendered because it has no content, then this
	 * method must also ensure to return no content: it must then only return an
	 * empty array, or an empty array with #cache set (with cacheability metadata
	 * indicating the circumstances for it being empty).
	 *
	 * @return array A renderable array representing the content of the block.
	 *
	 * @see \Drupal\block\BlockViewBuilder
	 */
	public function build()
	{
		return [
				'#markup' => implode('|', $this->weatherconfig->fetch($this->configuration['city'])),
				//'#humidity' =>$result['humidity'],
				//'#temp_min' =>$result['temp_min'],
				//'#temp_max' =>$result['temp_max'],
				//'#attached' => [
				//'library' => 'd8_custom/weather-widget',
				//],
			];
	}

	/**
	 * {@inheritdoc}
	 */
	public function blockForm($form, FormStateInterface $form_state)
	{

		return
		[
			'city'=> [
				'#type'=> 'textfield',
				'#title'=> 'Weather Block',
				'#default_value'=> $this->configuration['city'],
			],

		];
	}
	/**
	 * {@inheritdoc}
	 */
	public function blockSubmit($form, FormStateInterface $form_state)
	{
		$this->setConfigurationValue('city', $form_state->getValue('city'));
	}
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
	{
		return new static($configuration, $plugin_id, $plugin_definition, $container->get('d8_custom.weather_config'));
	}

}
?>