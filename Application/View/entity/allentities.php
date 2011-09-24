<?php $this->setTitle( 'Html Entities - Character Entity Reference' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Delius' ); ?>

<style type="text/css">
    body {
        background-color: none;
        background-image: url( 'http://peter.john.so/n/bg.jpg' );
        background-repeat: repeat-x;
    }
</style>

<div style="padding:50px;">
    
    <h1 style="font-family: 'Delius', sans-serif;">Character Entity Reference</h1>
    <br />
    <hr />
    
    <?php foreach( $this->data as $data ): ?>

        <div style="float:left; width:4em; text-align:center; margin-right:10px;">

            <div style="width:4em; height:4em; border:dotted 1px #ddd; margin:auto; margin-bottom:5px; text-align: center; background-color:#fff;">
                <?php if( isset( $data[ 'character' ] ) ): ?>
                    <p style="font-size:3em; line-height:1.35em;">
                        <a href="<?php echo $data[ 'uri' ]; ?>.html" style="text-decoration:none; color: #000;"><?php echo $data[ 'character' ]; ?></a>
                    </p>
                <?php endif; ?>
            </div>

            <?php if( isset( $data[ 'name' ] ) ): ?>
            <p style="clear:both;">
                <a href="<?php echo $data[ 'uri' ]; ?>.html" style="text-decoration:none;"><?php echo $data[ 'name' ]; ?></a>
            </p>
            <?php endif; ?>

        </div>
    
    <?php endforeach; ?>
    
    <div style="clear:both;">&nbsp;</div>
    
    <hr />
    
    <p>This content is available in the following formats:</p>
    <a href="/entity.xml">Xml</a>
    <a href="/entity.json">Json</a>
    <a href="/entity.ini">Ini</a>
    <a href="/entity.yaml">Yaml</a>
    
</div>