<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Page
{

    /**
     * Método responsável por renderizar o topo da página
     *
     * @return string
     */
    private static function getHeader()
    {
        return View::render("pages/header");
    }

    /**
     * Método responsável por renderizar o final da página
     *
     * @return string
     */
    private static function getFooter()
    {
        return View::render("pages/footer");
    }

    /**
     * Método responsável por renderizar o layout de páginação
     *
     * @param Request $request
     * @param Pagination $objPagination
     * @return string
     */
    public static function getPagination($request, $objPagination)
    {
        // PÁGINAS
        $pages = $objPagination->getPages();

        // VERIFICA A QUANTIDADE DE PÁGINAS
        (count($pages) <= 1) ?? '';

        // LINKS
        $links = '';

        // URL ATUAL SEM GETS
        $url = $request->getRouter()->getCurrentUrl();

        // GET
        $queryParams = $request->getQueryParams();

        // RENDERIZA OS LINKS
        foreach ($pages as $page) {
            // ALTERA A PÁGINA
            $queryParams['page'] = $page['page'];

            // LINK
            $link = $url . '?' . http_build_query($queryParams);

            // VIEW
            $links .= View::render("pages/pagination/link", [
            "page"   => $page['page'],
            "link"   => $link,
            "active" => $page['current'] ? 'active' : ''
            ]);
        }

        // RENDERIZA BOX DE PAGINAÇÃO
        return View::render("pages/pagination/box", [
            "links" => $links
            ]);
    }

    /**
     * Método responsável por retornar o conteúdo (view) da nossa página genérica
     *D
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render("pages/page", [
            "header"  => self::getHeader(),
            "title"   => $title,
            "content" => $content,
            "footer"  => self::getFooter()
        ]);
    }
}
