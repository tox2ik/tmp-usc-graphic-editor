<?php


namespace GraphicEditor\Cli;


use GraphicEditor\Errors\NotImplementedException;
use GraphicEditor\Io\File;
use Symfony\Component\DependencyInjection\Compiler\RemoveUnusedDefinitionsPass;

/**
 * A set of writable streams
 */
class Output
{

    /** @var bool|resource  */
    public $out;

    /** @var bool|resource  */
    public $err;

    /**
     * Output constructor.
     *
     * @param null|resource $out
     * @param null|resource $err
     */
    public function __construct($out = null, $err = null)
    {
        $this->out = $out ?: fopen('php://stdout', 'w');
        $this->err = $err ?: fopen('php://stderr', 'w');
    }

    public function out($text): void
    {
        fwrite($this->out, $text);
    }

    public function err($text): void
    {
        fwrite($this->err, $text);

    }




}