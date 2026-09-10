<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    public function test_homepage_can_be_accessed(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}