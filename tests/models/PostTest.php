<?php

namespace App;

use Carbon\Carbon;
use TestCase;

class PostTest extends TestCase
{
    /** @test **/
    public function it_gets_published_posts_from_scope()
    {
        $post_1 = factory(Post::class)->create(['published_at' => Carbon::yesterday()]);
        $post_2 = factory(Post::class)->create(['published_at' => Carbon::tomorrow()]);

        $posts = Post::published()->get();

        $this->assertCount(1, $posts);
        $this->assertEquals($post_1->slug, $posts->first()->slug);
    }

    /** @test **/
    public function it_gets_content_as_html()
    {
        $post = factory(Post::class)->make(['content' => "## Title \nHere is a paragraph"]);

        $this->assertEquals("<h2>Title</h2>\n<p>Here is a paragraph</p>\n", $post->getContentHtml());
    }
}
