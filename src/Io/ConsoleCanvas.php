<?php


namespace GraphicEditor\Io;


use GraphicEditor\Api\IoExeption;
use GraphicEditor\Api\ShapeSaverContract;
use GraphicEditor\Cli\Output;
use GraphicEditor\Shapes\ShapeContract;
use test\Mockery\HasUnknownClassAsTypeHintOnMethod;

/**
 * The (conceptual) page where all the shapes are rendered.
 *
 */
class ConsoleCanvas
{

    public function __construct(array $shapes)
    {
        /** @var ShapeContract[] shapes */
        $this->shapes = $shapes;

    }

    public function export($output)
    {
        //$output = '';
        //$output .=
        foreach ($this->shapes as $shape) {
            $shape->serialize($output);

        }

        return $output;
        // TODO: Implement write() method.
    }

    public function generatePreview(Output $output)
    {
        return $this->export($output);

    }
}