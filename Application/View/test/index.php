<ul>
<?
    foreach( $this['data'] as $test )
    {
        echo '<li><ul>';
        foreach( $test as $k => $v )
            echo '<li>' . $v . '</li>';
        echo '</ul></li>';
    }
?>
</ul>