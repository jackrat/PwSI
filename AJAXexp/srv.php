<?php



class db_vars
{
        static public $dbUser = 'pwsi_user';
        static public $dbPass = 'pwsi_password';
        static public $dbHost = '212.87.228.200';
        static public $dbName = 'pwsi19';
}

class Results
{
        public $msg = null;
        public $obj = null;
}


function cre($conn)
{
        $conn->query("create table lyja_plan(id int auto_increment, day int not null, hour int not null, room varchar(10) not null, color varchar(10) not null, primary key(id))");
}
function dro($conn)
{
        $conn->query("drop table lyja_plan");
}
function fil($conn)
{
        $stmt = $conn->prepare("insert into lyja_plan(day,hour,room,color) values(?,?,?,?)");
        for ($i = 0; $i < 40; $i++) {
                $day = rand(1, 7);
                $hour = rand(8, 20);
                $room = "E" . rand(1, 30);
                $col = "#" .bin2hex(random_bytes(3));
                $stmt->bind_param("iiss", $day, $hour, $room, $col);
                $stmt->execute();
        }
}
function del($conn)
{
        $conn->query("delete from lyja_plan");
}
function sel($conn)
{
        $tab = $conn->query("select * from lyja_plan");
        $outp = $tab->fetch_all(MYSQLI_ASSOC);
        return json_encode($outp);
}


$res = "";
$resObj = null;
if (isset($_GET["act"])) {
        $conn = new mysqli(db_vars::$dbHost, db_vars::$dbUser, db_vars::$dbPass, db_vars::$dbName);
        switch ($_GET["act"]) {
                case "1":
                        cre($conn);
                        $res .= "create table: ";
                        break;
                case "2":
                        dro($conn);
                        $res .= "drop table: ";
                        break;
                case "3":
                        fil($conn);
                        $res .= "fill table: ";
                        break;
                case "4":
                        del($conn);
                        $res .= "del table: ";
                        break;
                case "5":
                        $resObj = sel($conn);
                        $res .= "sel table: ";
                        break;               
                default:
                        break;
        }
        if ($conn->errno) $res .= "err-" . $conn->error;
        else $res .= "OK\r\n";
        $conn->close();
}

 $results = new Results;
 $results->msg = $res;
 $results->obj = $resObj;
 $s = json_encode($results);
 echo $s;


?>