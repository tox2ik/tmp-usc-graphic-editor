<?php

namespace GraphicEditor\Errors;

/**
 * Some parameter (from user) was detected to be bad at run time.
 *
 * borrows semantics from Java;
 *
 *     public class IllegalArgumentException
 *     extends RuntimeException
 *     Thrown to indicate that a method has been passed an illegal or inappropriate argument.
 */
class IllegalArgumentException extends \RuntimeException { }


