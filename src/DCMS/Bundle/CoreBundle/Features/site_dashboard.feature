Feature: Site Dashboard
    In order to manage my website
    As an admin
    I need to be able to see what is available

Scenario: View dashboard
    Given I have a clean database
    And I am on the dashboard for site "dantleech.com"
    Then the response status code should be 200
    And I should be on "/admin/site/dantleech.com/dashboard"
    And I should see "dantleech.com" in the "h1" element

Scenario: View Endpoints list
    Given I am on the dashboard for site "dantleech.com"
    Then the response status code should be 200
    When I follow "Endpoints"
    Then I should be on "/admin/site/dantleech.com/endpoint/list"

Scenario: View Menus list
    Given I am on the dashboard for site "dantleech.com"
    Then the response status code should be 200
    When I follow "Menus"
    Then I should be on "/admin/site/dantleech.com/menu/list"

Scenario: View templates list
    Given I am on the dashboard for site "dantleech.com"
    Then the response status code should be 200
    When I follow "Templates"
    Then I should be on "/admin/site/dantleech.com/template/list"

Scenario: View posts list
    Given I am on the dashboard for site "dantleech.com"
    Then the response status code should be 200
    When I follow "Posts"
    Then I should be on "/admin/site/dantleech.com/post/list"
