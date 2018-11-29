<?php
/**
 * Created by PhpStorm.
 * User: Николай
 * Date: 26.11.2018
 * Time: 12:13
 */

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;


class UserControllerTest extends TestCase
{
    public function setUp()
    {
        $this->_testable = new Testable();
    }


    public function testStore()
    {

        $this->user = new User();
        $this->user = $this->user::find(1);
        $this->actingAs($this->user);
        $request=$this->post('user/manage', [
            "_token" => csrf_field(),
            "name" => "New User",
            "email" => "7b2qdasad@mail.com",
            "password" => "12345q",
            "password_confirmation" => "12345q",
            "role_id" => "3",
        ]);
        $request = Request::shouldReceive();

        dd($request);
        $userContr = new UserController();
        dd($userContr->store($request));

    }

    /**
     * @dataProvider showProvider
     * @param $authUser
     * @param $showUser
     * @param $answer
     */
    public function testShow($authUser, $showUser, $answer)
    {
        $this->user = new User();
        $this->user = $this->user::find($authUser);
        $this->actingAs($this->user);

        $userContr = new UserController();
        $this->assertInstanceOf($answer, $userContr->show($showUser));
    }

    /**
     *  Data provider for testStore method
     */
    public static function storeProvider()
    {
        return [
            [  ],
        ];
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

}
