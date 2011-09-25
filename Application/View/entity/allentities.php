<?php $this->setTitle( 'Html Entities - Character Entity Reference' ); ?>
<?php $this->addStylesheet( '/css/entity.css' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Delius' ); ?>

<div id="outer">
    
    <h1 style="font-family: 'Delius', sans-serif;">Character Entity Reference</h1>
    <br />
    <hr />
    
    <?php foreach( $this->data as $data ): ?>

        <div id="entity-list">

            <div class="entity">
                <?php if( isset( $data[ 'character' ] ) ): ?>
                    <p class="font">
                        <a href="<?php echo $data[ 'uri' ]; ?>.html"><?php echo $data[ 'character' ]; ?></a>
                    </p>
                <?php endif; ?>
            </div>

            <?php if( isset( $data[ 'name' ] ) ): ?>
            <p class="info">
                <a href="<?php echo $data[ 'uri' ]; ?>.html"><?php echo $data[ 'name' ]; ?></a>
            </p>
            <?php endif; ?>

        </div>
    
    <?php endforeach; ?>
    
    <hr />
    
    <p>This content is available in the following formats:</p>
    <a href="/entity.xml">Xml</a>
    <a href="/entity.json">Json</a>
    <a href="/entity.ini">Ini</a>
    <a href="/entity.yaml">Yaml</a>
    
</div>