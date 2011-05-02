<? $this->css( '/css/basic.css' ); ?>
<html>
    <head>
        <title><?= $this['title']; ?></title>
        <? $this->css(); ?>
        <? $this->javascript(); ?>
    </head>
    <body>
        <?= $this->content(); ?>
    </body>
</html>