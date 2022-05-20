<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function when_user_tries_to_query_multiple_zip_codes()
    {
        $zicodes = [ 'ceps' => '13605-342,13604098,1360088x'];
        $response = $this->get(route('search.local', $zicodes));
        $response
            ->assertJsonCount(2, 'data.locations')
            ->assertJsonCount(1, 'data.zipcode_with_errors')
            ->assertStatus(200);

        $this->assertEquals('Locations successfully retrieved',$response->json('message'));
    }

    /** @test */
    public function when_user_tries_to_query_a_zip_code()
    {
        $zicodes = [ 'ceps' => '13605-342'];
        $response = $this->get(route('search.local', $zicodes));
        $response
            ->assertJsonCount(1, 'data.locations')
            ->assertJsonCount(0, 'data.zipcode_with_errors')
            ->assertStatus(200);
        $this->assertEquals('Locations successfully retrieved',$response->json('message'));
    }

    /** @test */
    public function when_user_tries_to_query_a_zip_code_with_error()
    {
        $zicodes = [ 'ceps' => '13605A342'];
        $response = $this->get(route('search.local', $zicodes));
        $response
            ->assertJsonCount(0, 'data.locations')
            ->assertJsonCount(1, 'data.zipcode_with_errors')
            ->assertStatus(400);
        $this->assertEquals('Fail to retrieve locations',$response->json('message'));
    }

}
