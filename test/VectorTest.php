<?php
/**
 * Tests for Gaggle Vectors
 */

namespace AsciiSoup\Gaggle\Test;


use AsciiSoup\Gaggle\Vector;

class VectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    function it_can_be_created_with_a_native_array()
    {
        $vector = new Vector(array(1, 2, 3));

        assertThat($vector->asArray(), arrayContainingInAnyOrder(1, 2, 3));
    }

    /**
     * @test
     */
    function individual_elements_can_be_retrieved_by_index()
    {
        $vector = new Vector(array(1, 2, 3));

        assertThat($vector->get(0), is(equalTo(1)));
    }

    /**
     * @test
     */
    function elements_can_be_added()
    {
        $vector = new Vector();

        $newVector = $vector->add(15);

        assertThat($newVector->get(0), is(equalTo(15)));
    }

    /**
     * @test
     */
    function vectors_are_immutable()
    {
        $vector = new Vector();

        $newVector = $vector->add("Hello");

        assertThat($vector->count(), is(equalTo(0)));
        assertThat($newVector->count(), is(equalTo(1)));
    }

    /**
     * @test
     */
    function it_can_provide_its_head()
    {
        $vector = new Vector(array(1, 2, 3));

        assertThat($vector->head(), is(equalTo(1)));
    }

    /**
     * @test
     */
    function it_can_provide_its_tail()
    {
        $vector = new Vector(array(1, 2, 3));

        assertThat($vector->tail()->asArray(), is(arrayContaining(2, 3)));
    }

    /**
     * @test
     */
    function it_can_be_filtered()
    {
        $vector = new Vector(array(1, 2, 3, 4, 5));

        $filteredVector = $vector->filter(function ($item) {
            return $item % 2 == 0;
        });

        assertThat($filteredVector->asArray(), is(arrayContaining(2, 4)));
    }

    /**
     * @test
     */
    function it_can_be_filtered_with_hamcrest_matchers()
    {
        $vector = new Vector(array("Hello", "Hello there", "Goodbye"));

        $filteredVector = $vector->filter(startsWith("Hello"));

        assertThat($filteredVector->asArray(), is(arrayContaining("Hello", "Hello there")));
    }

    /**
     * @test
     */
    function it_can_be_mapped()
    {
        $vector = new Vector(array(1, 2, 3, 4, 5));

        $mappedVector = $vector->map(function ($item) {
            return $item * 2;
        });

        assertThat($mappedVector->asArray(), is(arrayContaining(2, 4, 6, 8, 10)));
    }

    /**
     * @test
     */
    function it_can_be_iterated()
    {
        $total = 0;
        $vector = new Vector(array(1, 2, 3));

        foreach ($vector as $item) {
            $total += $item;
        }

        assertThat($total, is(equalTo(6)));
    }

    /**
     * @test
     */
    function it_supports_bracket_notation_for_reads()
    {
        $vector = new Vector(array(1, 2, 3));

        assertThat($vector[0], is(equalTo(1)));
    }

    /**
     * @test
     */
    function it_doesnt_support_bracket_notation_for_writes()
    {
        $vector = new Vector(array(1, 2, 3));

        $this->setExpectedException('AsciiSoup\\Gaggle\\Exception\\MutateOperationsNotAllowed');

        $vector[0] = 5;
    }
}
