Feature: Logins

	To allow access to the admin area
	Admins and authors
	Authentication for users

	Scenario: Registration
		When I register "john" "john@example.com"
		Then I should have an account