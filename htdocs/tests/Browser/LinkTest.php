<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LinkTest extends DuskTestCase
{
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('title', 'Статья')
                ->select('group_id', '0')
                ->type('dateTo', date('Y-m-d'))
                ->press('Найти')
                ->clickLink('читать далее...')
                ->assertDontSee('Редактировать')
                ->assertDontSee('Удалить');
        });
    }
}
