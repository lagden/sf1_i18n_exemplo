<?php foreach ($categories as $category): ?>
    <p><?php echo $category->name ?> <?php echo __('e %count% mais...', array('%count%' => link_to($category->id, 'categoria_show', ['slug'=>$category->slug]))) ?></p>
<?php endforeach ?>

<?php include_partial('global/lang'); ?>