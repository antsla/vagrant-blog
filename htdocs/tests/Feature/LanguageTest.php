<?php

namespace Tests\Feature;

use Tests\TestCase;

class LanguageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->call('GET', '/setlocale/ru')->assertCookie('locale', 'ru');
        $this->call('GET', '/setlocale/en')->assertCookie('locale', 'en');
    }
}
