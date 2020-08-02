<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewQuestionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserCanViewQuestions()
    {
        // 0. 抛出异常
        $this->withoutExceptionHandling();
        // 1. 假设 /questions 路由存在
        // 2. 访问链接 questions
        $test = $this->get('/questions');
        // 3. 正常返回 200
        $test->assertStatus(200);
    }
}
