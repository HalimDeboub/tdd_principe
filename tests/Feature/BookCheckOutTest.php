<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BookCheckOutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
public function a_book_can_be_checked_out_by_the_authenticated_user()
{
    $book = Book::factory()->create();
    
    $user = User::factory()->create();
    $this->actingAs($user)
    ->post('checkout/'.$book->id);
    

  $this->assertCount(1,Reservation::all());
  $this->assertEquals($user->id,Reservation::first()->user_id);
  $this->assertEquals($book->id,Reservation::first()->book_id);
  $this->assertEquals(now(),Reservation::first()->checked_out_at);
}

/** @test */
public function only_authenticated_users_can_check_out_a_book()
{
 
    
    $book = Book::factory()->create();
    $this->post('checkout/'.$book->id)->assertRedirect('/login');
    

  $this->assertCount(0,Reservation::all());
}

/** @test */
public function only_existing_table_can_be_checked_out()
{
    
    $user = User::factory()->create();
    $this->actingAs($user)
    ->post('checkout/1212')->assertStatus(404);
    

  $this->assertCount(0,Reservation::all());
}


/** @test */
public function a_book_can_be_checked_in_by_the_authenticated_user()
{
    $book = Book::factory()->create();
    
    $user = User::factory()->create();
    $this->actingAs($user)
    ->post('checkout/'.$book->id);
    
    $this->actingAs($user)
    ->post('checkin/'.$book->id);

  $this->assertCount(1,Reservation::all());
  $this->assertEquals($user->id,Reservation::first()->user_id);
  $this->assertEquals($book->id,Reservation::first()->book_id);
  $this->assertEquals(now(),Reservation::first()->checked_out_at);
  $this->assertEquals(now(),Reservation::first()->checked_in_at);

}



/** @test */
public function only_authenticated_users_can_check_in_a_book()
{
 
    //$this->withoutExceptionHandling();
    $book = Book::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user)
    ->post('checkout/'.$book->id);
    $book = Book::factory()->create();
    Auth::logout();
    $this->post('checkin/'.$book->id)
    ->assertRedirect('/login');

  $this->assertCount(1,Reservation::all());
  $this->assertNull(Reservation::first()->checked_in_at);

}

/** @test */
public function a_404_is_thrown_when_checking_in_a_non_checkout_book()
{
    $this->withoutExceptionHandling();
    $book = Book::factory()->create();
    
    $user = User::factory()->create();
    
    
    $this->actingAs($user)
    ->post('checkin/'.$book->id)
    ->assertStatus(404);

  $this->assertCount(0,Reservation::all());

}

}
