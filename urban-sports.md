# Graphic Editor (Technical test - Urban Sports Club)

## assumptions

- since you need to see tests, I'm going to use PHPUnit and Behat
- everything else will be written from scratch
- you _want_ return types and type hinting everywhere because "use php 7"
- I am under the impression that you want me to show the ability for abstract thought
- thought process and code clarity and legibility are the most important aspect of the test

## Requirements synypsis

1. Draw shapes (__circle__, __square__, rectangle, ellipse) 
    - render aspects: borders, color, ...
2. adding shapes must be easy.
3. serve via __cli__ / web
4. input: [ {type: circle, params: {...} }, ... ]
5. render in any format (__points__, image, etc)
6. Use PHP7

Clarifications:

    "just draft architecture"
    "need to see design patterns"
    "mock out some parts"
    "show how you write tests and documentation"

### Non-functional demands

- USE OOP, patterns
- Tests are mandatory
- Skip shape calculations (mock) 
- upload to GitHub

### implementation plan

- [ ] outline architecture {1: 60m}
- [ ] autoloader {1: 30m} - decided not to.
- [ ] cli-shapes cli {1: 30m}
- [ ] build object graph {1: 40m}
- [ ] ShapeContract {1: 10m}
- [ ] AbstractShape {1: 20m}
- [ ] SquareShape {1: 10m}
- [ ] CircleShape {1: 10m}
- [ ] Render aspects (border, color) {1: 2h}
- [ ] discover shape implmentation {1: 1h}
- [ ] handle errors (ExceptionHandler) {1: 30m}
- [ ] ShapeSaver {1: 30m}
- [ ] JsonShapeSaver: {1: 5m}

#### Initial Estimation

12 hours


    $ math [`grep -oe '{[0-9]:[^}]\+}' urban-sports.md |
        grep -Eoe '[0-9]+(h|m|d)' |
        sed 's/m/*1/; s/h/*60/; s/d/*1440/' |
        tr $"\n" +`0]/60 
    7.583

    $ math 7.6 x 1.5
    11.40



### Use Case 1: Render Shape(s)

    
    chronological flow |  Domain objects                    |  covered
    of execution       |                                    |  requirement 
    -------------------+------------------------------------+-------------
          ,___,        |  logical flow of the program       | 
          |   |        |                                    |
          | e |        |  $ cli-shapes storage/items*.json  |  4.
          | x |        |   -> build object graph            |
          | e |        |   -> parse arguments               |
          | c |        |   -> load renderers                |
          | u |        |   -> load config and shapes        |
          | t |        |   -> delegate ro render()          |
          | i |        +------------------------------------+-------------
          | o |        |   ShapeLoader                      |  2.
          | n |        |     -> read input                  |  4. 
          |   |        |     -> create shape object         |
          | t |        |                                    |
          | i |        +------------------------------------+-------------
          | m |        |   AnyShape                         |
          | e |        |     -> render()                    |   5.
          |   |        |     -> serialize()                 |
          |   |        |     .[ShapeSaver]writer->write()   |
          \   /        |                                    |
           \ /         |                                    |
            `
## Applied patterns

| class            | category             | pattern |
|:-----------------|:--------------------:|:--------|
| CliShapes        | architecture         | Command pattern. receiver: terminal, invoker: shell, concreteCommand: shapes  |
| Autoloader (PS4) |                      | Container (IC/DI)? maybe bad idea to mix responsibilities here... |
| CliShapes        | core domain          | Template pattern. Strategy pattern |
| UnknownShapeEx.  | core domain          |                  |
| ShapeContract    | core domain          |                  |
| ExceptionHandler | supporting subdomain | "logging pattern" |
| ShapeSaver       | supporting subdomain | data transfer pattern? serializable proxy pattern? |
| PngShapeSaver    | supporting subdomain |                  |
| JsonShapeSaver   | supporting subdomain |                  |
| ShapeLoader      | supporting subdomain |                  |


## Domain object

### CliShapes

- load config
- parse arguments
- load shapes (input files)

### Autoloader (PS4)

- load classes

### ExceptionHandler

Handle all exceptions, generate sensible output on standard out.

### ShapeContract

- `render()`
- `serialize()`
- `loadParameters()`

### ShapeSaver

- `write()`

#### PngShapeSaver
#### JsonShapeSaver

### ShapeLoader

- `unserialize()`

### Exceptions

#### UnknownShape

Thrown when the system has no way to render a shape.

#### InvalidArg
