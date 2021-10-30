<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class Home extends Page
{

    /**
     * Método responsável por retornar o conteúdo (view) da nossa home
     *
     * @return string
     */
    public static function getHome()
    {

        // ORGANIZAÇÃO
        $objOrganization = new Organization();
        // VIEW DA HOME
        $content = View::render("pages/home", [
            "name"        => $objOrganization->name
        ]);

        // RETORNA A VIEW DA PÁGINA
        return parent::getPage("MVC Básico", $content);
    }
}
