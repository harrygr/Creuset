Feature: Posts

  To allow creating and modifying of posts
  Authors

  Scenario: Post Creation
    Given I have an account "john" "john@example.com"
    When I create a post "Example Post" "Example Content"
    Then I should see a post "Example Post"
