<?php
trait CheckDownloadPdfTrait
{
    /**
    * @Then I have letter of verification :download download for :CTnumber
    */
    public function haveLetterOfVerification($CTnumber,$download)
    {
        $file = array("pdf"=>"letterOfVerificationPDF","document"=>"letterOfVerification/");
        if(array_key_exists($download,$file))
        {
            $lov = $this->findAll('css', "a[href*='".$file[$download]."'][href*='".$CTnumber."'][title='Letter of Verification']");
            if (null === $lov || empty($lov))
            {
                throw new \Exception(sprintf("Did not see %s download for %s.", $download, $CTnumber));
            }

            $count = count($lov);
            if($count > 1)
            {
                throw new \Exception('More than one record to click. Please check.');
            }

            $url = $lov[0]->getAttribute('href');
            echo $url."\n";
        }
        else
        {
            throw new \Exception(sprintf("There is no %s download for Letter Of Verification.", $download));
        }

            $cookies = $this->getSession()->getDriver()->getWebDriverSession()->getCookie();

            foreach($cookies as $PHPSESSID)
            {
                if(strcasecmp($PHPSESSID['name'],'PHPSESSID') == 0)
                {
                    $cookies = $PHPSESSID;
                    break;
                }
            }

            if(empty($cookies))
            {
                throw new \Exception('Php Session ID should not be empty to download for Letter Of Verification. Please run the test again.');
            }

            $cookie = new \Guzzle\Plugin\Cookie\Cookie();
            
            $cookie->setName($cookies['name']);
            $cookie->setValue($cookies['value']);
            $cookie->setDomain($cookies['domain']);

            $jar = new \Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar();
            $jar->add($cookie);

            $client = new \Guzzle\Http\Client($this->getSession()->getCurrentUrl());
            $client->addSubscriber(new \Guzzle\Plugin\Cookie\CookiePlugin($jar));

            if($download == 'pdf')
            {
                $fileName = $this->getMinkParameter('files_path').DIRECTORY_SEPARATOR.'LoV-'.$CTnumber.'.pdf';
            }
            else
            {
                $fileName = $this->getMinkParameter('files_path').DIRECTORY_SEPARATOR.'_KSS_new__temp_LoV-'.$CTnumber.'.docx';
            }
            echo "LoV File: \n".$fileName."\n";
            $body = fopen($fileName, 'w');
            $this->response = $client->get($url)
                              ->setResponseBody($body)
                              ->send();
    }

    /**
     * @Then the file :filename should be downloaded
     */
    public function assertFileDownloaded($filename) 
    {
        $path = $this->getMinkParameter('files_path').DIRECTORY_SEPARATOR;
        if (!file_exists($path.$filename)) {
            throw new Exception(sprintf("No %s under ".$path, $filename));
        }
    }


   /**
    * @Then I try to have letter of verification :download download for :CTnumber
    */
    public function iTryToDownload($CTnumber,$download)
    {
        $file = array("pdf"=>"letterOfVerificationPDF","document"=>"letterOfVerification/");
        if(array_key_exists($download,$file))
        {
            $lov = $this->findAll('css', "a[href*='".$file[$download]."'][href*='".$CTnumber."'][title='Letter of Verification']");
            if (null === $lov || empty($lov))
            {
                throw new \Exception(sprintf("Did not see %s download for %s.", $download, $CTnumber));
            }

            $count = count($lov);
            if($count > 1)
            {
                throw new \Exception('More than one record to click. Please check.');
            }

            $url = $lov[0]->getAttribute('href');
            echo $url."\n";
        }
        else
        {
            throw new \Exception(sprintf("There is no %s download for Letter Of Verification.", $download));
        }


            $cookies = $this->getSession()->getDriver()->getWebDriverSession()->getCookie('PHPSESSID');

            $cookie = new \Guzzle\Plugin\Cookie\Cookie();
            $cookie->setName($cookies['name']);
            $cookie->setValue($cookies['value']);
            $cookie->setDomain($cookies['domain']);

            $jar = new \Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar();
            $jar->add($cookie);

            $client = new \Guzzle\Http\Client($this->getSession()->getCurrentUrl());
            $client->addSubscriber(new \Guzzle\Plugin\Cookie\CookiePlugin($jar));

            $request = $client->get($url);
            
            $this->response = $request->send();


/*            $headers = $this->response->getHeaders();

            echo "getStatusCode\n";var_dump($this->response->getStatusCode()); echo "\n";
            //echo "getHeaders\n";var_dump($headers); echo "\n\n";
            echo "content-type\n";echo ($headers->get("content-type")); echo "\n";
            echo "content-disposition\n";echo ($headers->get("content-disposition")); echo "\n";
            echo "content-length\n";echo ($headers->get("content-length")); echo "\n";
*/            
    }

    /**
    * @Then /^I should see response status code "([^"]*)"$/
    */
    public function iShouldSeeResponseStatusCode($statusCode)
    {
        $responseStatusCode = $this->response->getStatusCode();

        if (!$responseStatusCode == intval($statusCode)) {
            throw new \Exception(sprintf("Did not see response status code %s, but %s.", $statusCode, $responseStatusCode));
        }
    }

    /**
    * @Then /^I should see in the header "([^"]*)":"([^"]*)"$/
    */
    public function iShouldSeeInTheHeader($header, $value)
    {
        $headers = $this->response->getHeaders();
        if ($headers->get($header) != $value) {
            echo $header." from server: ".$headers->get($header)."\n";
            echo $header." requested: ".$value."\n";
            throw new \Exception(sprintf("Did not see %s with value %s.", $header, $value));
        }
    }

    /**
    * @Then /^I should see the file size is more than "([^"]*)"$/
    */
    public function iShouldSeeFileSizeIsMoreThan($value,$header='content-length')
    {
        $headers = $this->response->getHeaders();
        if ($headers->get($header) < $value) {
            echo "File size from server: ".$headers->get($header)."\n";
            echo "Requested file size: ".$value."\n";
            throw new \Exception(sprintf("File size is less than the value %s.",$value));
        }
    }
}
?>