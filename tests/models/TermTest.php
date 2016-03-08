<?php

namespace App;

use TestCase;

class TermTest extends TestCase
{
    /** @test **/
    public function it_sets_a_slug_when_saving_if_one_is_not_passed()
    {
        $term = Term::create([
            'taxonomy' => 'whatever',
            'term'     => 'A Good Thing',
        ]);

        $term_2 = Term::create([
            'taxonomy' => 'whatever',
            'term'     => 'A Big Thing',
            'slug'     => 'my-own-term',
        ]);

        $this->assertEquals('a-good-thing', $term->slug);
        $this->assertEquals('my-own-term', $term_2->slug);
    }
}
