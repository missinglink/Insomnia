<div style="margin:50px;">
    <img src="/images/logo.jpg" style="display:block; float:left;" />
    <div style="display:block; float:left; padding:5px 0px 0px 45px;">
        <h1 class="error"><?php echo \Insomnia\Response\Code::HTTP_OK; ?></h1>
        <h4>The request has succeeded</h4>
        <p style="clear:both;">An HTML view for this content is not available.</p>
    </div>
    <hr />
    <p style="clear:both;">This content is available in the following formats:</p>
    <a href="<?php echo \Insomnia\Registry::get( 'request' )->getUri(); ?>.xml">XML</a>
    <a href="<?php echo \Insomnia\Registry::get( 'request' )->getUri(); ?>.json">JSON</a>
    <a href="<?php echo \Insomnia\Registry::get( 'request' )->getUri(); ?>.ini">INI</a>
    <a href="<?php echo \Insomnia\Registry::get( 'request' )->getUri(); ?>.yaml">YAML</a>
    <a href="<?php echo \Insomnia\Registry::get( 'request' )->getUri(); ?>.txt">TXT</a>
    <br /><br />
    <hr />
    <a href="/doc" style="text-decoration:none;">Web Service Reference</a>
</div>