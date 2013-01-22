Feature: Admin Site List
    In order to manage multiple sites
    As an admin
    I need to be able to see them

Scenario: List sites
    Given I have a clean database
    And I have a site "dantleech.com"
    And I have a site "barfoo.com"
    And I am on "/admin/global/site/list"
    Then I should see "dantleech.com"
    And I should see "barfoo.com"

Scenario: Click on site dashboard
    Given I have a clean database
    And I have a site "dantleech.com"
    When I click "Dashboard" on the same row as "dantleech.com"
    Then I should be on "/admin/site/dantleech.com/dashboard"
