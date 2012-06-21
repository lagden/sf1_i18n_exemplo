<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8">
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
<body>
    <?php include_partial('global/header'); ?>
    <?php echo $sf_content ?>
    <?php include_partial('global/footer'); ?>

    <?php echo javascript_include_tag('vendor/jquery.js'); ?>
    <script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"><\/script>')</script>
    <script type="text/javascript">
    jQuery.fn.ready(function(){
        // Paginação
        jQuery('button.paginacao').live('click',function(e){
            var go = jQuery(this).data('pagina');
            if(go) location=go;
        });
    }); 
    </script>
</body>
</html>
