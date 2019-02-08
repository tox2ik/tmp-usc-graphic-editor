<?php


namespace GraphicEditor\Io;

use GraphicEditor\Api\ShapeSaverContract;
use GraphicEditor\Cli\Output;
use GraphicEditor\Errors\NotImplementedException;

/**
 * Display a shape as ascii on the console.
 */
class ConsoleShape implements ShapeSaverContract
{

    /**
     * @inheritdoc
     */
    public function write(): void
    {
        throw new NotImplementedException(__METHOD__);
    }


    public function __toString() {
        return 'kake';
    }

}



