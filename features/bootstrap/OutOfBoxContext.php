<?php

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use GraphicEditor\Cli\CliShapes;
use GraphicEditor\Shapes\Renderer\HelloShape;
use PHPUnit\Framework\Assert;


/**
 * The features and default behavior of version 1 are described by this context.
 *
 * @property CliShapes cli
 * @property bool|resource out
 * @property bool|resource err
 * @property bool|string tmp
 */
class OutOfBoxContext implements \Behat\Behat\Context\Context
{

    /**
     * @BeforeScenario
     */
    public function before(BeforeScenarioScope $scope)
    {
        $this->out = fopen('php://memory', 'rw');
        $this->err = fopen('php://memory', 'rw');
        $this->cli = CliShapes::createFromShell();
        $this->cli->output = new \GraphicEditor\Cli\Output($this->out, $this->err);
        $this->cli->output->_z = 'jwf';
    }


    /**
     * @When i run the command without arguments
     */
    public function IRunTheCommandWithoutArguments()
    {
        $this->cli->main();
    }

    public function readOutput()
    {
        $fstat = fstat($this->out);
        rewind($this->out);

        $text = null;
        if ($fstat['size']) {
            $text = fread($this->out, $fstat['size']);
            fseek($this->out, $fstat['size']);
        }
        return $text;
    }

    /**
     * @Then The application should produce the hello circle and hello square
     */
    public function theApplicationShouldProduceTheHelloCircleAndHelloSquare(PyStringNode $string)
    {
        $expected = $string->getStrings();
        $output = explode("\n", '' . $this->readOutput());
        Assert::assertEquals(1, count($this->cli->shapes), 'Should print HelloShapes');
        Assert::assertEquals($expected, $output, 'Hello circle+square');
    }

    /**
     * @Given that the system can create and read files
     */
    public function thatTheSystemCanCreateAndReadFiles()
    {
        $this->tmp = tempnam(sys_get_temp_dir(), 'fff');
        Assert::assertTrue(is_file($this->tmp));
    }

    /**
     * @When I run the command on file :file
     */
    public function iRunTheCommandOnFile($file, PyStringNode $content)
    {
        $content = implode('', $content->getStrings());
        $inputFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR .  $file;
        Assert::assertTrue(rename($this->tmp, $inputFile));
        file_put_contents($inputFile, $content);
        $this->cli->main([$inputFile ]);

    }


    /**
     * @Then the outupt should contain
     */
    public function theOutuptShouldContain(PyStringNode $string)
    {
        $expected = $string->getStrings();
        $output = explode("\n", '' . $this->readOutput());

        foreach ($this->cli->shapes as $e) {
            Assert::assertInstanceOf(\GraphicEditor\Shapes\ShapeContract::class, $e);
        }

        Assert::assertEquals(2, count($this->cli->shapes), 'We created a circle renderer and a square renderer');
        Assert::assertEquals($expected, $output, 'we have ()[]');
    }
}
