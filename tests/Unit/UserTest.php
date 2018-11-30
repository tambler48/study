<?php
/**
 * Created by PhpStorm.
 * User: Николай
 * Date: 28.11.2018
 * Time: 14:17
 */

namespace Tests\Unit;

use App\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }

    /**
     * @param $testData
     * @dataProvider addModelProvider
     */
    public function testAddModel(array $testData)
    {
        $this->user = new User();
        $this->user->addModel($testData);
        foreach ($testData as $fieldName => $fieldValue) {
            $this->assertSame($fieldValue, $this->user->$fieldName);
        }
    }

    public function testGenerateToken()
    {
        $this->user = new User();
        $token = $this->user->generateToken();
        $this->assertSame(60, mb_strlen($token));
    }

    /**
     * @param $testData
     * @dataProvider validateProvider
     */
    public function testValidate(array $testData, array $answer)
    {
        $this->user = new User();
        $this->user->addModel($testData);
        $result = $this->user->validate();
        $this->assertSame(0, count(array_diff_key($result, $answer)));
        $this->assertSame(0, count(array_diff_key($answer, $result)));
    }

    /**
     *  Data provider for testValidate method
     */
    public static function validateProvider()
    {
        return [
            [[
                "name" => "New User",
                "email" => "7b2qdasad@mail.com",
                "password" => "12345q",
                "role_id" => "3",
            ], [
                "password" => true,
            ]],
            [[
                "name" => "Dave",
                "email" => "hello@gmail.com",
                "password" => "newbie1q",
                "password_confirmation" => "newbie1q",
                "role_id" => "2",
            ], []],
            [[
                "name" => "John",
                "email" => "newusermail.com",
                "password" => "987buy085",
                "role_id" => "1",
            ], [
                "email" => true,
                "password" => true,
            ]],
            [[
                "name" => "Old User",
                "role_id" => "3",
            ], [
                "email" => true,
                "password" => true,
            ]],
        ];
    }

    /**
     *  Data provider for addModel method
     */
    public static function addModelProvider()
    {
        return [
            [[
                "name" => "New User",
                "email" => "7b2qdasad@mail.com",
                "password" => "12345q",
                "role_id" => "3",
            ]],
            [[
                "name" => "Dave",
                "email" => "hello@gmail.com",
                "password" => "newbie1q",
                "role_id" => "2",
            ]],
            [[
                "name" => "John",
                "email" => "newuser@mail.com",
                "password" => "987buy085",
                "role_id" => "1",
            ]],
            [[
                "name" => "Old User",
                "email" => "grand@mail.com",
                "password" => "validol1",
                "role_id" => "3",
            ]],
        ];
    }

}
