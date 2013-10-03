<!DOCTYPE html>
<html>
    <head>
        <title><?php echo View::getTitle(); ?></title>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/js.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <?php
        require_once View::getLayout();
        ?>
    </body>
</html>