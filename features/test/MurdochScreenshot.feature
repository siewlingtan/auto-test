Feature: Search in Google
	In order to get the coby the cat pictures
	As a google user
	I need to able to search in google search engine and find the result

	Background:
    	Given I am on "http://murdoch.kaplan.com.sg"
	@insulated
	Scenario Outline: Search in google
			Then I wait for 5 seconds until I see "Sign In" 
			When I fill in <user> for "MainLoginContent_Login"
			And I fill in <password> for "MainLoginContent_Password"
			And I press "MainLoginContent_btnLogin"
			Then I wait for 10 seconds until I see <user>
			Then show me a screenshot
			When I follow "Logout"
			Then I wait for 5 seconds until I see "Enrolment Sign In"
			Examples:
			| user | password |
			| "CT0281701" | "tQTBE1O3" |
			| "CT0281702" | "Z7NjYwfUEQ5" |
			| "CT0281703" | "mK32Auqbqee" |
			| "CT0281704" | "FK7NpBv36vO" |
			| "CT0281705" | "fvekmb6Hziy" |
			| "CT0281706" | "Ki8Kv2dZopO" |
			| "CT0281707" | "SFU9qRKd6xL" |
#			| "CT0281551" | "6BscOtDQ402" |
			| "CT0281554" | "6Vr8HMjP9gR" |
			| "CT0279491" | "Merlinda8" |
			| "CT0281094" | "HRN8W7Cfpy8" |
			| "CT0279212" | "p1ofTP5TQNf" |
			| "CT0281553" | "bNyUJp9y" |
			| "CT0281550" | "Ehm2v9fR" |
			| "CT0281552" | "URg8NbRc" |

