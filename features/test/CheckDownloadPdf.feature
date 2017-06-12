Feature: Search in Google
	In order to get the coby the cat pictures
	As a google user
	I need to able to search in google search engine and find the result

	Background:
    	Given I am on "http://localhost:8081/KSS/current/"
	@javascript @insulated
	Scenario: Search in google
			When I login to KSS
			Then I am on "http://localhost:8081/KSS/current/index.php/intake/4299"
			Then I wait for 25 seconds until I see "View Intake #4299"
			And I have letter of verification "pdf" download for "CT0273447"
			Then I should see response status code "200"
			Then I should see in the header "content-description":"File Transfer"
			Then I should see in the header "content-type":"application/octet-stream"
			Then I should see the file size is more than "100000"
			Then the file "LoV-CT0273447.pdf" should be downloaded
			And I have letter of verification "document" download for "CT0273447"
			Then I should see response status code "200"
			Then I should see in the header "content-description":"File Transfer"
			Then I should see in the header "content-type":"application/vnd.openxmlformats-officedocument.wordprocessingml.document"
			Then I should see the file size is more than "70000"
			Then the file "_KSS_new__temp_LoV-CT0273447.docx" should be downloaded

#			And I try to have letter of verification "pdf" download for "CT0273447"
#			Then I should see response status code "200"
#			Then I should see in the header "content-description":"File Transfer"
#			Then I should see in the header "content-type":"application/octet-stream"
#			Then I should see the file size is more than "100000"
#			And I try to have letter of verification "document" download for "CT0273447"
#			Then I should see response status code "200"
#			Then I should see in the header "content-description":"File Transfer"
#			Then I should see in the header "content-type":"application/vnd.openxmlformats-officedocument.wordprocessingml.document"
#			Then I should see the file size is more than "240000"

#			Then I am on "http://kss-dev.kaplan.net/KSSMSE-723/index.php/intake/4299"
#			Then I wait for 25 seconds until I see "View Intake #4299"
#			When I click on "CT0273447" letter of verification "document" download