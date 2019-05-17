<?php 
namespace Drupal\d8_custom\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_custom\FormClass;

class D8SimpleForm extends FormBase implements ContainerInjectionInterface
{
	private $dbWrapper;
	
	public function __construct(FormClass $db_wrapper)
	{
		$this->dbWrapper = $db_wrapper;
	}
	/**
	 * Returns a unique string identifying the form.
	 *
	 * The returned ID should be a unique string that can be a valid PHP function
	 * name, since it's used in hook implementation names such as
	 * hook_form_FORM_ID_alter().
	 *
	 * @return string
	 *   The unique string identifying the form.
	 */
	public function getFormId()
	{
		return 'register_form';
	}
	/**
	 * Form constructor.
	 *
	 * @param array $form
	 *   An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *   The current state of the form.
	 *
	 * @return array
	 *   The form structure.
	 */
	public function buildForm(array $form, FormStateInterface $form_state)
	{
		$form['Name'] = [
				'#type' => 'textfield',
				'#title' => 'Enter your first name',
				'#description' => 'Must be characters only',
		];
		$form['submit'] = [
				'#type'=> 'submit',
				'#value' => 'Submit',
		];
		return $form;
		
	}
	
	/**
	 * Form validation handler.
	 *
	 * @param array $form
	 *   An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *   The current state of the form.
	 */
	public function validateForm(array &$form, FormStateInterface $form_state)
	{
		if(strlen($form_state->getValue('Name'))<5){
			$form_state->setErrorByName('Name','ERROR!! Minimum 5 Letters');
		}
	}
	/**
	 * Form submission handler.
	 *
	 * @param array $form
	 *   An associative array containing the structure of the form.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *   The current state of the form.
	 */
	public function submitForm(array &$form, FormStateInterface $form_state)
	{
		$name = $form_state->getValue('Name');
		$this->dbWrapper->write($name);
		drupal_set_message($name);	
	}
	/**
	 * Instantiates a new instance of this class.
	 *
	 * This is a factory method that returns a new instance of this class. The
	 * factory should pass any needed dependencies into the constructor of this
	 * class, but not the container itself. Every call to this method must return
	 * a new instance of this class; that is, it may not implement a singleton.
	 *
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	 *   The service container this instance should use.
	 */
	public static function create(ContainerInterface $container)
	{
		return new static($container->get('d8_custom.simple_form'));
	}
	
	
	
}
?>