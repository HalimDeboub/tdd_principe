<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Book;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function test_a_book_can_be_added_to_the_library()
    {
        
        $response= $this->post('/books',$this->data());
        $book=Book::first();
        $this->assertCount(1,Book::all());
        $response->assertRedirect($book->path());

    }
    /** @test */
    public function test_title_and_author_fields_cannot_be_null()
    {
        //$this->withoutExceptionHandling();
        $response= $this->post('/books',[
            'title'=>'',
            'author_id'=>'',
        ]);
        $response->assertSessionHasErrors(['title','author_id']);
    }

    /** @test */
    public function a_book_can_be_updated()
    {

        $this->post('/books',$this->data());

        $book=Book::first();

        $response=$this->patch('books/'.$book->id,[
            'title'=>'Murder in the train',
            'author_id'=>'new author',
        ]);

        $this->assertEquals('Murder in the train',Book::first()->title);
        $this->assertEquals(2,Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());

    }



    /** @test */
    public function a_book_can_be_deleted()
    {
        
        $this->post('/books',$this->data());

        $book=Book::first();
        $this->assertCount(1,Book::all());
        $response=$this->delete('books/' . $book->id);
        $this->assertCount(0,Book::all());
        $response->assertRedirect('/books');



    }
    
        /** @test */
        public function a_new_author_is_automatically_added()
        {
            $this->withoutExceptionHandling();
            $this->post('/books',$this->data());
    
            $book=Book::first();
            $author=Author::first();
            $this->assertEquals($author->id,$book->author_id);
            $this->assertCount(1,Author::all());
        }

        public function data()
        {
        return [
            'title'=>'Murder in the house',
            'author_id'=>1,
        ];
        }
}
