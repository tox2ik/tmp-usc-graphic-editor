<?php


namespace GraphicEditor\Cli;



use Behat\Behat\Output\Node\EventListener\Statistics\StatisticsListener;
use GraphicEditor\Errors\IllegalArgumentException;
use GraphicEditor\Errors\UnknownShapeException;
use GraphicEditor\Shapes\Renderer\HelloShape;
use GraphicEditor\Shapes\ShapeContract;

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

    /** @var string[] */
    public $shapeFiles = [];

    /** @var array[][]  */
    public $shapeParameters = [];

    /** @var string[] */
    public $additionalRenderers = []; // public array?!?!11 - whatever, we are not publishing this code.

    /**
     * @var ShapeContract[]
     */
    public $shapes = [];

    /** @var ShapeContract[] */
    public $shapeRenderers = [];

    /** @var Output */
    public $output;

    public static function createFromShell()
    {
        $cs = new static;
        $cs->output = new Output();
        return $cs;


    }

    public function main($argv = []): void
    {

        $input = Input::createFromArgv($argv);
        $this->interpretArguments($input);
        $this->loadConfiguration();
        $this->loadShapesInput();

        $this->loadRenderers();
        $this->matchRenderersWithInput();
        $this->configureOutput();
        $this->render();
        $this->saveRenderedShapes();

    }


    /**
     * initialize the object container (service locator)
     *
     */
    private function buildDeps(): void
    {

    }

    /**
     * derive meaning from the flags and long options on the command line.
     */
    private function interpretArguments(Input $input)
    {
        $this->shapeFiles = $input->itemizeFiles();


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
        $dd = glob(__DIR__ . '/../Shapes/*');
        $vanillaRendrerPaths = glob(__DIR__ . '/../Shapes/Renderer/*');
        $rendererPaths = array_merge($vanillaRendrerPaths, $this->additionalRenderers);

        // fixme: move to a factory (with the file-path-loop).
        foreach ($rendererPaths as $phpFilePath) {
            $className = basename($phpFilePath, '.php');
            $classFqn = "\\GraphicEditor\\Shapes\\Renderer\\$className";
            if (! class_exists($classFqn)) {
                try {
                    require $phpFilePath;
                } catch (\ParseError $parseError) {
                    // maybe-todo: logger
                    throw new IllegalArgumentException(
                        "Skipping invalid shape-renderer: {$phpFilePath}",
                        77,
                        $parseError
                    );
                }
            }
            // fixme: making assumptions about the ShapeContract's constructor (no arguments) is not perfect.

            $renderer = null;
            try {
                $renderer = new $classFqn;
            } catch (\Throwable $e) {
                throw new IllegalArgumentException("Failed to create a renderer): {$phpFilePath}");
            }

            if ($renderer instanceof ShapeContract) {
                $this->shapeRenderers[] = $renderer;
            }
        }
        //throw new NotImplementedException('todo');
    }


    /**
     * Just parse the json input.
     */
    public function loadShapesInput(): void
    {
        foreach ($this->shapeFiles as $file) {
            $errors = [];
            $json = file_get_contents($file);
            $input = json_decode($json, true);
            if (!empty($json) && $input === null && json_last_error() != JSON_ERROR_NONE) {
                error_log(sprintf( '%s: Error while decoding; %s', __FUNCTION__, json_last_error_msg())); // todo: logger
                $errors[] = json_last_error_msg();
            }

            if (is_array($input)) {
                $this->shapeParameters = array_merge($this->shapeParameters, $input);


                    //$input;
            } else {
                $this->shapeParameters[] = $input;

            }


        }
    }


    private function matchRenderersWithInput()
    {
        /** @var ShapeContract $renderer */
        $processShapes = array_merge([], $this->shapeParameters);

        $badShapes = [];
        $unknownShapes = [];

        while (count($processShapes)) {
            $shape = array_shift($processShapes);


            foreach ($this->shapeRenderers as $renderer) {
                try {
                    $this->isShapeParamsValid($shape);
                } catch (\RuntimeException $re) {
                    // $this->output->err('bad shape input: ');
                    if ($shape) {
                        $badShapes[] = $shape;
                    }
                    break;

                }

                // fixme: a shape may be supported by several renderers, but we may not
                // want to render the same input several times.


                if ($renderer->canRender($shape['type'])) {
                    $renderer->loadParameters($shape);
                    $this->shapes[] = $renderer;
                    $shape = null;
                    break;
                }
            }
            if ($shape) {
                $unknownShapes[] = $shape;
            }
        }
        foreach ($unknownShapes as $unknownShape) {
            throw new UnknownShapeException("Unknown type: {$unknownShape['type']}");
        }

        $isSpecialCaseNoInput = empty($processShapes) && empty($unknownShapes) && empty($badShapes);


        if (empty($this->shapes) && $isSpecialCaseNoInput) {
            $this->shapes[] = new HelloShape;
        }
    }

    /**
     * fixme: this logic belongs somewhere else.
    */
    private function isShapeParamsValid($shape): bool
    {
        if (isset($shape['type'])) {
            return true;
        }
        throw new \RuntimeException('The input for a shape has no type');
    }


    /**
     * there is no configuration in version 1.
     */
    public function loadConfiguration(): void
    {
    }

    private function render()
    {
        foreach ($this->shapes as $shape) {
            $shape->render();

        }
    }

    /**
     * Nothing here atm. maybe configure or check output in the future.
     */
    private function configureOutput()
    {
    }

    private function saveRenderedShapes()
    {
        $canvas = new \GraphicEditor\Io\ConsoleCanvas($this->shapes);
        $canvas->generatePreview($this->output);
    }


}

