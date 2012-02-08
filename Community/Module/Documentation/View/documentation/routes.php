<?php

    function dummyData( $regex )
    {
        $simple = preg_replace( '_\?P\<(?:.*)\>_', '', $regex );
        $regex = str_replace( "(.+)", 'a', $simple );
        $regex = str_replace( '(\d+)', '1', $regex );
        return $regex;
    }

?><div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error icon" style="background-image: url('/insomnia/icon/android/ic_menu_compass.png');">Routes</h1>
            <h4>Webservice Endpoints and Parameters</h4>
            <p>Current: <?= date( 'r' ); ?></p>
        </div>
    </div>
    <div style="position:fixed; top:80px; right:30px; padding:5px 20px;">
        <?php foreach( $this as $categoryName => $category ): ?>
        <a href="#<?php echo $categoryName ?>"><p style="margin:5px 0 5px 0;"><?= $categoryName; ?> (<?php echo count( $category ) ?>)</p></a>
        <?php endforeach; ?>
    </div>
    <div>
        <?php foreach( $this as $categoryName => $category ): ?>
            <h4 id="<?php echo $categoryName ?>"><?= $categoryName; ?></h4>
            <br />
            <?php foreach( $category as $route ): ?>
                <div class="insomnia-documentation-block" style="margin-bottom:40px;">

                    <h3 class="icon" style="background-image: url('/insomnia/icon/android/ic_menu_replace.png');"><?php echo implode( ', ', $route['methods'] ); ?> <?php echo $route['pattern']; ?></h3>
                    
                    <table style="background-color:#fff;">
                        <?php foreach( $route as $paramKey => $paramValue ): ?>
                            <?php if( $paramKey === 'params' ): continue ?>
                            <?php elseif( $paramKey === 'pattern' ): ?>
                                <tr>
                                    <th>URL Structure</th>
                                    <td>
                                        <?php $url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . htmlentities( dummyData( $route['patternRegex'] ) ) . '.json'; ?>
                                        <a href="<?php echo $url; ?>"><?php echo $url; ?></a>
                                    </td>
                                </tr>
                            <?php elseif( $paramKey === 'patternRegex' ): ?>
                                <tr>
                                    <th style="width:200px;"><?php echo 'Match Pattern'; ?></th>
                                    <td><?php echo htmlentities( preg_replace( '_\?P\<(?:.*)\>_', '', $route['patternRegex'] ) ); ?></td>
                                </tr>
                            <?php elseif( $paramKey === 'methods' ): ?>
                                <tr>
                                    <th><?php echo ucfirst( $paramKey ); ?></th>
                                    <td><?php echo implode( ', ', $route['methods'] ); ?></td>
                                </tr>
                            <?php elseif( !empty( $paramValue ) ): ?>
                                <tr>
                                    <th><?php echo ucfirst( $paramKey ); ?></th>
                                    <td><?php echo htmlentities( $paramValue ); ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach; ?>
                        <tr>
                            <th>cURL Command</th>
                            <?php
                                $curlCommand = 'curl -X ' . reset( $route[ 'methods' ] );

                                if( !empty( $route['params'] ) ):
                                    foreach( $route['params'] as $param ):
                                       $curlCommand .= ' -d "'. $param['name'] .'=<value>"';
                                    endforeach;
                                endif;

                                $curlCommand .= ' ' . 'http://' . $_SERVER[ 'HTTP_HOST' ] . $route['pattern'] . '.json';
                            ?>
                            <td><?php echo htmlentities( $curlCommand ); ?></td>
                        <tr>
                    </table>

                    <?php if( !empty( $route['params'] ) ): ?>
                        <table style="border:none; border-bottom:solid 1px #ddd;">
                            <tr>
                                <?php
                                    $columns = array();
                                    foreach( $route['params'] as $param ):
                                        foreach( $param as $k => $v ):
                                            $columns[ $k ] = $k;
                                        endforeach;
                                    endforeach;
                                ?>

                                <?php foreach( $columns as $columnTitle ): ?>
                                    <th><?php echo ucfirst( $columnTitle ); ?></th>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach( $route['params'] as $param ): ?>
                                <tr>
                                    <?php foreach( $param as $k => $v ): ?>
                                        <td style="background-color: #fff; border:none;"><?php echo $v; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
            <div style="margin-top:30px;">&nbsp;</div>
        <?php endforeach; ?>
   </div>
</div>