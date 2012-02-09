<?php $this->addStylesheet( '/insomnia/css/basic.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/layout.css' ); ?>
<?php $this->addStylesheet( '/insomnia/css/insomnia.css' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Droid+Serif' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=PT+Sans' ); ?>
<?php $this->addScript( 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' ); ?>
<?php //$this->addScript( 'http://cdn.jquerytools.org/1.2.6/jquery.tools.min.js' ); ?>
<html>
    <head>
        <title><?= $this->getTitle(); ?></title>
        <?php $this->printStylesheetsAsHtml(); ?>
        <?php $this->printScriptsAsHtml(); ?>
    </head>
    <body>
        <?php echo $this->getView()->getOutput(); ?>
        <?php if( defined( 'APPLICATION_ENV' ) && \APPLICATION_ENV === 'development' ): ?>
            <div class="footer">
                <a href="/" class="home" title="Home">&nbsp;<span>Home</span></a>
                <a href="/client" class="client" title="Client">&nbsp;<span>Client</span></a>
                <a href="/doc/routes" class="routes" title="Routes">&nbsp;<span>Routes</span></a>
                <a href="/ping" class="ping" title="Ping">&nbsp;<span>Ping</span></a>
                <a href="/doc" class="docs" title="Documentation">&nbsp;<span>Documentation</span></a>
                <a href="/doc/modules" class="modules" title="Modules">&nbsp;<span>Modules</span></a>
                <a href="/example" class="examples" title="Examples">&nbsp;<span>Examples</span></a>
            </div>
        <?php endif; ?>
    </body>
</html>