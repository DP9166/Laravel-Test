<?php

namespace Tests\Feature;

use App\Question;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAnswersTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function guests_may_not_post_an_answer()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $question = factory(Question::class)->state('published')->create();

        $this->post("/questions/{$question->id}/answers", [
            'content'   =>  'This is an answer.'
        ]);
    }

    /** @test **/
    public function signed_in_user_can_post_an_answer_to_a_published_question()
    {
        $question = factory(Question::class)->state('published')->create();
        $this->signIn($user = create(User::class));

        $reponse = $this->post("/questions/{$question->id}/answers", [
            'content'   =>  'This is an answer.'
        ]);
        $reponse->assertStatus(302);

        $answer = $question->answers()->where('user_id', $user->id)->first();
        $this->assertNotNull($answer);

        $this->assertEquals(1, $question->answers()->count());
    }

    /** @test **/
    public function content_is_required_to_post_answers()
    {
        $this->withExceptionHandling();

        $question = factory(Question::class)->state('published')->create();
        $this->signIn($user = create(User::class));

        $response = $this->post("/questions/{$question->id}/answers", [
            'user_id'   =>  $user->id,
            'content'   =>  null
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('content');
    }

    /** @test **/
    public function user_not_can_post_an_answer_to_a_unpublished_question()
    {
        $question = factory(Question::class)->state('unpublished')->create();
        $this->signIn($user = create(User::class));

        $reponse = $this->withExceptionHandling()->post("/questions/{$question->id}/answers", [
            'user_id'   =>  $user->id,
            'content'   =>  'This is an answer.'
        ]);
        $reponse->assertStatus(404);

        $this->assertDatabaseMissing('answers', ['question_id'  =>  $question->id]);
        $this->assertEquals(0, $question->answers()->count());
    }

    /** @test **/
    public function user_can_view_a_published_question()
    {
        $question = factory(Question::class)->create([
            'published_at'  =>  Carbon::parse('-1 week')
        ]);

        $this->get('/questions/'. $question->id)
            ->assertStatus(200)
            ->assertSee($question->title)
            ->assertSee($question->content);
    }

    /** @test **/
    public function user_cannot_view_a_unpublished_question()
    {
        $question = factory(Question::class)->create([
            'published_at' => null
        ]);

        $this->withExceptionHandling()
            ->get('/questions/' . $question->id)
            ->assertStatus(404);
    }

}
