<h1><?php echo __('Categorias'); ?></h1>
<?php foreach ($categories as $category): ?>
    <p><strong><?php echo $category->name ?></strong> <?php echo __('e %count% mais...', array('%count%' => link_to($category->Products->count(), 'categoria_show', ['route'=>$category->slug_route]))) ?></p>
<?php endforeach ?>
