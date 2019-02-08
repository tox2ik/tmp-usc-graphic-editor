<?php





namespace GraphicEditor\Shapes\Renderer;


/**
 * Duck type fwt (also a pattern?).
 */
class HelloShape
{

    function render(): void
    {

    }


    function serialize($output)
    {
        $output->out(trim("
+----------------+
|                |- ~ ~ ~ - ,
|                |            ' ,
|                |                ,
|                |                 ,
+----------------+                  ,
        ,                           ,
        ,                           ,
         ,                         ,
          ,                       ,
            ,                  , '
              ' - , _ _ _ ,  '
        "));
    }

}
