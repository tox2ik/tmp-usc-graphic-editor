Feature: Does not choke on garbage shape implementation from third parties
  We need to outsource implementation of shapes to third parties
  The Cli interpreter
  Should not exit with a fatal error, but skip invalid implementations of shapes


  Scenario: Syntax error in shape renderer
    When a syntactically invalid file is loaded from "test/fixture/parse-error.php"
    Then the standard error should contain an error message "Skipping invalid shape-renderer: test/fixture/parse-error.php"

