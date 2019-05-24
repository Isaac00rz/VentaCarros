<html>
    <body>
        <?php 
            echo('<h1> ASII SUMAAAS PERRRO!!!</h1>');
            $time = strtotime('05/31/2019');
            $newformat = date('Y-m-d',$time);
            echo(date("Y", strtotime($newformat)));
            echo('<br>');
            echo($newformat);
            echo('<br>');
            echo date("Y-m-d",strtotime($newformat."+ 1 month")); 
        ?>
        <br>
    </body>
</html>