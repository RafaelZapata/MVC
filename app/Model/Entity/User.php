<?php

namespace App\Model\Entity;

use App\Db\Database;

class User
{
    /**
     * ID do usuário
     *
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     *
     * @var string
     */

    public $name;
    /**
     * Email do usuário
     *
     * @var string
     */

    public $email;

    /**
     * Senha do usuário
     *
     * @var string
     */
    public $password;

    /**
     * Método responsável por retornar um usuário com base no seu email
     *
     * @param strgin $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
