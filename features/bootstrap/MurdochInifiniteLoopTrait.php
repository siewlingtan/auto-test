<?php
trait MurdochInifiniteLoopTrait
{
    /**
     * @When I wait and repeat again for Murdoch Infinite Loop :user and :password
     */
    public function iWaitAndRepeatAgainForMurdochInfinite($user,$password)
    {
        
            $this->iWaitForSecondsUntilIcanVisitUrl(3, "http://murdoch-dev.kaplan.com.sg");
            $this->iWaitForSecondsUntilISee(3, "Sign In");
            $this->iWaitToFillValueInField(3, 'MainLoginContent_Login', $user);
            $this->iWaitToFillValueInField(3, 'MainLoginContent_Password', $password);
            $this->pressButton('MainLoginContent_btnLogin');
            $this->iWaitForSecondsUntilISee(3, $user);
            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'ICT292-Information Systems Management', 'MainContent_Unit1');
            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'FT MUR T117 ICT292 A', 'MainContent_Class1','MainContent_WClass1');
            
            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'ICT284-Systems Analysis and Design', 'MainContent_Unit2');
            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'FT MUR T117 ICT284 A', 'MainContent_Class2','MainContent_WClass2');

            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'ICT167-Principles of Computer Science', 'MainContent_Unit3');
            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'FT MUR T117 ICT167 C', 'MainContent_Class3','MainContent_WClass3');

            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'BRD251-Wellbeing', 'MainContent_Unit4');
            $this->iWaitForSecondsUntilIcanSelectOptionFromSelect(3, 'FT MUR T117 BRD251 A', 'MainContent_Class4','MainContent_WClass4');

            $this->checkOption('MainContent_Terms');

            $i=1;

            while($i<30)
            {
                $this->pressButton('MainContent_btnSave');
                $this->show_me_a_screenshot($user);
                $i++;
            }

            //$this->show_me_a_screenshot($user);
            $this->visit("http://murdoch-dev.kaplan.com.sg/Login.aspx?Action=Logout");
            $this->iWaitForSecondsUntilISee(5, "Sign in");
        
    }
}