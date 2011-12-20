<?php
    if( isset( $this['debug'] ) ):
        $this->addScript( '/insomnia/js/jquery-1.4.3.min.js' );
        $this->addScript( '/insomnia/js/dev.js' );
    endif;
?>
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
<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error"><?= $this['status']; ?></h1>
            <h4><?= $this['title']; ?></h4>
            <?php if( !empty( $this['body'] ) ): ?> 
                <p><?= $this['body']; ?>.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if( isset( $this['errors'] ) ): ?>
        <table style="clear:both;">
            <thead>
                <th class="error">Param</th>
                <th class="error">Error</th>
            </thead>
            <?php foreach( $this['errors'] as $id => $error ): ?>
                <tr>
                    <th class="error"><?= $id; ?></th>
                    <td class="error"><?= $error; ?></td>
                <tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
        
    <?php if( isset( $this['debug'] ) ): ?>
        <table style="clear:both;">
            <?php if( !empty( $this['debug']['message'] ) ): ?>    
                </tr>
                    <th>Message</th>
                    <td>
                        <?= $this['debug']['message']; ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <th>Exception</th>
                <td>
                    <?= renderNamespace( $this['debug']['exception'] ); ?>
                    <div class="button">
                        <a id="toggle" href="#" onclick="return false;">Verbose</a>
                    </div>
                </td>
            <tr>
            </tr>
                <th>File</th>
                <td>
                    <?= renderFilePath( $this['debug']['file'] ); ?>:<?= $this['debug']['line']; ?>
                    <div class="button">
                        <a id="codetoggle" href="#" onclick="return false;">Source</a>
                    </div>
                </td>
            <tr>
        </table>
    <?php endif; ?>
    <?php if( isset( $this['debug']['previous'] ) ): ?>
        <table>
            <?php if( !empty( $this['debug']['previous']['message'] ) ): ?>
                </tr>
                    <th>Message</th>
                    <td><?= $this['debug']['previous']['message']; ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <th>Exception</th>
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
        
        <div class="insomnia-backtrace posh"><p style="margin:0;"><?php
           foreach( $this['debug']['backtrace'] as $trace )
           {
               if( isset( $trace['exception'] ) )
               {                   
                   echo '<em class="error">';
                   echo renderNamespace( get_class( $trace['exception'] ) ) . '( <span>' . $trace['exception']->getMessage() . '</span> )';
                   
                   $file = $trace['exception']->getFile();
                   $line = $trace['exception']->getLine();
                   
                   if( !empty( $file ) && !empty( $line ) )
                        echo ' in ' . renderFilePath( $file ) . ':' . $line . PHP_EOL;
                   
                   echo '</em>';
               }
               else
               {
                   echo '<em>';
                   
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
                   
                   echo '</em>';
               }
               
               if( end( $this['debug']['backtrace'] ) !== $trace ):
                   echo '<br />';
               endif;
           };
        ?></p></div>
    <?php endif; ?>
    <?php if( isset( $this['debug']['routes'] ) ): ?>
        <hr />
        <strong>Controllers</strong>
        <ol class="insomnia-backtrace"><?php
           foreach( $this['debug']['routes'] as $route )
           {
               echo '<li><em>';
               echo renderNamespace( $route );
               echo '</em></li>';
           };
        ?></ol>
    <?php endif; ?>
    <?php if( isset( $this['debug']['requestPlugins'] ) ): ?>
        <hr />
        <strong>Request Plugins</strong>
        <ol class="insomnia-backtrace"><?php
           foreach( $this['debug']['requestPlugins'] as $plugin )
           {
               echo '<li><em>';
               echo renderNamespace( get_class( $plugin ) );
               echo '</em></li>';
           };
        ?></ol>
    <?php endif; ?>
    <?php if( isset( $this['debug']['responsePlugins'] ) ): ?>
        <hr />
        <strong>Response Plugins</strong>
        <ol class="insomnia-backtrace"><?php
           foreach( $this['debug']['responsePlugins'] as $plugin )
           {
               echo '<li><em>';
               echo renderNamespace( get_class( $plugin ) );
               echo '</em></li>';
           };
        ?></ol>
    <?php endif; ?>
    <?php if( isset( $this['debug']['dispatcherPlugins'] ) ): ?>
        <hr />
        <strong>Dispatcher Plugins</strong>
        <ol class="insomnia-backtrace"><?php
           foreach( $this['debug']['dispatcherPlugins'] as $plugin )
           {
               echo '<li><em>';
               echo renderNamespace( get_class( $plugin ) );
               echo '</em></li>';
           };
        ?></ol>
    <?php endif; ?>
    <?php if( isset( $this['debug']['modules'] ) ): ?>
        <hr />
        <strong>Modules</strong>
        <ol class="insomnia-backtrace"><?php
           foreach( $this['debug']['modules'] as $module )
           {
               echo '<li><em>';
               echo get_class( $module );
               echo '</em></li>';
           };
        ?></ol>
    <?php endif; ?>
    
    <hr />
    <a href="/doc">Web Service Reference</a>
</div>