<?php


namespace GraphicEditor\Api;

interface ShapeSaverContract
{
    /**
     * Save in storage backend.
     *
     * @throws IoExeption;
     */
    public function write(): void;


}
