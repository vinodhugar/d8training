<?php 

namespace Drupal\d8_custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class D8WeatherConfigForm extends ConfigFormBase
{
	/**
	 * Gets the configuration names that will be editable.
	 *
	 * @return array
	 *   An array of configuration object names that are editable if called in
	 *   conjunction with the trait's config() method.
	 */
	protected function getEditableConfigNames()
	{
		return ['d8_custom.weather_form',];
	}
	
	public function getFormId()
	{
		return 'register_form';
	}
	public function buildForm(array $form, FormStateInterface $form_state)
	{
		$form['First_Name'] = [
				'#type' => 'textfield',
				'#title' => 'Enter your first name',
				'#description' => 'Must be characters only',
				'#default_value' => $this->config('d8_custom.weather_form')->get('First_Name'),
		];
		return parent::buildForm($form, $form_state);
	}
	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		$this->config('d8_custom.weather_form')
		->set('First_Name',$form_state->getValue('First_Name'))
		->save();
		parent::submitForm($form, $form_state);
	}
}
?>