<?php


namespace GraphicEditor\Io;


use Symfony\Component\DependencyInjection\Compiler\RemoveUnusedDefinitionsPass;

/**
 * @property-read string path where is the file?
 */
class File
{

    public $path;

    /**
     *
     * @return null|string null on error, string if readable.
     */
    public function slurp(): ?string
    {
        if (is_readable($this->path)) {
            if (false === ($file = file_get_contents($this->path))) {
                return null;
            }
            return $file;
        }
    }
}

