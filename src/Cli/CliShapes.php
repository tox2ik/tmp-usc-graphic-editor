<?php


namespace GraphicEditor\Cli;



use GraphicEditor\Errors\IllegalArgumentException;
use GraphicEditor\Errors\NotImplementedException;
use GraphicEditor\Shapes\ShapeContract;
use phpDocumentor\Reflection\Types\Array_;
use PHPUnit\Util\RegularExpression;

/**
 *
 * 1. bootstrap the app
 * 2. load input
 * 3. render shapes
 * 4. collect and write output
 *
 */
class CliShapes
{

    public $shapeFiles = [];
    public $shapeParameters = [];
    public $additionalRenderers = []; // public array?!?!11 - whatever, we are not publishing this code.

    /**
     * @var ShapeContract[]
     */
    public $shapeRenderers = [];

    public function main($argv = []): void
    {
        $this->interpretArguments(CliInput::createFromArgv($argv));
        $this->loadConfiguration();
        $this->loadShapes();
        $this->loadRenderers();
        //throw new NotImplementedException('todo');
    }


    private function buildDeps(): void
    {

    }

    private function interpretArguments(CliInput $input)
    {
        $this->shapeFiles = $input->itemizeFiles();
        // whatever.
    }




    /**
     *
     * traverse some folder, load classes of type ShapeContract
     *
     * todo: support loading custom renderers; --shape-renderers=/paht/to/renderer-implementations
     *
     */
    public function loadRenderers(): void
    {
        $vanillaRendrerPaths = glob(__DIR__ . '/../Shapes/Renderer*');

        $rendererPaths = array_merge($vanillaRendrerPaths, $this->additionalRenderers);

        foreach ($rendererPaths as $phpFilePath) {
            $className = basename($phpFilePath, '.php');
            $classFqn = "\\GraphicEditor\\Shapes\\Renderer\\$className";
            if (! class_exists($classFqn)) {
                try {
                    require $phpFilePath;
                } catch (\ParseError $parseError) {
                    throw new IllegalArgumentException(
                        "Skipping invalid shape-renderer: {$phpFilePath}",
                        77,
                        $parseError
                    );
                }
            }
            $this->shapeRenderers = new $classFqn; // fixme: move to a factory (with the file-path-loop).
        }

        throw new NotImplementedException('todo');




    }


    /**
     *
     * Just parse the json input.
     */
    public function loadShapes(): void
    {
        foreach ($this->shapeFiles as $file) {
            $errors = [];
            $input = json_decode($file, $errors);
            if (!empty($json) && $input === null && json_last_error() != JSON_ERROR_NONE) {
                error_log(sprintf( '%s: Error while decoding; %s', __FUNCTION__, json_last_error_msg())); // todo: logger
                $errors[] = json_last_error_msg();
            } else {
                $this->shapeParameters[] = $input;
            }
        }
    }


    /**
     * there is no configuration in version 1.
     */
    public function loadConfiguration(): void
    {
    }


}

