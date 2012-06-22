<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="frmBusca">
    <?php
    $rota = url_for($route);
    echo $form->renderFormTag($rota, array('method' => 'post', 'class' => 'frmBusca', 'id'=>'frmBusca', 'data-url'=>$rota));
    $form->setDefault('q','');
    echo $form['q']->render(array('placeholder' => __('Buscar no site'),));
    ?>
    </form>
</div>
