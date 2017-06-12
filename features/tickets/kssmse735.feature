Feature: Delete comments for SFS group 
	In order to test the KSSMSE-735
	As a developer
	I need to able to login as SFS user to see whether I can delete the comments

	Background:
    	Given I am on "http://kss-dev.kaplan.net/KSSMSE-735"
	@javascript @insulated
	Scenario: test KSSMSE-735
		Given I login to KSS
		When I go to "http://kss-dev.kaplan.net/KSSMSE-735/index.php/srbac"
			Then I follow "Add User"
			And I wait for 10 seconds until I see "Manage Users"
			When I fill in "philip.tan" for "User[username]"
			And I manually press "enter"
			And I sleep for "5" seconds
			And I should not see "No results found."
			Then I wait for 10 seconds until I see "952"
			When I follow "Login As"
			Then I should see "Back To Own"
		When I fill in "Contact ID" with "CT0167597"
			And I press "Search"
			And I wait for 10 seconds until I see "Liu Yujia"
			Then I wait for 5 seconds to click the link "360VIEW"
			And I wait for 10 seconds until I see "Liu Yujia - CT0167597"
			When I click on "h3[role='tab'][id='ui-accordion-accordion-header-4']"
			Then I sleep for "5" seconds
			And I wait for 10 seconds until I see "Comments" 
			And I will find css "div#commentsWidget div.items div.comment span" element has attribute "class" should contain the value "deleteicon"
			Then I sleep for "2" seconds