<?php
namespace Drupal\d8_custom\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Drupal\d8_custom\Event\D8NodeinsertEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class eventsubscriber implements EventSubscriberInterface
{
	/**
	* Returns an array of event names this subscriber wants to listen to.
	*
	* The array keys are event names and the value can be:
	*
	*  * The method name to call (priority defaults to 0)
	*  * An array composed of the method name to call and the priority
	*  * An array of arrays composed of the method names to call and respective
	*    priorities, or 0 if unset
	*
	* For instance:
	*
	*  * ['eventName' => 'methodName']
	*  * ['eventName' => ['methodName', $priority]]
	*  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
	*
	* @return array The event names to listen to
	*/
	public static function getSubscribedEvents()
    {
    	return [KernelEvents::RESPONSE => 'onResponse',
    			D8NodeinsertEvent::NODE_INSERT => 'onNodeInsert',];
    }

    public function onResponse(FilterResponseEvent $event)
    {
    	$response = $event->getResponse();
    	$response->headers->add(['hello' => 'world']);
    }

    public function onNodeInsert(D8NodeinsertEvent $event)
    {
    	$node = $event->getNode();
    	drupal_set_message($node->getTitle());
    }
}
?>