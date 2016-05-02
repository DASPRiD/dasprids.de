<?php
declare(strict_types=1);

namespace Staphp\Post;

use Staphp\AbstractCollection;

class PostCollection extends AbstractCollection
{
    protected function getItemClassName() : string
    {
        return Post::class;
    }

    public function sortByDate()
    {
        $this->sort(function (Post $postA, Post $postB) : int {
            if ($postA->getDate() > $postB->getDate()) {
                return -1;
            }

            if ($postA->getDate() < $postB->getDate()) {
                return 1;
            }

            return 0;
        });
    }
}