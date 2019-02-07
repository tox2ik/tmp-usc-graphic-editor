<?php


namespace GraphicEditor\Io;

use GraphicEditor\Api\IoExeption;
use GraphicEditor\Api\ShapeSaverContract;
use GraphicEditor\Errors\NotImplementedException;

class ShapeSaver implements ShapeSaverContract
{

    /**
     * @inheritdoc
     */
    public function write(): void
    {
        throw new NotImplementedException(__METHOD__);
    }
}



