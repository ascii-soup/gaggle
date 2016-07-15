<?php
/**
 * Represents a Vector
 */
namespace AsciiSoup\Gaggle;

class Vector extends Collection
{
    /**
     * Add a new item to the collection
     *
     * @param mixed $item
     * @return Vector
     */
    public function add($item)
    {
        return new self(
            array_merge($this->items(), array($item))
        );
    }

    /**
     * Retrieve the item at the given index
     *
     * @param int $index
     * @return mixed
     */
    public function get($index)
    {
        return $this->retrieveByKey($index);
    }

    /**
     * Returns the first item in the vector
     *
     * @return mixed
     */
    public function head()
    {
        return $this->get(0);
    }

    /**
     * Returns all but the first item as a new vector
     *
     * @return Vector
     */
    public function tail()
    {
        $items = $this->items();
        array_shift($items);
        return new self($items);
    }

    /**
     * Apply a callback to filter the vector
     * Returns a new vector containing the filtered items
     *
     * The callback should take a single argument - the item to be filtered
     * and return true to keep the item, false to remove it
     *
     * e.g.   function remove_odd_numbers($item) { return $item % 2 == 0; }
     *
     * @param callable $callback
     * @return Vector
     */
    public function filter($callback)
    {
        return new self(
            array_filter($this->items(), $callback)
        );
    }

    /**
     * Apply a callback to each element of the vector
     * Returns a new vector containing all the elements with the callback applied to them
     *
     * The callback should take a single argument - the item to be modified
     * and return the modified item
     *
     * e.g. function multiply_by_two($item) { return $item * 2; }
     * 
     * @param callable $callback
     * @return Vector
     */
    public function map($callback)
    {
        return new self(
            array_map($callback, $this->items())
        );
    }
}