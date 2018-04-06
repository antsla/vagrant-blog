<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use DatabaseTransactions;

    public function testAddComment()
    {
        $this->call('POST', '/save_comment/1', ['name' => 'Тестовый пользователь', 'text' => 'Тестовый текст'])->assertSee('http');
    }
}
