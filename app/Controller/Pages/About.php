<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use App\Utils\View;

class About extends Page
{
    /**
     * Método responsável por retornar o conteúdo (view) da página de sobre
     *
     * @return string
     */
    public static function getAbout()
    {
        // ORGANIZAÇÃO
        $objOrganization = new Organization();

        // VIEW DE SOBRE
        $content = View::render("pages/about", [
            "description" => $objOrganization->description,
            "contact"     => $objOrganization->contact
        ]);

        // RETORNA A VIEW DA PÁGINA
        return parent::getPage("Sobre", $content);
    }
}
