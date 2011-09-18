<?php $this->css( '/css/basic.css' ); ?>
<?php $this->css( '/css/layout.css' ); ?>
<html>
    <head>
        <title><?= $this['title']; ?></title>
        <?php $this->css(); ?>
        <?php $this->javascript(); ?>
    </head>
    <body>
        <?php $this->getView()->render( $this->getResponse() ); ?>
    </body>
</html>