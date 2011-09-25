<?php $this->addStylesheet( '/css/styles.css' ); ?>
<html>
    <head>
        <title><?= $this->getTitle(); ?></title><?php
            $this->printStylesheetsAsHtml();
            $this->printScriptsAsHtml();
        ?><style type="text/css">body{background-color:none;background-image:url(http://peter.john.so/n/bg.jpg);background-repeat:repeat-x;}@font-face{font-family:'Josefin Sans';font-style:normal;font-weight:400;src:local('Josefin Sans'), local(JosefinSans), url(http://themes.googleusercontent.com/static/fonts/josefinsans/v1/xgzbb53t8j-Mo-vYa23n5nhCUOGz7vYGh680lGh-uXM.woff) format(woff);}</style>        
    </head>
    <body>
        <?php echo $this->getView()->getOutput(); ?>
        <script type="text/javascript">var _gaq=_gaq||[];_gaq.push(["_setAccount","UA-21161437-2"]);_gaq.push(["_setDomainName",".htmlentities.org"]);_gaq.push(["_trackPageview"]);(function(){var a=document.createElement("script");a.type="text/javascript";a.async=true;a.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var b=document.getElementsByTagName("script")[0];b.parentNode.insertBefore(a,b)})()</script>
    </body>
</html>