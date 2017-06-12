<?php
use Behat\Testwork\Tester\Result\TestResult;
use Behat\Mink\Driver\Selenium2Driver;

class ScreenshotContext extends MasterContext
{
    protected $scenarioTitle = null;
    protected static $wsendUser = null;

    /**
     * @BeforeScenario
     */
    public function cacheScenarioName($event)
    {
        // it's only to have a clean screenshot name later
        $this->scenarioTitle = $event->getScenario()->getTitle();
    }

    /**
     * @AfterStep
     */
    public function takeScreenshotAfterFailedStep($event)
    {
        if ($event->getTestResult()->getResultCode() !== TestResult::FAILED) {
            return;
        }

        $this->takeAScreenshot();
    }

    /**
     * @Then take a screenshot
     */
    public function takeAScreenshot()
    {
        if (!$this->isJavascript()) {
            print "Screenshot cannot be taken from non javascript scenario.\n";

            return;
        }

        $screenshot = $this->getSession()->getDriver()->getScreenshot();

        $filename = $this->getScreenshotFilename();
        file_put_contents($filename, $screenshot);

        $url = $this->getScreenshotUrl($filename);

        print sprintf("Screenshot is available :\n%s", $url);
    }

    protected function getScreenshotUrl($filename)
    {
        if (!self::$wsendUser) {
            self::$wsendUser = $this->getWsendUser();
        }
        
        if (function_exists('curl_file_create')) 
        { // php 5.6+
          $cFile = curl_file_create($filename);
        }
        else 
        {
          $cFile = '@' . realpath($filename);
        }
        $post = array('uid' => self::$wsendUser,'filehandle'=> $cFile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://wsend.net/upload_cli');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        $result=curl_exec ($ch);
        curl_close ($ch);

        /*exec(sprintf(
            'curl -F "uid=%s" -F "filehandle=@%s" %s 2>/dev/null',
            self::$wsendUser,
            $filename,
            'https://wsend.net/upload_cli'
        ), $output, $return);*/

        return $result[0];
    }

    protected function getWsendUser()
    {
        // create a wsend anonymous user
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,"https://wsend.net/createunreg");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'start=1');
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $wsendUser = curl_exec($curl);
        curl_close($curl);
        if ($wsendUser !== false)
        {
            return $wsendUser;
        }
        else
        {
            echo "\n"; var_dump($wsendUser); echo "\n";
            throw new Exception("Failed to get the wSendUser");
        }
    }

    protected function getScreenshotFilename()
    {
        $filename = $this->scenarioTitle;
        $filename = preg_replace("#[^a-zA-Z0-9\._-]#", '_', $filename);

        return sprintf('%s/%s.png', "/tmp", $filename);
        //return sprintf('%s/%s.png', sys_get_temp_dir(), $filename);
    }

    protected function isJavascript()
    {
        return $this->getSession()->getDriver() instanceof Selenium2Driver;
    }
}