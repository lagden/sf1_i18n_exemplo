<?php if ($product): ?>
    <p><strong><?php echo $product->name ?></strong></p>
    <p><strong><?php echo $product->description ?></strong></p>
    <p><strong><?php echo $product->price ?></strong></p>
<?php else: ?>
    :(
<?php endif ?>

<?php include_partial('global/lang'); ?>
