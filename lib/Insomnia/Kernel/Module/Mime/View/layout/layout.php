<?php $this->addStylesheet( '/css/basic.css' ); ?>
<?php $this->addStylesheet( '/css/layout.css' ); ?>
<html>
    <head>
        <title><?= $this['title']; ?></title>
        <?php $this->printStylesheetsAsHtml(); ?>
        <?php $this->printScriptsAsHtml(); ?>
    </head>
    <body>
        <?php echo $this->getView()->getOutput(); ?>
    </body>
</html>