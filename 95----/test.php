<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />

    <title>JoahKnives</title>
    <style type="text/css">
        body {
            color: White;
            background-color: Black;
            background-image: url("tlof.jpg");
            background-repeat: no-repeat;
            background-position: center top;
            width: 1024px;
            margin: 0 auto 0 auto;
            padding: 0;
            font-family: Arial, Sans-Serif;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        td {
            border: dotted 1px #fff;
            padding: 10px;

        }

        .a_menu {
            display: block;
            text-decoration: none;
            padding: 5px 10px;
            font-weight: bold;
            color: #abc;
        }

        .a_menu:hover {
            background-color: #578;
            color: #def;
        }

        img {
            border-width: 0;
        }

        table {
            margin-top: 125px;
            table-layout: fixed;
            border-collapse: collapse;
            width: 100%;
        }


        .x {
            text-align: right;
            font-weight: normal;
            font-style: italic;
            padding-right: 15px;
        }

        .a_tit {
            color: #000;
            font-size: 10pt;
            position: absolute;
            right: 400px;
            top: 20px;
            text-decoration: none;

        }
    </style>
</head>

<body>
    <a class="a_tit" href="http://www.knives.pl/forum/index.php/board,244.0.html"><img src=logo.gif width=60 style="vertical-align: middle;" /><i>Knives</i> w PCK forum Knives.pl</a>
    <table>


        <?php


        function CreateTumb($fn)
        {
            $path_parts = pathinfo($fn);
            $dn = $path_parts['dirname'];
            $bn = $path_parts['basename'];
            $suff = "t2_";
            $fnt = $dn . '/' . $suff . $bn;
            if (preg_match($suff, $bn)) return $fnt;
            $mxW = 0;
            $mxH = 0;
            if (!file_exists($fnt)) {
                $im = @ImageCreateFromJPEG($fn);
                $size = GetImageSize($fn);
                $srcW = $size[0];
                $srcH = $size[1];
                $xy = $srcW / $srcH;
                $dstH = 120;
                $dstW = $xy * $dstH;

                $jm = ImageCreateTrueColor($dstW, $dstH);
                ImageCopyResized($jm, $im, 0, 0, 0, 0, $dstW, $dstH, $srcW, $srcH);
                ImageJPEG($jm, $fnt);
                imagedestroy($im);
                imagedestroy($jm);
            }
            return $fnt;
        }



        $db_host = "10.111.114.252";
        $db_name = "knives";
        $db_user = "knives";
        $db_pass = "kdyehrt";


        $mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", $mysqli->connect_error);
            exit();
        }


        $mysqli->query("SET NAMES 'utf8'");        
        $wyn = $mysqli->query( "select * from knives where ORD<500 order by ORD desc");        
        $n = $wyn->num_rows;
        $i = 0;
        $j = 0;
        echo (" <tr>\n");
        while ($row = $wyn->fetch_array($wyn)) {
            $idir = $row['IMG_DIR'];
            if (isset($idir) && $idir != null && $idir != '')
                $idir = $idir . "/";
            else
                $idir = '';
            $ord = $row['ORD'];
            $i++;
            $j++;
            if ($ord > 0)
                echo ("<td><a href=fiszka.php?KID=" . $row['ID'] . "&WAR=n class=\"a_menu\">" . $row['CAP'] . "<br /><img src=\"" . CreateTumb($idir . $row['TUMB']) . "\"/><div class=\"x\">" . $row['DATA'] . "</div></a></td>\n");
            else
                echo ("<td><a class=\"a_menu\"><br /><img src=\"" . $idir . $row['TUMB'] . "\"/></a></td>\n");
            if ($i == 5) {
                $i = 0;
                echo ("</tr>\n");
                if ($j < $n) echo ("<tr>\n");
            }
        }
        if ($i != 0) echo ("</tr>\n");
        $wyn->free_result();

        ?>

    </table>
    <br />
    <table style="margin-top:0px">

        <?php


        $wyn = $mysqli->query("select * from knives where ORD>=500 order by ORD desc");
        $n = $wyn->num_rows;
        $i = 0;
        $j = 0;
        echo (" <tr>\n");
        while ($row = $wyn->fetch_array()) {
            $i++;
            $j++;
            echo ("<td><a href=\"" . $row['LINK'] . "\" target=\"_blank\" class=\"a_menu\">" . $row['CAP'] . "<br /><img src=\"" . CreateTumb($row['TUMB']) . "\"/><div class=\"x\">" . $row['DATA'] . "</div></a></td>\n");
            if ($i == 4) {
                $i = 0;
                echo ("</tr>\n");
                if ($j < $n) echo ("<tr>\n");
            }
        }
        if ($i != 0) echo ("</tr>\n");
        $wyn->free_result();
        $mysqli->close();

        ?>


    </table>


    <a href="index.php">.</a>
    <a class="menu" href="scripts/stat/stat_2.php" target=_blank>.</a>
    <script type="text/javascript">
        var s = "<img width=1 height=1 border=0 src=scripts/stat/stat_1.php?par=1&ref=" + document.referrer + "&scr=" + screen.width + "x" + screen.height + ">";
        document.write(s);
    </script>
</body>

</html>