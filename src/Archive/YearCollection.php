<?php
declare(strict_types=1);

namespace Staphp\Archive;

use Staphp\AbstractCollection;

class YearCollection extends AbstractCollection
{
    protected function getItemClassName() : string
    {
        return Year::class;
    }

    public function sortByYear()
    {
        $this->sort(function (Year $yearA, Year $yearB) : int {
            if ($yearA->getYear() > $yearB->getYear()) {
                return -1;
            }

            if ($yearA->getYear() < $yearB->getYear()) {
                return 1;
            }

            return 0;
        });
    }
}