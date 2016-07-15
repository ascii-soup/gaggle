<?php
/**
 * Exception thrown when a method that would mutate state is called
 */

namespace AsciiSoup\Gaggle\Exception;


class MutateOperationsNotAllowed extends \BadMethodCallException
{

}