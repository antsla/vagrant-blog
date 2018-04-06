<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testAdminPanel()
    {
        $this->actingAs(User::first())
            ->call('GET','/admin')
            ->assertStatus(200)
            ->assertSee('Приветствуем, admin!');
    }
}
