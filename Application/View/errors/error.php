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
            <tr>
                <th style="width:150px;">Exception</th>
                <td><?= $this['debug']['exception']; ?></td>
            <tr>
            </tr>
                <th>File</th>
                <td><?= $this['debug']['file']; ?>:<?= $this['debug']['line']; ?></td>
            <tr>
            <?php if( !empty( $this['debug']['message'] ) ): ?>    
                </tr>
                    <th>Message</th>
                    <td><?= $this['debug']['message']; ?></td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
    <?php if( isset( $this['debug']['previous'] ) ): ?>
        <table style="width:100%;">
            <tr>
                <th style="width:150px;">Exception</th>
                <td><?= $this['debug']['previous']['exception']; ?></td>
            <tr>
            </tr>
                <th>File</th>
                <td><?= $this['debug']['previous']['file']; ?>:<?= $this['debug']['previous']['line']; ?></td>
            <tr>
            <?php if( !empty( $this['debug']['previous']['message'] ) ): ?>
                </tr>
                    <th>Message</th>
                    <td><?= $this['debug']['previous']['message']; ?></td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
    <?php if( isset( $this['debug']['backtrace'] ) ): ?>
        <hr />
        <ol style="width:100%; padding:0px;"><?php
           foreach( \array_reverse( \debug_backtrace() ) as $trace )
           {
               echo '<li><em>';
               echo ( isset( $trace['class'] ) ? $trace['class'] . '::' : '' ) . $trace['function'] . '() in ';
               echo \basename( $trace['file'] ) . ':' . $trace['line'] . PHP_EOL;
               echo '</em></li>';
           };
        ?></ol>
    <?php endif; ?>
    <hr />
    <a href="/doc" style="text-decoration:none;">Web Service Reference</a>
</div>