<fieldset style="margin:20px;padding:20px;">
    <legend><?= $this->get( 'method' ); ?> <?= $this->get( 'uri' ); ?></legend>
    <form name="insomnia-form" action="<?= $this->get( 'uri' ); ?>" method="<?= $this->get( 'method' ); ?>" enctype="application/x-www-form-urlencoded">
        <?php foreach( $this->get( 'params' ) as $param ): ?> 
            <label style="float:left;width:100px;"><?= $param[ 'name' ] ?></label>
            <input name="<?= $param[ 'name' ] ?>" type="<?= $param[ 'type' ] ?>" required="<?= isset( $param[ 'required' ] ) && (bool) $param[ 'required' ] ? 'true' : 'false'; ?>" />
            <br />
        <?php endforeach; ?>
        <br />
        <input type="submit" />
    </form>
</fieldset>