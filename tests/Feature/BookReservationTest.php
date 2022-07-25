<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Book;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_a_book_can_be_added_to_the_library()
    {
        
        $this->withoutExceptionHandling();
        $response= $this->post('/books',[
            'title'=>'Murder in the house',
            'author'=>'John Dho',
        ]);
        $response->assertOk();
        $this->assertCount(1,Book::all());
        
    }
    /** @test */
    public function test_title_and_author_fields_cannot_be_null()
    {
        //$this->withoutExceptionHandling();
        $response= $this->post('/books',[
            'title'=>'',
            'author'=>'',
        ]);
        $response->assertSessionHasErrors(['title','author']);
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title'=>'Murder in the house',
            'author'=>'John Dho',
        ]);

        $book=Book::first();

        $this->patch('books/'.$book->id,[
            'title'=>'Murder in the train',
            'author'=>'John Week',
        ]);

        $this->assertEquals('Murder in the train',Book::first()->title);
        $this->assertEquals('John Week',Book::first()->author);
    }
}
