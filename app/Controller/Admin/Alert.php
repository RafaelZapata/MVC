<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Alert
{
    /**
     * Método responsável por retornar uma mensagem de sucess
     *
     * @param string $message
     * @return string
     */
    public static function getSucess($message)
    {
        return View::render('admin/alert/status', [
            'tipo'     => 'success',
            'mensagem' => $message
        ]);
    }

    /**
     * Método responsável por retornar uma mensagem de error
     *
     * @param string $message
     * @return string
     */
    public static function getError($message)
    {
        return View::render('admin/alert/status', [
            'tipo'     => 'danger',
            'mensagem' => $message
        ]);
    }
}
