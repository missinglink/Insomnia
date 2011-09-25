<?php $this->setTitle( 'Html Entity - ' . ucfirst( $this->data[ 'description' ] ) ); ?>
<?php $this->addStylesheet( '/css/entity.css' ); ?>

<?php $fonts = array(
    'sans-serif',
    'serif',
    'monospace',
    'cursive',
    'fantasy',
    'Montez',
    'Delius',
    'Times New Roman',
    'Arial',
    'Josefin Sans',
    'Yanone Kaffeesatz',
    'Nobile',
    'Molengo',
    
); ?>

<div id="outer">
    
    <div id="entity-large">
        <?php if( isset( $this->data[ 'character' ] ) ): ?>
            <p><?php echo $this->data[ 'character' ]; ?></p>
        <?php endif; ?>
    </div>
    
    <div id="entity-info">
        <?php if( isset( $this->data[ 'name' ] ) ): ?>
            <h1 class="error" style="font-family: 'Delius', sans-serif;"><?php echo ucfirst( $this->data[ 'name' ] ); ?></h1>
        <?php endif; ?>
        <?php if( isset( $this->data[ 'description' ] ) ): ?>
            <h4><?php echo ucfirst( $this->data[ 'description' ] ); ?></h4>
        <?php endif; ?>
        
        <p style="clear:both;">
            
            <?php if( isset( $this->data[ 'uri' ] ) ): ?>
                <a href="<?php echo $this->data[ 'uri' ]; ?>.html" style="text-decoration:none;">Entity <?php echo ucfirst( $this->data[ 'name' ] ); ?> ( <?php echo $this->data[ 'character' ]; ?> )</a>
            <?php endif; ?>
            
        </p>
         
    </div>
    

    <hr style="margin-bottom:0px;" />
    
        <p class="breadcrumbs">
            <a href="/">Character Entity Reference</a>
            &raquo;
            <?php echo ucfirst( $this->data[ 'name' ] ); ?>
        </p>

    <hr  />

    <table id="entity-properties">

        <tr>
        <?php if( isset( $this->data[ 'name' ] ) ): ?>
            <th width="300">Entity Name</th>
            <td><?php echo $this->data[ 'name' ]; ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'character' ] ) ): ?>
            <th>Character</th>
            <td><?php echo $this->data[ 'character' ]; ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'htmlentity' ] ) ): ?>
            <th>HTML Entity</th>
            <td><?php echo htmlentities( $this->data[ 'htmlentity' ] ); ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'ascii' ] ) ): ?>
            <th>Ascii</th>
            <td><?php echo $this->data[ 'ascii' ]; ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'unicode' ] ) ): ?>
            <th>Unicode code point (decimal)</th>
            <td><?php echo $this->data[ 'unicode' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'standard' ] ) ): ?>
            <th>Standard</th>
            <td><?php echo $this->data[ 'standard' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'dtd' ] ) ): ?>
            <th>DTD</th>
            <td><?php echo $this->data[ 'dtd' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'subset' ] ) ): ?>
            <th>Old ISO subset</th>
            <td><?php echo $this->data[ 'subset' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'description' ] ) ): ?>
            <th>Description</th>
            <td><?php echo $this->data[ 'description' ]; ?></td>
        <?php endif; ?>
        </tr>

        <tr>
        <?php if( isset( $this->data[ 'htmlentity' ] ) ): ?>
            <th>Example</th>
            <td><?php echo htmlentities( '<p>' . $this->data[ 'htmlentity' ] . '</p>' ); ?></td>
        <?php endif; ?>
        </tr>

    </table>
   
    <hr />
    
    <?php if( isset( $this->data[ 'character' ] ) ): ?>
        <?php foreach( $fonts as $font ): ?>
            <div class="font-example">
                <p style="font-family: '<?= $font; ?>', sans-serif;"><?php echo $this->data[ 'character' ]; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <hr />
    
    <p>This content is available in the following formats:
    <a href="<?php echo $this->data[ 'uri' ]; ?>.xml">xml</a>
    <a href="<?php echo $this->data[ 'uri' ]; ?>.json">json</a>
    <a href="<?php echo $this->data[ 'uri' ]; ?>.ini">ini</a>
    <a href="<?php echo $this->data[ 'uri' ]; ?>.yaml">yaml</a></p>

</div>