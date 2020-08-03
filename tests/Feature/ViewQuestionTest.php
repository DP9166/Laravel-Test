<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Question;

class ViewQuestionTest extends TestCase
{

    use RefreshDatabase;
    /**
     * @test
     */
    public function user_can_view_questions()
    {
        // 0. 抛出异常
        $this->withoutExceptionHandling();
        // 1. 假设 /questions 路由存在
        // 2. 访问链接 questions
        $test = $this->get('/questions');
        // 3. 正常返回 200
        $test->assertStatus(200);
    }

    /**
     *  @test
     */
    public function user_can_view_a_single_question()
    {
        // 1. 创建一个问题
        $question = factory(Question::class)->create();
        // 2. 访问链接
        $test = $this->get('/questions/' . $question->id);
        // 3. 那么应该看到问题的内容
        $test->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }
}
