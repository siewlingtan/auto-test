Feature: Access Notification Module
	In order to access Notification module
	As a Program Maager
	I need to login to KSS and go to Self-Service menu

	Scenario: Access Notification Module
		Given I navigate to "KSS"
		And I input my "username"
		And I input my "password"
		And I click on "Login"
		When I click on "menu"
		Then I should be able to see "module"