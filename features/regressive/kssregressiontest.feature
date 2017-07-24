Feature: Login
	In order to test the KSS system
	As a developer
	I need to check on all the existing pages with different user accounts

	Background:
    	Given I am on "/"
	@javascript @insulated
	Scenario: test the whole kss system with different access
		Given I login to KSS
		When I am on "/index.php/intake/4299"
			Then I wait for 25 seconds until I see "View Intake #4299"
			And I have letter of verification "pdf" download for "CT0273447"
			Then I should see response status code "200"
			Then I should see in the header "content-description":"File Transfer"
			Then I should see in the header "content-type":"application/octet-stream"
			Then I should see the file size is more than "80000"
			Then the file "LoV-CT0273447.pdf" should be downloaded
			And I have letter of verification "document" download for "CT0273447"
			Then I should see response status code "200"
			Then I should see in the header "content-description":"File Transfer"
			Then I should see in the header "content-type":"application/vnd.openxmlformats-officedocument.wordprocessingml.document"
			Then I should see the file size is more than "70000"
			Then the file "_KSS_new__temp_LoV-CT0273447.docx" should be downloaded
		When I wait for 5 seconds to click the link "Search Student"
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
			Then on the row 18, I click the magnifying glass and wait for 10 seconds and class is view
			Then I wait for "5" seconds until I see "View Academic Partner #18"
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
			And I wait for "60" seconds to click the link "View Application"
			Then I wait for 7 seconds until I see "View Application"
		When I follow "Lecturers"
			And I wait for "5" seconds until I see "Manage Lecturers"
			Then I select "Full Time" from "Organisation"
			And I press "Search"
			And I wait for "10" seconds until I see "Active"
			And I wait for "6" seconds to click the link "360 View"
			Then I wait for "6" seconds until I see "Personal Details"
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
			And On the row 200, I click the magnifying glass and wait for 10 seconds and title is View and class is view
			Then I wait for "5" seconds until I see "Diploma in Professional Business English"
		When I follow "Modules"
			Then I wait for "5" seconds until I see "Module Schedule"
			And I follow "Manage Module Schedule"
			Then I wait for "5" seconds until I see "Manage Module Schedule"
			When I select "Active" from "Status"
			Then I press "Search"
			And I wait for "15" seconds until I see "478"
			Then I wait until 10 seconds to click the magnifying glass on the row "478" (title="View" class="view")
			And I sleep for "2" seconds
			And I wait for "5" seconds until I see "View Module Instance"
			When I fill in "Contact ID" with "CT0101583"
			When I wait for "2" seconds to click the button "Search"
			Then I wait for "5" seconds until I see "Ang Wai Jian Lionel"
			And I sleep for "2" seconds
		When I follow "Materials"
			Then I wait for "5" seconds until I see "Manage Material"
			And I follow "Manage Material"
			Then I wait for "5" seconds until I see "Manage Material"
			When I fill in "Title" with "Accounting"
			Then I press "Search"
			And I wait for "5" seconds until I see "results"
			Then I wait until 10 seconds to click the magnifying glass on the row "602" (title="View" class="view")
			Then I wait for "5" seconds until I see "View Material"
		When I follow "Upload Center"
			Then I wait for "10" seconds until I see "Attendances Upload"
			And I visit all the upload links under the Upload center:
				| Upload | Header |
				| Attendances Upload | Upload Absentee Dates |
				| Enrollments Upload | Upload students |
				| Result Upload | Upload Grades |
				| Student Record Upload | Upload students |
				| Student Images Upload | Upload images |
				| Absentee Batch Upload Upload | Dashboard |
				| Classes Session dates Upload | Upload Session Dates |
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
			And I wait for "30" seconds to click the link "View"
			Then I wait for 7 seconds until I see "View Application"
		When I follow "Self Services"
			Then I should see the following:
				| Menu |
				| Notification |
				| LOV |
				| Student Onboarding |
				| Leave Application |