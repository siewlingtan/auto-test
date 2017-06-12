<?php
date_default_timezone_set("Asia/Singapore");
use Behat\Behat\Context\Context as ContextInterface;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Exception\ElementNotFoundException;

class JustForTestContext extends RawMinkContext implements ContextInterface, SnippetAcceptingContext
{
    //use CommonTrait;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    /*public function __construct($baseUrl, $tempPath)
    {
        $this->baseUrl = $baseUrl;
        $this->tempPath = $tempPath;
    }*/

    public function __construct()
    {

    }

}
?>