<?php
date_default_timezone_set("Asia/Singapore");
use Behat\Behat\Context\Context as ContextInterface;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Exception\ElementNotFoundException;
/**
 * Defines application features from the specific context.
 */
//class FeatureContext implements Context, SnippetAcceptingContext
//class FeatureContext extends MinkContext
class MasterContext extends MinkContext implements ContextInterface, SnippetAcceptingContext
{
    use CommonTrait;
    use CheckDownloadPdfTrait;
    use MurdochInifiniteLoopTrait;
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

    private $params = array();

    public function __construct(array $parameters)
    {
        $this->params = $parameters;
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
        throw new ExpectationException($message, $this->getSession());
    }

    public function spin($lambda, $wait = 60, $find, $contactID=NULL)
    {
        for ($i = 0; $i <= $wait; $i++)
        {
            try {
                $return = $lambda($this);
                if ($return===true) {
                    return true;
                }
            } catch (Exception $e) {
                if($i==$wait)
                {
                    throw $e;
                }
            }
            sleep(1);
        }

        ($contactID)? 
        $message = sprintf('For "%s", the "%s" was not found anywhere in the current page.', $contactID, $find)
        : $message = sprintf('The "%s" was not found anywhere in the current page.', $find);
        
        $this->throwExpectationException($message);
    }

    /**
     * @When I login to KSS
     */
    public function iLoginToKss()
    {
        echo $this->getMinkParameter('base_url')."\n";
        $this->fillField("Username", $this->params['user']);
        $this->fillField("LoginForm_password", $this->params['password']);
        $this->pressButton("Login");
        $this->iWaitForSecondsUntilISee(10, "Student Search");
    }

    /**
     * @Then I wait for :seconds seconds until I see :find
     */
    public function iWaitForSecondsUntilISee($seconds, $find, $contactID=NULL)
    {
        try
        {
            $this->spin(function(MasterContext $context) use ($find) {
                $context->assertSession()->pageTextContains($find);
                return true;
            },$seconds,$find,$contactID);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

     /**
     * @Then I wait for :seconds seconds until I can select :option from :select
     */
    public function iWaitForSecondsUntilIcanSelectOptionFromSelect($seconds, $option, $select, $additional='')
    {
        try
        {
            $this->spin(function(MasterContext $context) use ($option,$select) {
                $this->selectOption($select, $option);
                return true;
            },$seconds,$option,$select);
        }
        catch(Exception $e)
        {
            if($additional!='')
            {
                $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(2, $option, $additional);
            }
            else
            {
                throw new Exception($e->getMessage());
            }
        }
    }

 
    /**
     * @Then I wait :seconds seconds until I can fill :value in :field
     */
    public function iWaitToFillValueInField($seconds, $field, $value)
    {
        try
        {
            $this->spin(function(MasterContext $context) use ($field, $value) {
                $this->fillField($field, $value);
                return true;
            },$seconds,$value);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }   

    /**
     * @Then I wait for :seconds seconds until I can visit :url
     */
    public function iWaitForSecondsUntilIcanVisitUrl($seconds, $url)
    {
        try
        {
            $this->spin(function(MasterContext $context) use ($url) {
                $this->visit($url);
                return true;
            },$seconds,$url);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @Then I wait for :seconds seconds to click the button :arg2
     */
    public function iWaitForSecondsUntilISeeTheButton($seconds, $find)
    {
        $this->commonSpin("button",$seconds,$find);
        /*$this->spin(function() use ($find) {
            $this->pressButton($find); // Example: Look Up
            return true;
        },$seconds,$find);*/
    }

    /**
     * @Then I wait for :seconds seconds to click the link :arg2
     */
    public function iWaitForSecondsUntilISeeTheLink($seconds, $find)
    {
        $this->commonSpin("link",$seconds,$find);
        /*$this->spin(function() use ($find) {
            $this->clickLink($find); // Example: Select
            return true;
        },$seconds,$find);*/
    }

    public function commonSpin($type,$seconds, $find)
    {
        $this->spin(function() use ($find,$type) {
            if($type=="link")
            {
                $this->clickLink($find); // Example: Select
            }
            else if($type=="button")
            {
                $this->pressButton($find); // Example: Look Up
            }
            return true;
        },$seconds,$find);
    }

    /**
     * @When I wait and repeat again for enhanced session date page
     */
    public function iWaitAndRepeatAgainForEnhancedSessionDate()
    {
        while(1)
        {
            $this->visit("http://kss.kaplan.net/index.php/modinstance/midSessionDates/19838");
            $this->iWaitForSecondsUntilISee(10, "PTADipMgt29_OB (19838) - Session Dates");
            $this->show_me_a_screenshot();
            $this->iSleepForSeconds(1500);
        }
    }

    /**
     * @Then I sleep for :arg1 seconds
     */
    public function iSleepForSeconds($arg1)
    {
        sleep($arg1);
    }

    /**
     * This works for Selenium and other real browsers that support screenshots.
     *
     * @Then show me a screenshot
     */
    public function show_me_a_screenshot($name='') {

        $image_data = $this->getSession()->getDriver()->getScreenshot();
        $filePath = '/tmp/'.$this->getMinkParameter('browser_name').'/'.$name.'/';
        if (!file_exists($filePath)) {
            mkdir($filePath, 0777, true);
        }
        
        $file_and_path = $filePath.$name."_".preg_replace('#[^a-zA-Z0-9\._-]#', '', 'screenshot_')."-".date('Y-m-d H-i-s').".jpg";
        
        file_put_contents($file_and_path, $image_data);

        if (PHP_OS === "Darwin" && PHP_SAPI === "cli") {
            exec('open -a "Preview.app" ' . $file_and_path);
        }

    }

    /**
     * This works for the Goutte driver and I assume other HTML-only ones.
     *
     * @Then /^show me the HTML page$/
     */
    public function show_me_the_html_page_in_the_browser() {

        $html_data = $this->getSession()->getDriver()->getContent();
        $file_and_path = '/tmp/behat_page.html';
        file_put_contents($file_and_path, $html_data);

        if (PHP_OS === "Darwin" && PHP_SAPI === "cli") {
            exec('open -a "Safari.app" ' . $file_and_path);
        };
    }

    /**
     * @When I click on :element
     */
    public function iClickOn2($element)
    {
        $page = $this->getSession()->getPage();
        $findName = $page->find("css", $element);
        if (!$findName) {
            throw new Exception($element . " could not be found");
        } else {
            $findName->click();
        }
    }

    /**
     * @Then I switch to new tab
     */
    public function iSwitchToNewTab()
    {
        $windowNames = $this->getWindowNames();
        if(count($windowNames) > 1) {
            $this->switchToWindow($windowNames[1]);
        }
    }

    /**
     * @When I click on :CTnumber letter of verification :download download
     */
    public function iClickOnLetterOfVerificationDownload($CTnumber, $download,$title="Letter of Verification")
    {
        $file = array("pdf"=>"letterOfVerificationPDF","document"=>"letterOfVerification/");
        $this->spin(function() use ($file,$download,$CTnumber,$title)
        {
            $aaaa = $this->findAll('css', "a[href*='".$file[$download]."'][href*='".$CTnumber."'][title='".$title."']");
            $count = count($aaaa);

            if (null === $aaaa || empty($aaaa))
            {
                throw new \Exception('The element is not found');
            }

            $count = count($aaaa);
            if($count > 1)
            {
                throw new Exception('More than one record to click. Please check.');
            }

            foreach ($aaaa as $aa)
            {
                if ($aa->hasAttribute('href'))
                {
                    $aa->click();
                    $this->iSwitchToNewTab();
                    $this->iSleepForSeconds(5);
                }
                else 
                {
                    throw new Exception('There is no link for '.$download.' download.');
                }
            }
            return true;
        },5,$download,$CTnumber);
    }

    /*/**
     * @When I click on :student letter of verification :filetype download
     */
    /*
    public function iClickLetterOfVerification($student,$filetype,$title="Letter of Verification")
    {
        if(!empty($title))
        {
            $title = "[title='".$title."']";
        }
        //= "intake/letterOfVerificationPDF/4299?studentid=CT0273447";

        $aaaa = $this->findAll('css', "a[href*='letterOfVerificationPDF'][href*='CT0273447'][title='Letter of Verification']");
        $count = count($aaaa);
        die($count);

        $this->spin(function() use ($arg1,$title,$class)
        {
//            $this->pressButton($find); // Example: Look Up
            $aaaa = $this->findAll('css', "a[href*='".$arg1."']".$class.$title);
            if (null === $aaaa || empty($aaaa))
            {
                throw new \Exception('The element is not found');
            }

            $count = count($aaaa);
            if($count > 1)
            {
                echo "count: ".$count."\n";
                throw new Exception('More than one record to click. Please check.');
            }

            foreach ($aaaa as $aa)
            {
                if ($aa->hasAttribute('href'))
                {
                    $aa->click();
                }
                else 
                {
                    throw new Exception('There is no link maginifying link for '.$arg1);
                }
            }
            return true;
        },$seconds,$arg1);
    }
*/

    /**
     * @Then I wait until :seconds seconds to click the magnifying glass on the row :arg1 (title=:title class=:class)
     * @Then On the row :arg1, I click the magnifying glass and wait for :seconds seconds
     * @Then On the row :arg1, I click the magnifying glass and wait for :seconds seconds and title is :title
     * @Then On the row :arg1, I click the magnifying glass and wait for :seconds seconds and class is :class
     * @Then On the row :arg1, I click the magnifying glass and wait for :seconds seconds and title is :title and class is :class
     */
    public function iWillClickTheMagnifyingGlassOnTheRowOf($seconds,$arg1,$class='',$title='')
    {

        if(!empty($title))
        {
            $title = "[title='".$title."']";
        }

        if(!empty($class))
        {
            $class = "[class='".$class."']";
        }

        $this->spin(function() use ($arg1,$title,$class)
        {
//            $this->pressButton($find); // Example: Look Up
            $aaaa = $this->findAll('css', "a[href$='".$arg1."']".$class.$title);
            if (null === $aaaa || empty($aaaa))
            {
                throw new \Exception('The element is not found');
            }

            $count = count($aaaa);
            if($count > 1)
            {
                echo "count: ".$count."\n";
                throw new Exception('More than one record to click. Please check.');
            }

            foreach ($aaaa as $aa)
            {
                if ($aa->hasAttribute('href'))
                {
                    $aa->click();
                }
                else 
                {
                    throw new Exception('There is no link maginifying link for '.$arg1);
                }
            }
            return true;
        },$seconds,$arg1);
        
    }

    /**
     * @Then I will find css :arg1 element has attribute :arg2 should contain the value :arg3
     */
    public function iWillFindCssElementHasAttributeShouldContainTheValue($arg1, $arg2, $arg3)
    {
        $element = $this->find('css',$arg1);
        if(!$element)
        {
            throw new Exception("css element '".$arg1."' is not found.");
        }

        if(!$element->hasAttribute($arg2))
        {
            throw new Exception("There is no attribute '".$arg2."' under the css element '".$arg1."'");
        }

        if($element->getAttribute($arg2) !== $arg3)
        {
            throw new Exception("There is no value '".$arg3."' in attribute '".$arg2."' under the css element '".$arg1."'");
        }
        return true;
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
            $this->iWaitForSecondsUntilISee(20, "Student Information");
            $count++;
        }
    }

    /**
     * @When I manually press :arg1
     */
    public function iManuallyPress($arg1)
    {
        $script = "jQuery.event.trigger({ type : 'keypress', which : '" . $arg1 . "' });";
        $this->evaluateScript($script);
    }

    /**
     * @Then I visit all the upload links under the Upload center:
     */
    public function iVisitAllTheUploadLinksUnderTheUploadCenter(TableNode $table)
    {
            /*$escapedValue = $this->getSession()->getSelectorsHandler()->xpathLiteral('Upload');
            $aaaa = $this->findAll('named',array('link',$escapedValue));*/

            //$Texts = array("Upload Absentee Dates","Upload students","Upload Grades","Upload students","Upload images","Dashboard","Upload Session Dates");
            //$links = array("Attendances Upload", "Enrollments Upload", "Result Upload", "Student Record Upload", "Student Images Upload", "Absentee Batch Upload Upload", "Classes Session dates Upload");

            $hash = $table->getHash();
            $count = 0;
            foreach ($hash as $row) 
            {
                if($count !== 0) // not first time, then click
                {
                    $this->clickLink("Upload Center");
                    $this->iWaitForSecondsUntilISee(500, $row['Upload']);
                }
//                echo $count."\n";

                $aaaa = $this->findAll('css', ".pheading");
                foreach($aaaa as $aa)
                {
//                    echo $aa->getText()."\n";
                    if($row['Upload'] == $aa->getText())
                    {
                        $bb = $aa->find('css','a');
                        if (null === $bb || empty($bb))
                        {
                            throw new \Exception('The bb element is not found');
                        }
                        if($bb->getText() == 'Upload')
                        {
//                            echo $bb->getAttribute('href')."\n";
//                            echo $bb->getText()."\n\n";
                            $bb->click();
                            $this->iWaitForSecondsUntilISee(10, $row['Header']);
                            goto DONECLICKING;
                        }
                    }
                } DONECLICKING:
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
	
	 /**
     * @Then I should see the following:
     */
    public function iShouldSeeTheFollowing(TableNode $table)
    {
        $this->assertSession()->elementExists('css', '.pheading');
    }
}
