<?php





/**
 * We need to detect when there are no concrete implementation of shape types from input.
 */
class DetectsUnknownTypesTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Unknown type: kake
     */
    public function testUnknownKakeShape()
    {
        $cli = new \GraphicEditor\Cli\CliShapes();
        $cli->shapeParameters[] = [ 'type' => 'kake', ];
        $cli->main();
    }
}
