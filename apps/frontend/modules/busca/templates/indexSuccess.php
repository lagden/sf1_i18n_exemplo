<!-- Termo solicitado na busca -->
<div class="termo"> 
    <p><?php echo __('Sua pesquisa pelo termo "%q%" apresentou os seguintes resultados...', array('%q%' => $busca)) ?></p>
</div>

<?php if ($pager->count()): ?>
    <!-- Resultado -->
    <div class="results">        
        <?php $results = $pager->getResults() ?>
        <?php if ($results->count() > 0): ?>
            <?php foreach ($results as $result): ?>
                <div class="itens">
                    <h3><?php echo "{$result->name} | id: {$result->id}" ?></h3>
                    <p>
                        <?php
                        try { echo "{$result->description}</p>"; }
                        catch (Exception $e) { echo __("Sem descrição"); }
                        ?>
                    </p>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <!-- Paginação -->
    <div class="pagination">
        <?php include_partial('global/pagination', array('pager' => $pager, 'route' => 'busca_filtro_page')); ?>
    </div>
<?php else: ?>
    <!-- No results -->
    <div class="noResults">
        <?php echo __('Xiiii... Marquinhos!!!') ?>
    </div>
<?php endif ?>