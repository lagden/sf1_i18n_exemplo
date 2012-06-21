<!-- Termo solicitado na busca -->
<div class="termo"> 
    <p><?php echo __('Sua pesquisa pelo termo "%q%" apresentou os seguintes resultados...', array('%q%' => $busca)) ?></p>
</div>

<!-- Resultado -->
<div class="results">
    <?php $results = $pager->getResults() ?>
    <?php if ($results->count() > 0): ?>
        <?php foreach ($results as $result): ?>
            <div class="itens">
                <h3><?php echo $result->name ?></h3>
                <p><?php echo $result->description ?></p>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</div>

<!-- Paginação -->
<div class="pagination">
    <?php include_partial('global/pagination', array('pager' => $pager, 'route' => 'busca_filtro_page')); ?>
</div>
