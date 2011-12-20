<div class="insomnia">
    <div class="insomnia-error-header">
        <h1 class="insomnia-logo">Insomnia</h1>
        <div class="insomnia-title">
            <h1 class="error">Reference</h1>
            <h4>Webservice Documentation</h4>
            <p>Current: <?= date( 'r' ); ?></p>
        </div>
    </div>
    <div class="insomnia-documentation">
        <?php foreach( $this as $categoryName => $category ): ?>
            <h4><?= $categoryName; ?></h4>
            <br />
            <?php foreach( $category as $route ): ?>
                <div class="insomnia-documentation-block posh">
                    <strong><?= $route['title']; ?></strong>
                    <br /><br />
                    <?php if( strlen( $route['description'] ) ): ?>
                        <em><?= $route['description']; ?></em>
                        <br /><br />
                    <?php endif; ?>

                    <?php foreach( $route['methods'] as $method ): ?>
                        <p style="margin-bottom:5px;">
                            <span class="insomnia-documentation-http-method"><?= $method; ?></span>
                            <span class="insomnia-documentation-http-uri">
                                <a href="<?= $route['pattern']; ?>"><?= $route['pattern']; ?></a>
                            </span>
                        </p>
                    <?php endforeach; ?>    
                    <?php if( !empty( $route['params'] ) ): ?>            
                        <table style="margin:0;">
                            <?php foreach( $route['params'] as $param ): ?>
                                <tr>
                                    <td style="width:150px; background-color: #fff;" class="error"><?= isset( $param['name'] ) ? $param['name'] : ''; ?></td>
                                    <td style="background-color: #fff;" class="type"><?= isset( $param['type'] ) ? $param['type'] : ''; ?></td>
                                    <td style="background-color: #fff;" class="optional"><?= isset( $param['optional'] ) && $param['optional'] == 'true' ? 'optional' : 'required'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <br /><br /><br />
        <?php endforeach; ?>
   </div>
</div>