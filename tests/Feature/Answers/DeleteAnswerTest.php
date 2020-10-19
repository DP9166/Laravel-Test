<?php

namespace Tests\Feature\Answers;

use App\Answer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAnswerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function guest_cannot_delete_answers()
    {

        $this->withExceptionHandling();

        $answer = create(Answer::class);

        $this->delete(route('answers.destroy', ['answer'    =>  $answer]))
            ->assertRedirect('login');
    }

    /**
     * @test
     */
    public function unauthorized_users_cannot_delete_answers()
    {
        $this->signIn()->withExceptionHandling();

        $answer = create(Answer::class);

        $this->delete(route('answers.destroy', ['answer'    =>  $answer]))->assertStatus(403);
    }

    /**
     * @test
     */
    public function authorized_users_can_delete_answers()
    {
        $this->signIn();

        $answer = create(Answer::class, ['user_id'  =>  auth()->id()]);

        $this->delete(route('answers.destroy', ['answer'    =>  $answer]))->assertStatus(302);

        $this->assertDatabaseMissing('answers', ['id'   =>  $answer->id]);
    }
}
