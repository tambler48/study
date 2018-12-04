<?php
/**
 * Created by PhpStorm.
 * User: Николай
 * Date: 30.11.2018
 * Time: 15:28
 */

namespace Tests\Unit;

use App\Comment;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    /**
     * @param $testData
     * @dataProvider addContentProvider
     */
    public function testAddContent(array $testData): void
    {
        $comment = new Comment();
        $comment->addContent($testData);
        foreach ($testData as $fieldName => $fieldValue) {
            $this->assertSame($fieldValue, $comment->$fieldName);
        }
    }

    /**
     * @param array $testData
     * @param array $answer
     * @dataProvider validateProvider
     */
    public function testValidate(array $testData, array $answer): void
    {
        $comment = new Comment();
        $comment->addContent($testData);
        $result = $comment->validate();
        $this->assertSame(0, count(array_diff_key($result, $answer)));
        $this->assertSame(0, count(array_diff_key($answer, $result)));

    }

    public function validateProvider(): array
    {
        return [
            [[
                'post_id' => '1',
                'user_id' => '1',
                'body' => 'My first comment.',
            ], [],],
            [[
                'post_id' => '9999',
                'user_id' => '2',
                'body' => 'My second comment.',
            ], [
                'post_id' => true,
            ],],
            [[
                'post_id' => '2',
                'user_id' => '9999',
                'body' => 'My third comment.',
            ], [
                'user_id' => true,
            ],],
            [[
                'post_id' => '2',
                'user_id' => '5',
            ], [
                'body' => true,
            ],],
            [[], [
                'post_id' => true,
                'user_id' => true,
                'body' => true,
            ],],
        ];
    }

    public function addContentProvider(): array
    {
        return [
            [[
                'post_id' => '1',
                'user_id' => '1',
                'body' => 'My first comment.',
            ]],
            [[
                'post_id' => '10',
                'user_id' => '2',
                'body' => 'My second comment.',
            ]],
            [[
                'post_id' => '2',
                'user_id' => '3',
                'body' => 'My third comment.',
            ]],
        ];
    }
}
