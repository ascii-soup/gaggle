<?php
/**
 * Represents a Vector
 */
namespace AsciiSoup\Gaggle;

use Hamcrest\Matcher;

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
     * The callback can also be a Hamcrest matcher
     *
     * https://github.com/hamcrest/hamcrest-php
     * or
     * https://code.google.com/archive/p/hamcrest/wikis/TutorialPHP.wiki
     *
     * @param callable|Matcher $callback
     * @return Vector
     */
    public function filter($callback)
    {
        if (class_exists('\Hamcrest\Matcher') && ($callback instanceof Matcher)) {
            $actualCallback = function ($item) use ($callback) {
                return $callback->matches($item);
            };
        } elseif (!is_callable($callback)) {
            throw new \InvalidArgumentException("$callback must be a Hamcrest matcher or a valid callable");
        } else {
            $actualCallback = $callback;
        }

        return new self(
            array_filter($this->items(), $actualCallback)
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

    /**
     * Reduce the collection to a single value
     * using a callback.
     *
     * The callback should take two arguments - the current item
     * and the current value of the reduce operation
     *
     * e.g. function add_together($item, $value) { return $item + $value; }
     *
     * @param callable $callback
     * @param mixed|null $initial
     * @return mixed
     */
    public function reduce($callback, $initial = null)
    {
        return array_reduce($this->items(), $callback, $initial);
    }

    public function contains($item)
    {
        $needles = func_get_args();

        foreach ($needles as $needle) {
            if ( ! in_array($needle, $this->items())) {
                 return false;
            }
        }

        return true;
    }
}
