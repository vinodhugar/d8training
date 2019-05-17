<?php
namespace Drupal\d8_custom\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Access\AccessResult;

Class  D8EntityAccessCheck implements AccessInterface{
	
	public function access(Node $node, AccountInterface $account)
	{
		return AccessResult::allowedif($node->getOwnerId() == $account->id());;
	}
}
?>