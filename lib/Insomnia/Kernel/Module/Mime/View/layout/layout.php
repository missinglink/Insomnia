<?php $this->addStylesheet( '/insomnia/css/basic.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/layout.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/insomnia.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/insomnia-documentation.css' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Droid+Serif' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=PT+Sans' ); ?>
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