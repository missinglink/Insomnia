<?php

    $this->setTitle( 'Html Entities - Character Entity Reference' );

?><div id="outer">
    <h1 style="font-family: 'Delius', sans-serif;">Character Entity Reference</h1>
    <br /><hr />
    <div id="el"><?php foreach( $this->data as $data ):
        ?><div><div><?php
                if( isset( $data[ 'character' ] ) ):
                    ?><p><a href="<?php echo $data[ 'uri' ]; ?>.html"><?php echo $data[ 'character' ]; ?></a></p><?php
                endif;
            ?></div><?php
                if( isset( $data[ 'name' ] ) ):
                    ?><p><a href="<?php echo $data[ 'uri' ]; ?>.html"><?php echo $data[ 'name' ]; ?></a></p><?php
                endif;
        ?></div><?php 
     endforeach; ?></div>
    <hr />
    <p>This content is available in the following formats:</p>
    <a href="/example/entity.xml">Xml</a>
    <a href="/example/entity.json">Json</a>
    <a href="/example/entity.ini">Ini</a>
    <a href="/example/entity.yaml">Yaml</a>
</div>