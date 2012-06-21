<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="frmBusca">
    <?php
    $rota = url_for('busca_filtro');
    echo $form->renderFormTag($rota, array('method' => 'post', 'class' => 'frmBusca', 'id'=>'frmBusca', 'data-url'=>$rota));
    $form->setDefault('q','');
    echo $form['q']->render();
    echo content_tag('button', '<i class="icon-search"></i>Busca', array('type' => 'submit'));
    ?>
    </form>
</div>
