<?php
declare(strict_types=1);

namespace Staphp\Post;

use Staphp\AbstractCollection;

class TagCollection extends AbstractCollection
{
    protected function getItemClassName() : string
    {
        return Tag::class;
    }

    public function sortByLabel()
    {
        $this->sort(function (Tag $tagA, Tag $tagB) : int {
            return strcasecmp($tagA->getLabel(), $tagB->getLabel());
        });
    }
}
