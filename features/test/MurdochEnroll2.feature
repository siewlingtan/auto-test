Feature: Murdoch Enrolment
	In order to enrol
	As a student
	I need to able to enrol class without having an issue

	Background:
    	Given I am on "http://murdoch-dev.kaplan.com.sg"
	@insulated
	Scenario Outline: Enrol
			When I wait and repeat again for Murdoch Infinite Loop <user> and <password>
			Examples:
			| user | password |
			| "CT0283078" | "MTJ23VrWizh" |