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
        $this->withExceptionHandling()
            ->get('/questions')
            ->assertStatus(200);
    }

    /**
     *  @test
     */
    public function user_can_view_a_single_question()
    {
        // 1. 创建一个问题
        $question = factory(Question::class)->state('published')->create();

        // 2. 访问链接
        $this->get('/questions/' . $question->id)->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }
}
