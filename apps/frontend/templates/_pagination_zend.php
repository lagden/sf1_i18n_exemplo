<?php
if ($pager->count() > 1):
    $xtras = isset($xtras) ? $xtras : array();
    $pagination=Pagination::show($pager->getCurrentPageNumber(), $pager->count(), $route, $xtras);
    echo $pagination;
endif;
