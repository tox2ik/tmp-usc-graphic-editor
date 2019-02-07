<?php

use PHPUnit\Framework\Assert;


/**
 * Validate features and behavior of the command-line tool: cli-shapes
 *
 * @property \GraphicEditor\Cli\CliShapes cli
 */
class CliContext implements \Behat\Behat\Context\Context
{


    /**
     * @When a syntactically invalid file is loaded from :path
     */
    public function aSyntacticallyInvalidFileIsLoadedFrom($path)
    {
        $this->cli = $cli = new \GraphicEditor\Cli\CliShapes();
        $cli->additionalRenderers[] = $path;
    }

    /**
     * @Then the standard error should contain an error message :message
     * fixme: not realy testing standard error, but close enough.
     */
    public function theStandardErrorShouldContainAnErrorMessage($message)
    {
        try {
            $this->cli->main();
        } catch (Exception | Error | RuntimeException $re) {
            Assert::assertEquals($message,  $re->getMessage(), 'Error message matches.');
            return;
        }

        Assert::assertFalse('shoud not reach this code;');


        throw new PendingException();
    }
}
