<?php if ($category): ?>
    <?php echo __('Categoria'); ?> <strong><?php echo $category->name ?></strong>
    <ul>
    <?php foreach ($category->Products as $product): ?>
        <li>
            <strong><?php echo $product->name ?></strong><br>
            <?php echo link_to(__('detalhe'), 'produto_show', array('slug'=>$product->slug)) ?>
        </li>
    <?php endforeach ?>
    </ul>
<?php else: ?>
    <?php echo __('Categoria não encontrada'); ?>
<?php endif ?>

<?php include_partial('global/lang'); ?>