<?php
if ($pager->haveToPaginate()):
    $xtras = isset($xtras) ? $xtras : array();
    $pagination=Pagination::show($pager->getPage(), $pager->getLastPage(), $route, $xtras);
    echo $pagination;
endif;
