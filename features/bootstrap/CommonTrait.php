<?php
trait CommonTrait
{
    /**
     * @Given there is a(n) :product, which costs £:price
     */
    public function thereIsAWhichCostsPs($product, $price)
    {
        throw new PendingException();
    }
    
    /**
     * @AfterStep
     */
    public function takeScreenshotAfterFailedStep($event)
    {
      if ($event->getTestResult()->getResultCode() === \Behat\Testwork\Tester\Result\TestResult::FAILED) {
        $driver = $this->getSession()->getDriver();
        if ($driver instanceof \Behat\Mink\Driver\Selenium2Driver) {
               $stepText = $event->getStep()->getText();
               $fileName = preg_replace('#[^a-zA-Z0-9\._-]#', '', $stepText)."-".date('Y-m-d H-i-s');
               $fileNamePng = $fileName.'.png';
               $filePath = '/tmp/'.$this->getMinkParameter('browser_name');
               $fileExist = $filePath.DIRECTORY_SEPARATOR.$fileNamePng;
               if (!file_exists($filePath)) {
                    mkdir($filePath, 0777, true);
               }
               if (file_exists($fileExist))
               {
                    $fileName.= "-".date('Y-m-d H-i-s').".png";
                }
                else
                {
                    $fileName = $fileNamePng;
                }
                $this->saveScreenshot($fileName, $filePath);
               print "Screenshot for '{$stepText}' placed in ".$filePath.DIRECTORY_SEPARATOR.$fileName."\n";
          }
      }
    }
}