<style type="text/css">
    fieldset {
        font-family: Arial, Helvetica;
        border: dotted 1px #9A9A9A;
    }
    
    fieldset legend {
        border: dotted 1px #9A9A9A;
        padding: 5px 15px;
    }
    
    p.pattern {
        display: block;
        padding: 5px 15px;
        width: 300px;
        background-color: #EFEFEF;
    }
    
    table.params {
        border-collapse: collapse;
        width: 330px;
        border: solid 1px #EFEFEF;
    }
    
    table.params tr td {
        border: solid 1px #EFEFEF;
        padding: 5px 10px;
    }
    
    table.params tr td.name {
        width: 120px;
        background-color: #EFEFEF;
        border-bottom-color: #fff;
    }
    
    table.params tr td.type {
        font-style: italic;
        color: #222;
        text-align: center;
    }
    
    table.params tr td.optional {
        text-align: center;
    }
    
</style>

<?php foreach( $this as $categoryName => $category ): ?>
    <fieldset>
        <legend><?= $categoryName; ?></legend>
        <?php foreach( $category as $route ): ?>
            <fieldset>
                <legend><?= $route['title']; ?></legend>
                <?php foreach( $route['methods'] as $method ): ?>
                    <p class="pattern"><?= $method . ' ' . $route['pattern']; ?></p>
                <?php endforeach; ?>    
                <p><?= $route['description']; ?></p>
                <?php if( !empty( $route['params'] ) ): ?>
                    <table class="params">
                        <?php foreach( $route['params'] as $param ): ?>
                            <tr>
                                <td class="name"><?= isset( $param['name'] ) ? $param['name'] : ''; ?></td>
                                <td class="type"><?= isset( $param['type'] ) ? $param['type'] : ''; ?></td>
                                <td class="optional"><?= isset( $param['optional'] ) && $param['optional'] == 'true' ? 'optional' : 'required'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </fieldset>
        <?php endforeach; ?>
   </fieldset>
<?php endforeach; ?>