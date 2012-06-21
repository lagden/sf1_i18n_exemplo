<?php if ($category): ?>
    <h1><?php echo __('Categoria'); ?>: <?php echo $category->name ?></h1>
    <h2><?php echo __('Produtos'); ?></h2>
    <ul>
    <?php foreach ($category->Products as $product): ?>
        <li>
            <strong><?php echo $product->name ?></strong><br>
            <?php echo link_to(__('detalhe'), 'produto_show', array('route'=>$product->slug_route)) ?>
        </li>
    <?php endforeach ?>
    </ul>
    <p><?php echo link_to(__('Voltar'), 'homepage') ?></p>
<?php else: ?>
    <?php echo __('Categoria não encontrada'); ?>
<?php endif ?>
