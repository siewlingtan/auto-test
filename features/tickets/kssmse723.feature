Feature: Batch Card Collection 
	In order to test the KSSMSE-723
	As a developer
	I need to able to generate the list in Batch Card Collection page

	Background:
    	Given I am on "http://kss-dev.kaplan.net/KSSMSE-723/"
	@javascript @insulated
	Scenario: test KSSMSE-723
		Given I login to KSS
		When I follow "Attendance / Card"
			Then I wait for "5" seconds until I see "Attendance / Card"
			And I follow "Batch Card Collection"
			And I wait for 5 seconds until I see "Search By Intake"
			When I fill in "intakeId" with "PT-MON BEEC-28B (8 Units)"
			And I select "Domestic - PartTime" from "Organisation"
			Then I press "Search"
			Then I wait for 5 seconds until I see "Provisioned"