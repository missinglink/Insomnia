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
    <img src="/images/logo.jpg" style="display:block; float:left;" />
    <div style="display:block; float:left; padding:5px 0px 0px 45px;">
        <h1 class="error">Reference</h1>
        <h4>Webservice Documentation</h4>
        <p style="clear:both;">Current: <?= date( 'r' ); ?></p>
    </div>
    <?php foreach( $this as $categoryName => $category ): ?>
        <hr />
        <h4><?= $categoryName; ?></h4>
        <?php foreach( $category as $route ): ?>
        
            <hr />
            <p><?= $route['title']; ?></p>
                
            <?php foreach( $route['methods'] as $method ): ?>
                <p class="pattern">
                    <span class="method error"><?= $method; ?></span><span class="pattern"><?= $route['pattern']; ?></span>
                </p>
            <?php endforeach; ?>    
            <?php if( !empty( $route['params'] ) ): ?>            
                <table>
                    <?php foreach( $route['params'] as $param ): ?>
                        <tr>
                            <td style="width:150px;" class="error"><?= isset( $param['name'] ) ? $param['name'] : ''; ?></td>
                            <td class="type"><?= isset( $param['type'] ) ? $param['type'] : ''; ?></td>
                            <td class="optional"><?= isset( $param['optional'] ) && $param['optional'] == 'true' ? 'optional' : 'required'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
                
            <p><?= $route['description']; ?></p>
                
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>