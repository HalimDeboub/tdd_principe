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
        $response = $this->post('/authors',$this->data());
        $response->assertStatus(200);
        $author=Author::all();
        $this->assertCount(1 ,Author::all());
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1962/02/12',$author->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function the_author_name_field_is_required()
    {
        $response = $this->post('/authors',array_merge($this->data(),['name'=>'']) );
        $response->assertSessionHasErrors('name');

    }
    /** @test */
    public function the_author_dob_field_is_required()
    {
        $response = $this->post('/authors',array_merge($this->data(),['dob'=>'']) );
        $response->assertSessionHasErrors('dob');

    }
    private function data()
    {
        return [
            'name'=>'author name',
            'dob'=>'12/02/1962'
        ];
    }
}
