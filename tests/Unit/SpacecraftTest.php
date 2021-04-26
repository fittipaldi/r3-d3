<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpacecraftTest extends TestCase
{
    private $TOKEN_BEARER_JEDI = 'JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0';
    private $TOKEN_BEARER_NO_JEDI = 'NO-JEDI-EHYJzdWIiOiJkZmRmc2RmZHMiLCJuYW1lIjP0';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSetSpacecraftJedi()
    {
        $response = $this->json('POST', '/api/v1/spacecraft/add', [
            'name' => 'Devastator -- TESTING [I AM A JEDI]',
            'class' => 'Star Destroyer',
            'crew' => 35000,
            'image' => 'https:\\url.to.image',
            'value' => '1999.99',
            'status' => 'operational',
            'armament' => [
                '1' => [
                    'title' => 'Turbo Laser',
                    'qtd' => 111
                ],
                '2' => [
                    'title' => 'Ion Cannons',
                    'qtd' => 222
                ],
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->TOKEN_BEARER_JEDI
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSetSpacecraftNoJedi()
    {
        $response = $this->json('POST', '/api/v1/spacecraft/add', [
            'name' => 'Devastator -- TESTING [I AM NOT A JEDI]',
            'class' => 'Star Destroyer',
            'crew' => 35000,
            'image' => 'https:\\url.to.image',
            'value' => '1999.99',
            'status' => 'operational',
            'armament' => [
                '1' => [
                    'title' => 'Turbo Laser',
                    'qtd' => 111
                ],
                '2' => [
                    'title' => 'Ion Cannons',
                    'qtd' => 222
                ],
            ]
        ], [
            'Authorization' => 'Bearer ' . $this->TOKEN_BEARER_NO_JEDI
        ]);
        $response->assertStatus(401);
    }
}