<?php $this->addStylesheet( '/insomnia/css/basic.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/layout.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/insomnia.css' ); ?>
<html>
    <head>
        <title><?= $this->getTitle(); ?></title>
        <?php $this->printStylesheetsAsHtml(); ?>
        <?php $this->printScriptsAsHtml(); ?>
    </head>
    <body>
        <?php echo $this->getView()->getOutput(); ?>
    </body>
</html>