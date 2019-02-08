<?php


namespace GraphicEditor\Shapes\Renderer;


use GraphicEditor\Api\ShapeSaverContract;
use GraphicEditor\Cli\Output;
use GraphicEditor\Shapes\ShapeContract;

class CircleShape implements ShapeContract
{
    public $parameters = [];
    public $body;



    /** @inheritdoc */
    public function render(): void
    {
        $this->body = '()';
    }

    /** @inheritdoc */
    public function serialize(Output $output): void
    {
        $output->out($this->body);
    }

    /** @inheritdoc */
    public function canRender(string $shapeType): bool
    {
        return strtolower($shapeType) == 'circle';
    }


    /** @inheritdoc */
    public function loadParameters(array $shapeParams): void
    {
        $this->parameters = $shapeParams;
    }

    #/** @inheritdoc */
    #public function createFromParams(array $shapeParams): ShapeContract
    #{
    #    // TODO: Implement createFromParams() method.
    #}
}