<style type="text/css">
    
    p.pattern {
        display: block;
        width: 300px;
    }
    
    p.pattern span.method {
        margin: 0;
        padding: 5px 15px;
        width: 300px;
        border: solid 1px #ccc;
    }
    
    p.pattern span.pattern {
        margin: 0;
        padding: 5px 15px;
        width: 300px;
        border: solid 1px #ccc;
        border-left: none;
    }
    
</style>

<div style="margin:50px;">
    <img src="/insomnia/images/logo.jpg" style="display:block; float:left;" />
    <div style="display:block; float:left; padding:5px 0px 0px 45px;">
        <h1 class="error">Reference</h1>
        <h4>Webservice Documentation</h4>
        <p style="clear:both;">Current: <?= date( 'r' ); ?></p>
    </div>
    <?php foreach( $this as $categoryName => $category ): ?>
        <hr />
        <h4 style="background-color: #dedede; padding: 5px 20px; margin:0px;"><?= $categoryName; ?></h4>
        <?php foreach( $category as $route ): ?>
            <div style="padding:30px; margin-bottom:20px; background-color: #efefef;">
                <strong><?= $route['title']; ?></strong>
                <br />
                <em><?= $route['description']; ?></em>
                <br /><br />

                <?php foreach( $route['methods'] as $method ): ?>
                    <p class="pattern">
                        <span style="background-color: #fff;" class="method error"><?= $method; ?></span>
                        <span style="background-color: #fff;" class="pattern">
                            <a href="<?= $route['pattern']; ?>" style="text-decoration:none;"><?= $route['pattern']; ?></a>
                        </span>
                    </p>
                <?php endforeach; ?>    
                <?php if( !empty( $route['params'] ) ): ?>            
                    <table>
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
    <?php endforeach; ?>
</div>