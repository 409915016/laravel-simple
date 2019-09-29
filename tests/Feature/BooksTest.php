<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksTest extends TestCase
{

	public function test_a_title_is_required()
	{
		$response = $this->json('POST', '/books', array_merge($this->data(), ['title' => '']) );

		$response
			->assertStatus(422)
			->assertJson([
				'code' => '422'
			]);
	}

	public function test_the_file_field_is_required_when_type_is_ebook()
	{
		$response = $this->json('POST', '/books', array_merge($this->data(),[
			'title'  => '123',
			'author' => '123',
			'type'   => 'ebook'
		]));
		$response
			->assertStatus(422)
			->assertJson([
				'code' => '422'
			]);
	}

	public function test_a_book_can_be_added_through_post()
	{
		$response = $this->json('POST', '/books', $this->data());
		$response
			->assertStatus(200)
			->assertJson([
				'code' => '200'
			]);
	}

	private function data()
	{
		return [
			'title' => 'Test book title',
			'author' => 'Test author',
		];
	}
}
