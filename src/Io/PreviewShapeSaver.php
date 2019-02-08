<?php


namespace GraphicEditor\Io;


use GraphicEditor\Api\IoExeption;
use GraphicEditor\Api\ShapeSaverContract;
use GraphicEditor\Cli\Output;
use GraphicEditor\Shapes\ShapeContract;

/**
 * @property ShapeContract shape
 * @property Output output
 */
class PreviewSaver implements ShapeSaverContract
{



    public function __construct(ShapeContract $shape, Output $output)
    {
        $this->shape = $shape;
        $this->output = $output;
    }

    /** @inheritdoc */
    public function write(): void
    {
        
        $this->shape->serialize($this->output);

        
        
    }
}

