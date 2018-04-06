<?php

namespace Tests\Feature;

use App\Models\Article;
use Tests\TestCase;

class PageSetTest extends TestCase
{
    public function testPage()
    {
        $oResponseMain = $this->call('GET', '/');
        $oResponseMain->assertSuccessful();

        $oResponseFeedback = $this->call('GET', '/feedback');
        $oResponseFeedback->assertSuccessful();

        $iId = Article::max('id');
        $oResponseArticle = $this->call('GET', '/articles/' . $iId);
        $oResponseArticle->assertSuccessful();

        $oResponseLogin = $this->call('GET', '/login');
        $oResponseLogin->assertSuccessful();

        $oResponseRegister = $this->call('GET', '/register');
        $oResponseRegister->assertSuccessful();

        $oResponse404 = $this->call('GET', hash('md5', time()));
        $oResponse404->assertStatus(404);
    }
}
