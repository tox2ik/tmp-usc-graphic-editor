Feature: Showcase default features
  The application should demonstrate default behavior when invoked wihout arguments
  As the end-user
  I want to get a general feel of what this application is capable of when it is run without arguments


  Scenario: cli-shapes is invoked without arguments
    When I run the command without arguments
    Then The application should produce the hello circle and hello square
    """
    +----------------+
    |                |- ~ ~ ~ - ,
    |                |            ' ,
    |                |                ,
    |                |                 ,
    +----------------+                  ,
            ,                           ,
            ,                           ,
             ,                         ,
              ,                       ,
                ,                  , '
                  ' - , _ _ _ ,  '
    """

  Scenario: cli-shapes renders a circle and a square
    Given that the system can create and read files
    When I run the command on file "circle-square.json"
    """
    [
      { "type" : "circle", "params"  : [] },
      { "type" : "square", "params"  : [] }
    ]
    """
    Then the outupt should contain
    """
    ()[]
    """



