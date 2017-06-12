Feature: Delete comments for SFS group 
	In order to test the KSSMSE-735
	As a developer
	I need to able to login as SFS user to see whether I can delete the comments

	Background:
    	Given I am on "http://kss-dev.kaplan.net/KSSMSE-663"
	@javascript @insulated
	Scenario: test KSSMSE-735
		Given I login to KSS
		When I follow "Intakes"
			And I wait for 5 seconds to click the link "Edit/Update an existing Intake"
			And I wait for 10 seconds until I see "Manage Intakes"
			When I fill in "FT-UOE EIP-2A" for "Intake Code"
			And I press "Search"
			Then I wait for 10 seconds until I see "2998"
			But I should not see "No results found."
			And I wait until 5 seconds to click the magnifying glass on the row 2998 (title=View class=view)
			Then I wait for 5 seconds to click the link "Navision Package and Sitting"
			And I switch to new tab
			Then the response status code should not be 500
			And I wait for 10 seconds until I see "Intake Navision Package and Sitting per student type"
			When I select "07" from "sitting_DP"
				And I select "RHUL-BSEIPPACKAGE" from "package_DP"
				And I press "yt0"
				Then I sleep for 2 seconds
				Then I will find css "#savedResult_DP table.items tbody a" element has attribute "class" should contain the value "delete"
				Then I sleep for 2 seconds
			When I select "07" from "sitting_FT"
				And I select "RHUL-BSEIPPACKAGE" from "package_FT"
				And I press "yt1"
				Then I sleep for 2 seconds
				Then I will find css "#savedResult_FT table.items tbody a" element has attribute "class" should contain the value "delete"
				Then I sleep for 2 seconds
			When I select "07" from "sitting_I"
				And I select "RHUL-BSEIPPACKAGE" from "package_I"
				And I press "yt1"
				Then I sleep for 2 seconds
				Then I will find css "#savedResult_I table.items tbody a" element has attribute "class" should contain the value "delete"
				Then I sleep for 2 seconds
			When I select "07" from "sitting_O"
				And I select "RHUL-BSEIPPACKAGE" from "package_O"
				And I press "yt1"
				Then I sleep for 2 seconds
				Then I will find css "#savedResult_O table.items tbody a" element has attribute "class" should contain the value "delete"
				Then I sleep for 2 seconds