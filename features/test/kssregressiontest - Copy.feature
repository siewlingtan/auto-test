Feature: Login
	In order to test the KSS system
	As a developer
	I need to check on all the existing pages with different user accounts

	Background:
    	Given I am on "/"
	@javascript @insulated
	Scenario Outline: test the whole kss system with different access
		When I fill in <user> for "Username"
		And I fill in <password> for "LoginForm_password"
		And I press "Login"
		When I follow "Modules"
			Then I wait for "5" seconds until I see "Module Schedule"
			And I follow "Manage Module Schedule"
			Then I wait for "5" seconds until I see "Manage Module Schedule"
			When I select "Active" from "Status"
			Then I press "Search"
			And I sleep for "2" seconds
			Then I will click the magnifying glass on the row of "12045"
			And I sleep for "2" seconds
			And I wait for "5" seconds until I see "View Module Instance"
			When I fill in "Contact ID" with "CT0206709"
			When I wait for "2" seconds to click the button "Search"
			Then I wait for "5" seconds until I see "Anbazhagan Anand"
			And I sleep for "2" seconds
		When I follow "Lecturers"
			And I wait for "5" seconds until I see "Manage Lecturers"
			Then I select "Full Time" from "Organisation"
			And I press "Search"
			And I wait for "5" seconds until I see "Active"
			And I wait for "6" seconds to click the link "360 View"
			Then I wait for "5" seconds until I see "Personal Details"
		When I follow "Intakes"
			And I wait for "5" seconds until I see "Manage Intake"
			Then I follow "Edit/Update an existing Intake"
			And I wait for "5" seconds until I see "Manage Intakes"
			When I wait for "6" seconds to click the button "Look Up"
			Then I wait for 5 seconds until I see "Fields with * are required."
			And I select "Kaplan Higher Education" from "Partner"
			And I wait for "5" seconds to click the link "Select"
			Then I wait for 3 seconds until I see "[Id]: 1 [program code]: KAP_DIP_PBEP"
			Then I press "Search"
			And I wait for "5" seconds to click the link "View"
			Then I wait for "5" seconds until I see "Diploma in Professional Business English"
		When I follow "Search Student"
			Given I have the list of Contact ID to check in Student 360 View:
				| ctnumber |
				| CT0213054 |
		When I follow "Acad Structure"
			Then I wait for "5" seconds until I see "Academic Structure"
			And I follow "Search & Update Academic Partner"
			Then I wait for "5" seconds until I see "Manage Academic Partners"
			And I select "Singapore" from "Country"
			And I press "Search"
			And I wait for "5" seconds until I see "Displaying 1-"
			But I should not see "No results found."
			And I will find css "a.view > img" element has attribute "alt" should contain the value "View"
		When I follow "Student Applications"
			Then I wait for "5" seconds until I see "Student applications » Manage"
			And I wait for "6" seconds to click the button "Look Up"
			Then I wait for 5 seconds until I see "Fields with * are required."
			When I fill in the following:
				| Contact ID | CT0174144 |
				| Name | Lim Li Keng |
			And I press "Look Up"
			And I wait for "5" seconds to click the link "Select"
			Then I wait for 3 seconds until I see "CT0174144 [Name]: Lim Li Keng"
			And I press "Search"
			And I wait for "5" seconds to click the link "View"
			Then I wait for 7 seconds until I see "View Application"
		When I follow "Contract"
			Then I wait for "5" seconds until I see "Contract » Manage"
			And I wait for "6" seconds to click the button "Look Up"
			Then I wait for 5 seconds until I see "Fields with * are required."
			When I fill in the following:
				| Contact ID | CT0174144 |
				| Name | Lim Li Keng |
			And I press "Look Up"
			And I wait for "5" seconds to click the link "Select"
			Then I wait for 3 seconds until I see "CT0174144 [Name]: Lim Li Keng"
			And I press "Search"
			And I wait for "5" seconds to click the link "View Application"
			Then I wait for 7 seconds until I see "View Application"
		Examples:
		| user | password |
		| "Please Enter UserName" | "Please Enter Password" |