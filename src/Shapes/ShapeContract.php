<?php



namespace GraphicEditor\Shapes;


interface ShapeContract
{

    /**
     *
     * Interpret parameters spicific to this shape (from input).
     */
    public function loadParameters(): void;

    /**
     * Actualize this shape, calculate whatever is needed.
     *
     */
    public function render(): void;


    /**
     * Export rendered shape
     */
    public function serialize(): ShapeSaver; // maybe-todo: RenderedShape{getStream(), save()}export as binary?


    public function canRender(string $shapeType): bool ;

}
