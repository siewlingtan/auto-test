Feature: Investigation 
	In order to screenshot Enhanced Session Date
	As a developer
	I need to able to screenshot Enhanced Session Date

	Background:
    	Given I am on "http://kss.kaplan.net/index.php"
	@javascript @insulated
	Scenario: screenshot enhanced session date page
		Given I login to KSS
		And I sleep for 4 seconds
		When I wait and repeat again for enhanced session date page