<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">Routes</h1>
            <h4>Webservice Endpoints and Parameters</h4>
            <p>Current: <?php echo date( 'r' ); ?></p>
        </div>
    </div>
    <div class="insomnia-documentation">
        <?php foreach( $this as $categoryName => $category ): ?>
            <h4><?php echo $categoryName; ?></h4>
            <br />
            <?php foreach( $category as $route ): ?>
                <div class="insomnia-documentation-block posh">
                       
                    <?php if( strlen( $route['description'] ) ): ?>
                        <strong><?php echo $route['description']; ?></strong>
                        <br /><br />
                    <?php endif; ?>

                    <?php foreach( $route['methods'] as $method ): ?>
                        <p style="margin-bottom:5px;">
                            <span class="insomnia-documentation-http-method"><?php echo $method; ?></span>
                            
                            <?php if( strlen( $route['title'] ) ): ?>
                                <span class="insomnia-documentation-http-title">
                                    <em><?php echo $route['title']; ?></em>
                                </span>
                            <?php endif; ?>
                            
                            <span class="insomnia-documentation-http-uri">
                                <a href="<?php echo $route['pattern']; ?>"><?php echo htmlentities( str_replace( '.*', '', $route['pattern'] ) ); ?></a>
                                <em style="float:right; padding-right:10px;"><?php echo htmlentities( preg_replace( '_\?P\<(?:.*)\>_', '', $route['patternRegex'] ) ); ?></em>
                            </span>
                        </p>
                    <?php endforeach; ?>    
                    <?php if( !empty( $route['params'] ) ): ?>            
                        <table style="margin:0;">
                            <?php foreach( $route['params'] as $param ): ?>
                                <tr>
                                    <td style="width:150px; background-color: #fff;" class="error"><?php echo isset( $param['name'] ) ? $param['name'] : ''; ?></td>
                                    <td style="background-color: #fff;" class="type"><?php echo isset( $param['type'] ) ? $param['type'] : ''; ?></td>
                                    <td style="background-color: #fff;" class="optional"><?php echo isset( $param['optional'] ) && $param['optional'] == 'true' ? 'optional' : 'required'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div style="margin-top:30px;">&nbsp;</div>
        <?php endforeach; ?>
   </div>
    <div class="footer">
        <a href="/client">Client</a>
        <a href="/doc">Documentation</a>
    </div>
</div>