<?php

use Behat\Behat\Context\Context as ContextInterface;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Exception\ExpectationException;
/**
 * Defines application features from the specific context.
 */
//class FeatureContext implements Context, SnippetAcceptingContext
//class FeatureContext extends MinkContext
class FeatureContext extends MinkContext implements ContextInterface, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct($baseUrl, $tempPath)
    {
        $this->baseUrl = $baseUrl;
        $this->tempPath = $tempPath;
    }

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

    protected function throwExpectationException($message)
    {
        throw new Exception($message);
    }

    public function spin($lambda, $wait = 60, $find, $contactID=NULL)
    {
        
        for ($i = 0; $i < $wait; $i++)
        {
            try {
                $return = $lambda($this);
                if ($return===true) {
                    return true;
                }
            } catch (Exception $e) {
                echo "catch: ".$i."\n";
            }
            echo $i."\n";
            sleep(1);
        }

        echo $contactID . ' / ' . $find . '\n';
        echo $wait . '\n';

        ($contactID)? 
        $message = sprintf('For "%s", the "%s" was not found anywhere in the current page.', $contactID, $find)
        : $message = sprintf('The "%s" was not found anywhere in the current page.', $find);
        
        $this->throwExpectationException($message);
    }

    /**
     * @When I find the button :button then press it
     */
    public function iFindTheButtonThenPressIt($button)
    {
        $button = $this->fixStepArgument($button);
        $this->spin(function($context) {
            return($context->getSession()->getPage()->findById($button)->isVisible());
        });
        $this->getSession()->getPage()->pressButton($button);
    }

    /**
     * @Then I wait for :seconds seconds until I see :arg2
     */
    public function iWaitForSecondsUntilISee($seconds, $find, $contactID=NULL)
    {
        try
        {
            $this->spin(function(FeatureContext $context) use ($find) {
                $context->assertSession()->pageTextContains($find);
                return true;
            },$seconds,$find,$contactID);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
        
    }

    /**
     * @Given I have the list of Contact ID to check in Student 360 View:
     */
    public function iHaveTheListOfContactId(TableNode $table)
    {
        $hash = $table->getHash();
        $count = 0;
        foreach ($hash as $row) {
            if($count !== 0) // not first time, then click
            {
                $this->clickLink("Search Student");
            }
            $this->iWaitForSecondsUntilISee(5, "Student Search",$row['ctnumber']);
            $this->fillField("Contact ID", $row['ctnumber']);
            $this->pressButton("Search");
            $this->iWaitForSecondsUntilISee(5, "Displaying 1",$row['ctnumber']);
            $this->clickLink("360VIEW");
            $this->iWaitForSecondsUntilISee(5, "Student Information");
            $count++;
        }
    }

    /**
     *  @Transform table:name,prices
     */
    public function convertFruitsTableToArray(TableNode $banana)
    {
        $fruits = array();
        foreach($banana as $fruit)
        {
            $fruits[] = array(
                    "name"=>$fruit['name'],
                    "prices"=>$fruit['prices']
                );
        }
        return $fruits;
    }

    /**
     *  @When I want to buy fruits:
     */
    public function buyFruits(array $greenkiwi)
    {
        echo "\nbuyFruits:\n";
        foreach($greenkiwi as $fruitt)
        {
            echo $fruitt['name'] . " / " . $fruitt['prices'] . "\n";
        }
    }

    /**
     *  @Transform table:names,prices
     */
    public function sth(TableNode $banana)
    {
        $fruits = '';
        foreach($banana as $fruit)
        {
            $fruits.=$fruit['names'] . " / " . $fruit['prices'] . "\n";
        }
        return $fruits;
    }


    /**
     * @When I want to buy cars:
     */
    public function iWantToBuyCars($table)
    {
        echo "\niWantToBuyCars:\n";
        var_dump($table);
    }


    /**
     * @Transform table:name,followers
     */
    public function castUsersTable(TableNode $usersTable)
    {
        $users = array();
        foreach ($usersTable->getHash() as $userHash) {
            $user = new User();
            $user->setUsername($userHash['name']);
            $user->setFollowersCount($userHash['followers']);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * @Given the following users:
     */
    public function pushUsers(array $users)
    {
        echo "\npushUsers:\n";
        foreach($users as $user)
        {
            echo $user->name . " / " . $user->followers . "\n";
        }
        // do something with $users
    }

    /**
     * @Then I expect the following users:
     */
    public function assertUsers(array $users)
    {
        echo "\nassertUsers:\n";
        foreach($users as $user)
        {
            echo $user->name . " / " . $user->followers . "\n";
        }
    }
}
