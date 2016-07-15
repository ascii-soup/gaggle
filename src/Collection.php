<?php
/**
 * The base collection class
 */

namespace AsciiSoup\Gaggle;

use AsciiSoup\Gaggle\Exception\MutateOperationsNotAllowed;
use AsciiSoup\Gaggle\Exception\NoItemAtKey;

/**
 * Class Collection
 * An immutable collection of items
 *
 * @package AsciiSoup\Gaggle
 */
abstract class Collection implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * @var array
     */
    private $items;

    /**
     * @param array $items An initial array to add to the collection
     */
    function __construct($items = array())
    {
        $this->items = $items;
    }

    /**
     * @return array
     */
    protected function items()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items());
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items());
    }

    /**
     * Retrieve the item at the given index in the underlying collection
     *
     * @param int|string $key
     * @return mixed
     *
     * @throws Exception\NoItemAtKey
     */
    protected function retrieveByKey($key)
    {
        if ( ! isset($this->items[$key])) {
            throw new NoItemAtKey("No item exists at key [{$key}].", 1);
        }

        return $this->items[$key];
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->retrieveByKey($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        throw new MutateOperationsNotAllowed();
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        throw new MutateOperationsNotAllowed();
    }

    /**
     * Get the collection as a PHP array
     * @return array
     */
    public function asArray()
    {
        return $this->items();
    }

}