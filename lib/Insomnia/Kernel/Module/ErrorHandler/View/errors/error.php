<?php 
    function renderNamespace( $fullNamespace )
    {
        $split = explode( "\\", $fullNamespace );

        $class = array_pop( $split );
        $namespace = implode( "\\", $split ) . "\\";

        return '<span class="namespace" style="display:none;">'.$namespace.'</span><span style="font-weight:bold;">'.$class.'</span>';
    }
    
    function renderFilePath( $path )
    {
        $split = explode( "/", $path );

        $file = array_pop( $split );
        $dir = implode( "/", $split ) . "/";

        return '<span class="namespace" style="display:none;">'.$dir.'</span><span style="font-weight:bold;">'.$file.'</span>';
    }
    
    function renderFileView( $filePath, $line, $padding = 10 )
    {
        echo renderFilePath( $filePath ) . ':' . $line;
        echo '<pre style="padding: 1px; border:solid 1px black; overflow: hidden;"><code style="display:block; background-color: black; color: #aaa; font-size: 14px; font-family:sans-serif;">';
        
        if( !file_exists( $filePath ) || !is_readable( $filePath ) )
        {
            echo ' Failed to load file.' . PHP_EOL;
        }
        
        else
        {
            $file = file_get_contents( $filePath );
            $split = explode( PHP_EOL, $file );

            $range = array_slice( $split, $line -$padding -1, ( $padding * 2 ) +1, true );

            foreach( $range as $key => $item )
            {
                $isErrorLine = ( ( $key +1 ) == $line );

                if( $isErrorLine ) echo '<span style="color:white;">';
                echo str_pad( $key +1, 4, ' ', \STR_PAD_LEFT );

                echo "\t" . $item;
                if( $isErrorLine ) echo '</span>';

                echo PHP_EOL;
            }
        }
        
        echo '</code></pre>';
    }
?>   
<div style="margin:50px;">
    <img src="/images/logo.jpg" style="display:block; float:left;" />
    <div style="display:block; float:left; padding:5px 0px 0px 45px;">
        <h1 class="error"><?= $this['status']; ?></h1>
        <h4><?= $this['title']; ?></h4>
        <?php if( !empty( $this['body'] ) ): ?> 
            <p style="clear:both;"><?= $this['body']; ?>.</p>
        <?php endif; ?>
    </div>
    <?php if( isset( $this['errors'] ) ): ?>
        <hr />
        <table style="width:100%;">
            <thead>
                <th class="error">Param</th>
                <th class="error">Error</th>
            </thead>
            <?php foreach( $this['errors'] as $id => $error ): ?>
                <tr>
                    <th style="width:150px;" class="error"><?= $id; ?></th>
                    <td class="error"><?= $error; ?></td>
                <tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
        
    <?php if( isset( $this['debug'] ) ): ?>
        <hr />
        <table style="width:100%;">
            <?php if( !empty( $this['debug']['message'] ) ): ?>    
                </tr>
                    <th>Message</th>
                    <td>
                        <?= $this['debug']['message']; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <th style="width:150px;">Exception</th>
                <td>
                    <?= renderNamespace( $this['debug']['exception'] ); ?>
                    <div style="float:right">
                        <a id="toggle" style="text-decoration: none;" href="#" onclick="return false;">Verbose</a>
                    </div>
                </td>
            <tr>
            </tr>
                <th>File</th>
                <td>
                    <?= renderFilePath( $this['debug']['file'] ); ?>:<?= $this['debug']['line']; ?>
                    <div style="float:right">
                        <a id="codetoggle" style="text-decoration: none;" href="#" onclick="return false;">Source</a>
                    </div>
                </td>
            <tr>
        </table>
    <?php endif; ?>
    <?php if( isset( $this['debug']['previous'] ) ): ?>
        <table style="width:100%;">
            <?php if( !empty( $this['debug']['previous']['message'] ) ): ?>
                </tr>
                    <th>Message</th>
                    <td><?= $this['debug']['previous']['message']; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th style="width:150px;">Exception</th>
                <td><?= $this['debug']['previous']['exception']; ?></td>
            <tr>
            </tr>
                <th>File</th>
                <td><?= renderFilePath( $this['debug']['previous']['file'] ); ?>:<?= $this['debug']['previous']['line']; ?></td>
            <tr>
        </table>
    <?php endif; ?>
   
    <?php if( isset( $this['debug'] ) ): ?>
        <div id="codeView" style="display:none;">
            <hr />
            <?php renderFileView( $this['debug']['file'], $this['debug']['line'] ); ?>
        </div>
    <?php endif; ?>
        
    <?php if( isset( $this['debug']['backtrace'] ) ): ?>
            
        <hr />
        
        <ol style="width:100%; padding:0px;"><?php
           foreach( $this['debug']['backtrace'] as $trace )
           {
               if( isset( $trace['exception'] ) )
               {                   
                   echo '<li><em class="error">';
                   echo renderNamespace( get_class( $trace['exception'] ) ) . '( <span>' . $trace['exception']->getMessage() . '</span> )';
                   
                   $file = $trace['exception']->getFile();
                   $line = $trace['exception']->getLine();
                   
                   if( !empty( $file ) && !empty( $line ) )
                        echo ' in ' . renderFilePath( $file ) . ':' . $line . PHP_EOL;
                   
                   echo '</em></li>';
               }
               else
               {
                   echo '<li><em>';
                   
                   $args = '';
                   
                   if( isset( $trace['args'] ) && is_array( $trace['args'] ) )
                   {
                       foreach( $trace['args'] as $arg )
                       {
                           if( is_object( $arg ) )
                           {
                               $args .= '<span style="">object</span> ' . renderNamespace( get_class( $arg ) ) . ', ';
                           }
                       }
                       
                       $args = substr( $args, 0, -2 );
                   }
                   
                   echo ( isset( $trace['class'] ) ? renderNamespace( $trace['class'] ) . '::' : '' ) . $trace['function'] . '( ' . $args . ' )';

                   if( isset( $trace['file'], $trace['line'] ) )
                        echo ' in ' . renderFilePath( $trace['file'] ) . ':' . $trace['line'] . PHP_EOL;
                   
                   echo '</em></li>';
               }
           };
        ?></ol>
    <?php endif; ?>
    <?php if( isset( $this['debug']['routes'] ) ): ?>
        <!--<hr />
        <strong>Controllers</strong>
        <ol style="width:100%; padding:0px;"><?php
           foreach( $this['debug']['routes'] as $route )
           {
               echo '<li><em>';
               echo $route;
               echo '</em></li>';
           };
        ?></ol>-->
    <?php endif; ?>
    
    <hr />
    <a href="/doc" style="text-decoration:none;">Web Service Reference</a>
</div>

<?php if( isset( $this['debug'] ) ): ?>
<? $this->javascript( '/js/jquery-1.4.3.min.js' ); ?>
<script type="text/javascript">
    $("a#toggle").click(
        function ()
        {
          $.each(
            $('span.namespace'),
            function( key, value )
              {
                  if ( $(this).css( 'display' ) == 'none' )
                  {
                      $(this).val( 'Concise' );
                      $(this).css( 'display', 'inline' );
                  }

                  else
                  {
                      $(this).val( 'Verbose' );
                      $(this).css( 'display', 'none' );
                  }
              }
         )

          if ( $(this).html() == 'Concise' )
          {
              $(this).html( 'Verbose' );
          }

          else
          {
             $(this).html( 'Concise' );
          }

        return false;
       }
   );


   $("a#codetoggle").click(
        function ()
        {
          if ( $(this).html() == 'Hide' )
          {
              $(this).html( 'Source' );
              $('div#codeView').hide();
          }

          else
          {
             $(this).html( 'Hide' );
             $('div#codeView').show();
          }
        }
   );
</script>
<?php endif; ?>