<?php 
namespace Drupal\d8_custom\controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

class D8CustomController extends ControllerBase{
	
	public function staticContent() {
		
		return [
				
		'#markup'=>"Hello World! This is Vinod From Jupiter" 
		];
	}
	public function dynamicContent($ujjwal) {
		
		return [
				
				'#markup'=>$ujjwal
		];
		
	}
	public function entityContent(Node $node) {
		
		return [
				
				'#markup' =>$node->getTitle(),
		];
	}
	public function anothoerstaticContent() {
		
		return [
				
				'#markup' =>"Hello World! This is Ujjwal From Mars"
		];
	}
	public function entityAccessCheck(Node $node, AccountInterface $account)
	{
		return AccessResult::allowedif($node->getOwnerId() == $account->id());;
	}
		
}
?>