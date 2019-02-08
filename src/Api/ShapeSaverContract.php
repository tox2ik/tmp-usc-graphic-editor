<?php


namespace GraphicEditor\Api;

/**
 *
 * Abstraction for saving shapes to different outputs.
 *
 * For example: png, console (text), X-server, etc
 *
 */
interface ShapeSaverContract
{
    /**
     * Save in storage backend.
     *
     * @throws IoExeption;
     */
    public function write(): void;



}
