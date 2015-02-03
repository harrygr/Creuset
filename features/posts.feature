Feature: Posts

  To allow creating and modifying of posts
  Authors

  Scenario: Post Creation
    Given I have an account "john" "john@example.com"
    And I create a post "Example Post" "Example Content"
    When I view the list of posts
    Then I should see a post "Example Post"

  Scenario: Post Editing
    Given I have an account "john" "john@example.com"
    And I have a post "Nice Post" "Some nice content"
    When I edit a post "Edited title"
    And I view the list of posts
    Then I should see a post "Edited title"