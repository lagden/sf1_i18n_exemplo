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

    <style type="text/css">
        body{
          font-size: 100%;
          font-family: Helvetica, sans-serif;
        }
        .item:nth-child(odd)
        {
          padding: 1em;
          background-color: #f1f1f1;
        }
        .pagination {
          text-align: center;
          color: #999;
        }
        .pagination span {
          display: none;
        }
        .pagination button.paginacaoUI {
          font-size: 1rem;
          border: 0;
          outline: none;
          background: none;
          padding: .2em;
          margin-right: .1em;
          color: #999;
          font-weight: bold;
          width: 1.5em;
          height: 1.5em;
        }
        .pagination button.paginacaoUI:hover {
          background-color: #333;
          color: #FFF;
        }
        .pagination button.paginacaoSelecionado {
          color: red;
        }
        .pagination .paginacaoDisabled {
          opacity: 0.3;
          filter: alpha(opacity=30);
        }
    </style>
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
