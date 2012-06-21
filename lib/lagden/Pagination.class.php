<?php
class Pagination
{
    static public $merge = array();

    public static function show($page=1, $pages=1, $route=null, $xtras=array())
    {
        static::$merge = $xtras;
        $adjacents = 3;
        $prev = $page-1;
        $next = $page+1;
        $lastpage = $pages;
        $lpm = $pages-1;

        $anterior   = '<button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => $prev)).'" class="prior paginacao paginacaoUI">❮</button>';
        $anteriorD  = '<button type="button" class="prior paginacaoDisabled paginacaoUI">❮</button>';
        $proximo    = '<button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => $next)).'" class="next paginacao paginacaoUI">❯</button>';
        $proximoD   = '<button type="button" class="next paginacaoDisabled paginacaoUI">❯</button>';

        $pagination = '<div class="pagination">';

        if($lastpage > 1)
        {
            $pagination .= " ";
            //previous button
            if ($page > 1) $pagination .= $anterior;
            else $pagination .= $anteriorD;  //disabled

            //pages 
            if($lastpage < 7 + ($adjacents * 2))
            { 
                for($counter = 1; $counter <= $lastpage; $counter++)$pagination.=static::countPage($counter,$page,$route);
            }
            elseif($lastpage > 5 + ($adjacents * 2))
            {
                if($page < 1 + ($adjacents * 2))
                {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)$pagination.=static::countPage($counter,$page,$route);
                    $pagination.=static::lastPage($lpm,$lastpage,$route);
                }
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                {
                    $pagination.=static::oneTwo($route);
                    for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)$pagination.=static::countPage($counter,$page,$route);
                    $pagination.=static::lastPage($lpm,$lastpage,$route);
                }
                else
                {
                    $pagination.=static::oneTwo($route);
                    for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)$pagination.=static::countPage($counter,$page,$route);
                }
            }
            //next button
            if ($page < $counter - 1)$pagination.=$proximo;
            else $pagination.=$proximoD;
        }

        $pagination .= '</div>';

        return $pagination;
    }

    protected static function countPage($counter,$page,$route)
    {
        if($counter == $page)return '<button type="button" class="paginacaoSelecionado paginacaoUI">'.$counter.'</button>';
        else return '<button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => $counter)).'" class="paginacao paginacaoUI">'.$counter.'</button>';
    }

    protected static function lastPage($lpm,$lastpage,$route)
    {
        return '
            <button type="button" class="paginacaoUI">...</button>
        <button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => $lpm)).'" class="paginacao paginacaoUI">'.$lpm.'</button>
        <button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => $lastpage)).'" class="paginacao paginacaoUI">'.$lastpage.'</button>
        ';
    }

    protected static function oneTwo($route)
    {
        return '
            <button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => 1)).'" class="paginacao paginacaoUI">1</button>
        <button type="button" data-pagina="'.static::buildUrl($route,array('pagina' => 2)).'" class="paginacao paginacaoUI">2</button>
        <button type="button" class="paginacaoUI">...</button>
        ';
    }

    public static function buildUrl($route,$params)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
        if(is_object(static::$merge))$result = array_merge($params, static::$merge->getRawValue());
        elseif(is_array(static::$merge))$result = array_merge($params, static::$merge);
        else $result=$params;
        return url_for($route,$result);
    }
}