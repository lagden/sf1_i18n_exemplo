<!-- Termo solicitado na busca -->
<div class="termo"> 
    <p><?php echo __('Sua pesquisa pelo termo "%q%" apresentou os seguintes resultados...', array('%q%' => $busca)) ?></p>
</div>

<?php if ($pager->count()): ?>
    <!-- Resultado -->
    <div class="results">        
        <!-- $pager = $sf_data->getRaw('pager'); -->
        <?php foreach ($pager as $result): ?>
            <div class="itens">
                <h3><?php echo "{$result->getRaw('name')} | id: {$result->getRaw('id')} | score: {$result->getRaw('score')}" ?></h3>
                <h2><?php echo link_to($result->getRaw('name'),$result->getRaw('rota'),array('route'=>$result->getRaw('route'))) ?></h2>
                <p><?php echo "{$result->getRaw('description')}" ?></p>
            </div>
        <?php endforeach ?>
    </div>
    <!-- Paginação -->
    <div class="pagination">
        <?php // include_partial('global/pagination', array('pager' => $pager, 'route' => 'full_busca_filtro_page')); ?>
    </div>
<?php else: ?>
    <!-- No results -->
    <div class="noResults">
        <?php echo __('Xiiii... Marquinhos!!!') ?>
    </div>
<?php endif ?>
