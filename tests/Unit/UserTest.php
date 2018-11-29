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
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
        //dd($this->getConnection());
    }

    /**
     * @dataProvider showProvider
     * @param $authUser
     * @param $showUser
     * @param $answer
     */
    public function testValidate($authUser, $showUser, $answer)
    {


        $this->user = new User();
        $this->user = $this->user::find($authUser);
        $this->actingAs($this->user);
        $this->assertTrue(true);
    }

    /**
     *  Data provider for testShow method
     */
    public static function showProvider()
    {
        return [
            ['1', '1', 'Illuminate\View\View',],
            ['1', '100', 'Illuminate\Http\RedirectResponse',],
            ['3', '100', 'Illuminate\Http\RedirectResponse',],
            ['3', '1', 'Illuminate\Http\RedirectResponse',],
        ];
    }

    /**
     * @param $testData
     * @dataProvider addModelProvider
     */
    public function testAddModel($testData)
    {
        $this->user = new User();
        $this->user->addModel($testData);
        $this->assertTrue(Hash::check($testData['password'], $this->user->password));
        unset($testData['password']);
        foreach ($testData as $fieldName => $fieldValue){
            $this->assertSame($fieldValue, $this->user->$fieldName);
        }
    }

    public function testValidator()
    {

    }

    public function testGenerateToken()
    {

    }


    /**
     *  Data provider for testShow method
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
