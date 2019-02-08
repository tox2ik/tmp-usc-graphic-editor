<?php


namespace GraphicEditor\Cli;


use GraphicEditor\Errors\NotImplementedException;
use GraphicEditor\Io\File;
use Symfony\Component\DependencyInjection\Compiler\RemoveUnusedDefinitionsPass;

/**
 *
 * (theoretically) Parse arguments such as
 *
 *     -a
 *     -qin [-q -i -n]
 *     -i./input.txt
 *     --except
 *     list
 *     help
 *
 *
 * NOTE: this file is a giant wrapper around GLOBALS['argv'].
 * Nowdays, I prefer to avoid useless code. Especially when someone else already has a functional
 * and generic-enough implementation to do the same thing.
 * e.g. https://symfony.com/doc/current/components/console.html
 *
 *
 *
 */
class Input
{

    public $arguments = [];

    public static function createFromArgv($params = []): Input
    {
        $instance = new static();

        global $argv;
        $input = $params ?: $argv;
        foreach ($input as $i => $e) {
            $instance->parse($i, $e);
            true;
        }
        return $instance;
    }

    protected function parse($argNum, $argValue): void
    {
        $this->arguments[$argNum] = $argValue;
    }


    protected function getArgs() : array
    {
        return [];
    }

    protected function getLongs() : array
    {
        return [];
    }

    protected function getSubCommands() : array
    {
        return [];
    }


    /**
     * @return File
     */
    public function itemizeFiles(): array
    {
        return array_filter(array_values($this->arguments), 'is_file');
    }


}