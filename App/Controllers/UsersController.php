<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Services\AuthenticateService;
use Zend\Diactoros\ServerRequest;

class UsersController extends BaseController
{
    /**
     * @var UsersModel
     */
    private $userModel;

    /**
     * @var AuthenticateService
     */
    private $authenticateService;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->authenticateService = new AuthenticateService();

        $this->userModel = new UsersModel();

        parent::__construct();
    }

    /**
     * @return string
     */
    public function create()
    {
        return $this->view->render('users_register.html');
    }

    /**
     * @param ServerRequest $request
     */
    public function store(ServerRequest $request)
    {

        if (!$this->authenticateService->register($request)) {

            header('Location: http://lol-friend-compare.local/users/registration');
            exit();

        }

        header('Location: http://lol-friend-compare.local/users/login');
        exit();
    }

    /**
     * @return string
     */
    public function login()
    {
        if ($this->isLoggedIn()) {

            header('Location: http://lol-friend-compare.local/users/dashboard');
            exit();
        }
        return $this->view->render('users_login.html');
    }

    /**
     * @param ServerRequest $request
     * @return string
     */
    public function validate(ServerRequest $request)
    {
        if (!$this->authenticateService->login($request)) {

            header('Location: http://lol-friend-compare.local/users/login');
            exit();
        }

        header('Location: http://lol-friend-compare.local/users/dashboard');
        exit();
    }

    /**
     * @return string
     */
    public function dashboard()
    {
        /** @var UsersModel $user */
        $user = $this->userModel->where('id', $_SESSION['user']['id'])->get()->first();

        return $this->view->render('user_dashboard.html',
            ['summoners'=>$user->summoners()->getResults(['name', 'summoner_id'])->all()]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function logout()
    {
        if (!$this->authenticateService->logout()) {

            throw new \Exception();
        }

        return $this->view->render('successful_logout.html');
    }

    public function edit()
    {
        return $this->view->render('manage_account.html');
    }

    public function update(ServerRequest $request)
    {
        if ($request->getParsedBody()['password'] !== $request->getParsedBody()['repeatPassword']) {

            return $this->view->render('failed_password_match.html');
        }

        $credentials = [];

        if($request->getParsedBody()['email']) {
            $credentials['email'] = $request->getParsedBody()['email'];
        }

        if($request->getParsedBody()['password']) {
            $credentials['password'] = $request->getParsedBody()['password'];
        }

        if(!sizeof($credentials)) {

            return $this->view->render('need_values_to_update.html');
        }

        $this->authenticateService->update($credentials);

        return $this->view->render('successful_update.html');
    }

    public function destroy()
    {

    }
}
