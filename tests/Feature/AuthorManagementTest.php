<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{

use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/authors',[
            'name'=>'author name',
            'dob'=>'12/02/1962'
        ]);
        $response->assertStatus(200);
        $author=Author::all();
        $this->assertCount(1 ,Author::all());
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1962/02/12',$author->first()->dob->format('Y/d/m'));
    }
}
