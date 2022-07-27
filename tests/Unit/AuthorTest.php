<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    use RefreshDatabase;
    /** @test */
    public function only_name_is_required_to_create_author()
    {
        Author::firstOrCreate([
            'name'=>'john dho'
        ]);
        $this->assertCount(1,Author::all());
    }
}