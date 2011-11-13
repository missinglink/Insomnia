<div style="margin:50px;">
    <img src="/insomnia/images/logo.jpg" style="display:block; float:left;" />
    <div style="display:block; float:left; padding:5px 0px 0px 45px;">
        <h1 class="error">Webservice Documentation</h1>
        <h4>Documentation Index</h4>
        <p style="clear:both;">Current: <?= date( 'r' ); ?></p>
    </div>
    <div style="clear:both;"></div>
    <?php foreach( $this[ 'directory' ] as $key => $value ): ?>
        <hr />
        <a href="<?= $value; ?>"><?= $key; ?></a>
        <br /><br />
    <?php endforeach; ?>
    <hr />
</div>