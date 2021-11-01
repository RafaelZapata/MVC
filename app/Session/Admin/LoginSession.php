<?php

namespace App\Session\Admin;

class LoginSession
{
    /**
     * Método responsável por iniciar a sessão
     *
     */
    private static function init()
    {
        // VERIFICA SE A SESSÃO NÃO ESTÁ ATIVA
        if (session_status()  != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Método responsável por criar o login do usuário
     *
     * @param User $objUser
     * @return boolean
     */
    public static function login($objUser)
    {
        // INICIA A SESSÃO
        self::init();

        // DEFINE A SESSÃO DO USUÁRIO
        $_SESSION['admin']['usuario'] = [
            'id'    => $objUser->id,
            'name'  => $objUser->name,
            'email' => $objUser->email
        ];

        // SUCESSO
        return true;
    }

    /**
     * Método responsável por verificar se o usuário está logado
     *
     * @return boolean
     */
    public static function isLogged()
    {
        self::init();

        return isset($_SESSION['admin']['usuario']['id']);
    }

    /**
     * Método responsável por executar o logout do usuário
     *
     * @return boolean
     */
    public static function logout()
    {
        // INICIA A SESSÃO
        self::init();

        // DESLOGA O USUÁRIO
        unset($_SESSION['admin']['usuario']);

        // SUCESSO
        return true;
    }
}
