<?php $this->setTitle( 'Html Entity - ' . ucfirst( $this->data[ 'description' ] ) ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Delius' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Montez' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Leckerli+One' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=400italic' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Cardo' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Nobile' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Molengo' ); ?>
<?php $this->addStylesheet( 'http://fonts.googleapis.com/css?family=Josefin+Sans' ); ?>

<?php $fonts = array(
    'sans-serif',
    'serif',
    'monospace',
    'cursive',
    'fantasy',
    'Montez',
    //'Leckerli+One',
    'Delius',
    //'400italic',
    'Times New Roman',
    'Arial',
    //'Cardo',
    'Josefin Sans',
    'Yanone Kaffeesatz',
    'Nobile',
    'Molengo',
    
); ?>

<style type="text/css">
    body {
        background-color: none;
        background-image: url( 'http://peter.john.so/n/bg.jpg' );
        background-repeat: repeat-x;
    }
</style>

<div style="padding:50px;">
    
    <div style="width:8em; height:8em; border:solid 1px #ddd; padding:0px; margin-bottom:25px; text-align: center; float:left; background-color: #fff;">
        <?php if( isset( $this->data[ 'character' ] ) ): ?>
            <p style="font-size:7em; line-height:1.15em;"><?php echo $this->data[ 'character' ]; ?></p>
        <?php endif; ?>
    </div>
    
    <div style="display:block; float:left; padding:5px 0px 0px 30px;">
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
    

    <hr style="margin-bottom:5px;" />
    
        <p style="margin-bottom:0px;">
            <a href="/" style="text-decoration:none;">Character Entity Reference</a>
            &raquo;
            <?php echo ucfirst( $this->data[ 'name' ] ); ?>
        </p>

    <hr style="margin-top:5px;" />

    <table style="width:100%">

        <tr>
        <?php if( isset( $this->data[ 'name' ] ) ): ?>
            <th width="300">Entity Name</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'name' ]; ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'character' ] ) ): ?>
            <th>Character</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'character' ]; ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'htmlentity' ] ) ): ?>
            <th>HTML Entity</th>
            <td style=" background-color:#fff;"><?php echo htmlentities( $this->data[ 'htmlentity' ] ); ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'ascii' ] ) ): ?>
            <th>Ascii</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'ascii' ]; ?></td>
        <?php endif; ?>
        </tr>
        
        <tr>
        <?php if( isset( $this->data[ 'unicode' ] ) ): ?>
            <th>Unicode code point (decimal)</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'unicode' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'standard' ] ) ): ?>
            <th>Standard</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'standard' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'dtd' ] ) ): ?>
            <th>DTD</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'dtd' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'subset' ] ) ): ?>
            <th>Old ISO subset</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'subset' ]; ?></td>
        <?php endif; ?>
        </tr>
        <tr>
        <?php if( isset( $this->data[ 'description' ] ) ): ?>
            <th>Description</th>
            <td style=" background-color:#fff;"><?php echo $this->data[ 'description' ]; ?></td>
        <?php endif; ?>
        </tr>

        <tr>
        <?php if( isset( $this->data[ 'htmlentity' ] ) ): ?>
            <th>Example</th>
            <td style=" background-color:#fff;"><?php echo htmlentities( '<p>' . $this->data[ 'htmlentity' ] . '</p>' ); ?></td>
        <?php endif; ?>
        </tr>

    </table>
   
    <hr style="clear:both;" />
    
    <?php if( isset( $this->data[ 'character' ] ) ): ?>
        <?php foreach( $fonts as $font ): ?>
            <div style="width:4em; height:4em; padding:0px; margin-bottom:25px; margin-right:5px; text-align: center; float:left; background-color: #fff;">
                <p style="font-size:3em; line-height:1.3em; font-family: '<?= $font; ?>', sans-serif;"><?php echo $this->data[ 'character' ]; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <hr style="clear:both;" />
    
    <p>This content is available in the following formats:
    <a href="<?php echo $this->data[ 'uri' ]; ?>.xml">xml</a>
    <a href="<?php echo $this->data[ 'uri' ]; ?>.json">json</a>
    <a href="<?php echo $this->data[ 'uri' ]; ?>.ini">ini</a>
    <a href="<?php echo $this->data[ 'uri' ]; ?>.yaml">yaml</a></p>

</div>