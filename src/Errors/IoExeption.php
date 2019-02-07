<?php


namespace GraphicEditor\Api;


use RuntimeException;

/**
 * Backend cannot save due to e.g. connection time out, full hard disk.
 */
class IoExeption extends RuntimeException { }
