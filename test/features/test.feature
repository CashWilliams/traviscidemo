Feature: Site installation

  Scenario: Installation succeeded
    Given I am on the homepage
    Then the response status code should be 200
