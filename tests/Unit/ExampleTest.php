<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    public function testBasicTest()
    {
        // Given I ahve two records in the database that are posts,

        // and each one is posted a month apart.
        $first = factory(Post::class)->create();
        $second = factory(Post::class)->create([
            'created_at' => \Carbon\Carbon::now()->subMonth()
        ]);

        // When I fetch the archives
        $posts = Post::archives();

        // Then the response should be in the proper format.
        $this->assertEquals([
            [
                "year" => $second->created_at->format('Y'),
                "month" => $second->created_at->format('F'),
                "published" => 1
            ],
            [
                "year" => $first->created_at->format('Y'),
                "month" => $first->created_at->format('F'),
                "published" => 1
            ]

        ], $posts);
    }
}
