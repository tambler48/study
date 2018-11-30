<?php
/**
 * Created by PhpStorm.
 * User: Николай
 * Date: 30.11.2018
 * Time: 16:04
 */

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    /**
     * @param $testData
     * @dataProvider addPostProvider
     */
    public function testAddPost($testData)
    {
        $post = new Post();
        $post->addPost($testData);
        foreach ($testData as $fieldName => $fieldValue){
            $this->assertSame($fieldValue, $post->$fieldName);
        }
    }

    /**
     * @param array $testData
     * @param array $answer
     * @dataProvider validateProvider
     */
    public function testValidate(array $testData, array $answer)
    {
        $post = new Post();
        $post->addPost($testData);
        $result = $post->validate();
        $this->assertSame(0, count(array_diff_key($result, $answer)));
        $this->assertSame(0, count(array_diff_key($answer, $result)));
    }

    public function addPostProvider(){
        return [
            [[
                'user_id' => '1',
                'header' => 'Post header ',
                'body' => 'My first post.',
            ]],
            [[
                'user_id' => '2',
                'header' => 'Creating & Running Tests',
                'body' => 'To create a new test case, use the make:test Artisan command:',
            ]],
            [[
                'user_id' => '3',
                'header' => 'Environment',
                'body' => 'When running tests via phpunit, Laravel will automatically set the configuration environment to testing because of the environment variables defined in the phpunit.xml file. Laravel also automatically configures the session and cache to the array driver while testing, meaning no session or cache data will be persisted while testing.',
            ]],
        ];
    }

    public function validateProvider(){
        return [
            [[
                'user_id' => '1',
                'header' => 'Post header ',
                'body' => 'My first post.',
            ], []
            ],
            [[
                'header' => 'Creating & Running Tests',
                'body' => 'To create a new test case, use the make:test Artisan command:',
            ], [
                'user_id' => true,
            ]],
            [[
                'user_id' => '3',
                ], [
                'header' => true,
                'body' => true
            ]],
        ];
    }
}
