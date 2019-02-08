<?php



namespace GraphicEditor\Shapes;



use GraphicEditor\Api\ShapeSaverContract;
use GraphicEditor\Cli\Output;


/**
 *
 * NOTE: this interface violates single responsibility precept: load != render != factory
 */
interface ShapeContract
{

    /**
     *
     * Interpret parameters specific to this shape (from input).
     *
     * @param array $shapeParams
     */
    public function loadParameters(array $shapeParams): void;


    /**
     * Actualize this shape, calculate whatever is needed.
     *
     */
    public function render(): void;

    /**
     * Export rendered shape
     *
     * @param Output $output
     *
     * @return ShapeSaverContract
     */
    public function serialize(Output $output): void; // ShapeSaverContract; // maybe-todo: RenderedShape{getStream(), save()}export as binary?


    public function canRender(string $shapeType): bool ;

    # /**
    #  * Interpret params for supported type.
    #  *
    #  * @param array $shapeParams
    #  *
    #  * @return ShapeContract
    #  */
    # public function createFromParams(array $shapeParams): ShapeContract;

}
