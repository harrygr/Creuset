Feature: Authentication

	To allow access to the admin area
	Admins and authors
	Authentication for users

	Scenario: Registration
		When I register "john" "john@example.com"
		Then I should have an account

	Scenario: Login
	  	Given I have an account "john" "john@example.com"
	  	Given I am logged out
	  	When I log in
	  	Then I should be logged in

	Scenario: Failed Login
	  	When I log in with invalid credentials
	  	Then I should not be logged in

	Scenario: Failed registration due to invalid email
	  	When I register "john" "myemail"
	    Then I should not have an account

  	Scenario: Failed registration due to unmatched passwords
		When I register with unmatched passwords "john" "john@example2.com"
		Then I should not have an account