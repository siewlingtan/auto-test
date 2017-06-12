<?php
namespace Context;
use Behat\Behat\Context\Context as ContextInterface;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;

abstract class BaseContext extends RawMinkContext implements ContextInterface, SnippetAcceptingContext
{
	public function __call($method, $parameters)
	{
	    // we try to call the method on the Page first
	    $page = $this->getSession()->getPage();
	    if (method_exists($page, $method)) {
	        return call_user_func_array(array($page, $method), $parameters);
	    }

	    // we try to call the method on the Session
	    $session = $this->getSession();
	    if (method_exists($session, $method)) {
	        return call_user_func_array(array($session, $method), $parameters);
	    }

	    // could not find the method at all
	    throw new \RuntimeException(sprintf(
	        'The "%s()" method does not exist.', $method
	    ));
	}
}
?>