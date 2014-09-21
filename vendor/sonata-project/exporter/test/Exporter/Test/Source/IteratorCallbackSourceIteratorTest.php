<?php

namespace Exporter\Test\Source;

use Exporter\Source\IteratorCallbackSourceIterator;

class IteratorCallbackSourceIteratorTest extends \PHPUnit_Framework_TestCase
{
    /** @var IteratorCallbackSourceIterator */
    protected $sourceIterator;

    /** @var \ArrayIterator */
    protected $iterator;

    public function testTransformer()
    {
        $result = array(1, 2, 4, 8);

        foreach ($this->sourceIterator as $key => $value) {
            $this->assertEquals(array($result[$key]), $value);
        }
    }

    public function testExtends()
    {
        $this->assertInstanceOf('Exporter\Source\IteratorSourceIterator', $this->sourceIterator);
    }

    public function testGetIterator()
    {
        $this->assertSame($this->iterator, $this->sourceIterator->getIterator());
    }

    protected function setUp()
    {
        $this->iterator = new \ArrayIterator(array(array(0), array(1), array(2), array(3)));
        $this->sourceIterator = new IteratorCallbackSourceIterator($this->iterator, function ($data) {
            $data[0] = 1 << $data[0];

            return $data;
        });
    }
}
