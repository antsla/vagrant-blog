<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeedbackTest extends TestCase
{
    use DatabaseTransactions;

    public function testRequests()
    {
        // Проверка не post запросов
        $this->json('GET', '/feedbackSendAjax', [])->assertStatus(405);
        $this->json('PUT', '/feedbackSendAjax', [])->assertStatus(405);
        $this->json('DELETE', '/feedbackSendAjax', [])->assertStatus(405);
        $this->json('PATCH', '/feedbackSendAjax', [])->assertStatus(405);
    }

    public function testESend()
    {
        // Проверка success
        $this->json('POST', '/feedbackSendAjax', [
                'name' => 'Vasya',
                'email' => 'slavka20082008@yandex.ru',
                'text' => 'Текстовое сообщение длиною более 20 символов'
                ])
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'message' => Lang::get('feedback.add_success')
            ]);

        // Проверки fail
        $this->json('POST', '/feedbackSendAjax', [
            'fb_email' => 'slavka20082008@yandex.ru',
            'fb_text' => 'Текстовое сообщение длиною более 20 символов'
        ])->assertJsonFragment(['fail' => true]);

        $this->json('POST', '/feedbackSendAjax', [
            'fb_name' => 'Vasya',
            'fb_text' => 'Текстовое сообщение длиною более 20 символов'
        ])->assertJsonFragment(['fail' => true]);

        $this->json('POST', '/feedbackSendAjax', [
            'fb_name' => 'Vasya',
            'fb_email' => 'slavka20082008@yandex.ru'
        ])->assertJsonFragment(['fail' => true]);
    }

}
