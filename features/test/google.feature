Feature: Search in Google
	In order to get the coby the cat pictures
	As a google user
	I need to able to search in google search engine and find the result

	Background:
    	Given I am on "http://google.com/"
	@insulated
	Scenario: Search in google
			Then I should see "Singapore"