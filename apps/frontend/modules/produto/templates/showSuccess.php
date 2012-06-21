<?php if ($product): ?>
    <p><strong><?php echo $product->name ?></strong></p>
    <p><strong><?php echo $product->description ?></strong></p>
    <p><strong><?php echo $product->price ?></strong></p>
    <p><?php echo link_to(__('Voltar'), 'categoria_show', array('route'=>$product->Category->slug_route)) ?></p>
<?php else: ?>
    :(
<?php endif ?>

