<?php $this->addStylesheet( '/css/basic.css' ); ?>
<?php $this->addStylesheet( '/css/layout.css' ); ?>
<?php $this->addScript( '/js/google-tracker.js' ); ?>
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