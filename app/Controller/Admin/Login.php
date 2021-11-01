<?php

namespace App\Controller\Admin;

use App\Model\Entity\User;
use App\Session\Admin\LoginSession;
use App\Utils\View;

class Login extends Page
{
    /**
     * Método responsável por retornar a renderização da página de login
     * @param Request $request
     *
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {
        // STATUS
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '' ;

        // CONTEÚDO DA PÁGINA DE LOGIN
        $content = View::render('admin/login', [
        'status' => $status
        ]);

        // RETORNA PÁGINA COMPLETA
        return parent::getPage('Login', $content);
    }

    /**
     * Método responsável por definir o login do usuário
     *
     * @param Request $request
     * @return string
     */
    public static function insertLogin($request)
    {
        // POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars['email'] ?? '';
        $password = $postVars['password'] ?? '';

        // BUSCA O USUÁRIO PELO EMAIL
        $objUser = User::getUserByEmail($email);

        // VERIFICA SE O USUÁRIO RETORNOU E É UMA INSTANCIA DE USER
        if (!$objUser instanceof User) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        // VERIFICA A SENHA DO USUÁRIO
        if (!password_verify($password, $objUser->password)) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        // CRIA A SESSÃO DE LOGIN
        LoginSession::login($objUser);

        // REDIRECIONA O USUÁRIO PARA O HOME DO ADMIN
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Método responsável por deslogar o usuário
     *
     * @param Request $request
     * @return void
     */
    public static function setLogout($request)
    {
        // DESTROI A SESSÃO DO USUÁRIO
        LoginSession::logout();

        // REDIRECIONA O USUÁRIO PARA TELA DE LOGIN
        $request->getRouter()->redirect('/admin/login');
    }
}
