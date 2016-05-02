<?php
declare(strict_types=1);

namespace Staphp;

use Countable;
use Generator;
use InvalidArgumentException;
use IteratorAggregate;

abstract class AbstractCollection implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    private $items = [];

    private $itemClassName;

    final public function __construct(array $items = [])
    {
        $this->itemClassName = $this->getItemClassName();

        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    final public function addItem($item)
    {
        if (!$item instanceof $this->itemClassName) {
            throw new InvalidArgumentException(sprintf('Item is not an instance of %s', $this->itemClassName));
        }

        $this->items[] = $item;
    }

    final public function count() : int
    {
        return count($this->items);
    }

    final public function getIterator() : Generator
    {
        foreach ($this->items as $key => $item) {
            yield $key => $item;
        }
    }

    final public function splice($offset, $length) : self
    {
        return new static(array_slice($this->items, $offset, $length));
    }

    final public function sort(callable $callable)
    {
        usort($this->items, $callable);
    }

    abstract protected function getItemClassName() : string;
}