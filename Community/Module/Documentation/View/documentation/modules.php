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
        <h1 class="error">List of loaded modules</h1>
        <h4>Webservice documentation</h4>
        <p style="clear:both;">Current: <?= date( 'r' ); ?></p>
    </div>
    <?php foreach( $this as $moduleName => $module ): ?>
        <h4 style="background-color: #dedede; padding: 5px 20px; margin:0px;"><?= $moduleName; ?></h4>
        <ul style="padding:20px 30px; margin-bottom:20px; background-color: #efefef;">
            <?php foreach( $module as $pluginType => $plugin ): ?>
                <li style="font-weight: bold; list-style: none; margin-left:0; margin-top:10px;"><?= $pluginType; ?><ul>
                <?php foreach( $plugin as $pluginClass ): ?>
                    <li style="font-weight: normal;"><?= $pluginClass; ?></li>
                <?php endforeach; ?>
                </ul></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</div>