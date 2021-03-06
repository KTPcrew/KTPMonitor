<?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $url = parse_url($actual_link);
    parse_str($url['query'],$params);
    // echo $params["div"]
    $file = "../../data/" . $params['div'] . "/contests/" . $params['id'];
    $file_content = file_get_contents($file);   // raw input
    $raw_students = explode("\n", $file_content); // parse to array of strings

    $students = array();
    for($i = 0; $i < count($raw_students); $i++){ // fill students array
        $tmp = explode(",,", $raw_students[$i]);
        $students[$i]  = array('name' => $tmp[0],
                                'nik' => $tmp[1],
                                'sum' => $tmp[2]);
        for($j = 3; $j < count($tmp); $j++){
            $students[$i][$j] = $tmp[$j];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head class="">
        <meta charset="utf-8">
        <title>Contests</title>
        <link rel="shortcut icon" href="../assets/PageLogo.png"/>
        <link rel="stylesheet" href="../css/infotables.css">
        <link rel="stylesheet" href="../css/divpage.css">
    </head>
    <body>
        <main>
            <h style="font-size: 350%"><a style="text-decoration:none; color:black;" href="./index.php">Div</a> <?php echo $params["div"]; ?>/</h>
            <br><br>
            <nav>
                <a href="./Division <?php echo $params["div"]; ?>.php" class="general">общее</a>
                <a href="./contests.php?div=<?php echo $params["div"]; ?>" class="contests">контесты</a>
                <a href="./students.php?div=<?php echo $params["div"]; ?>" class="students">студенты</a>
                <a href="./performance.php?div=<?php echo $params["div"]; ?>" class="performance">успеваемость</a>
            </nav>
            <br>
            <table style="width:70%;">
                <?php
                    echo "<thead>";
                    echo "<tr><td>#</td></td>";
                    foreach($students[0] as &$header){
                        echo "<td style=\"text-align: center\">" . $header . "</td>";
                    }
                    echo "</tr>";
                    echo "</thead>";
                    for($i = 1; $i < count($students); $i++){
                        echo "<tr>";
                        echo "<td>" . $i . "</td>\n";
                        echo "<td>" . $students[$i]['name'] . "</td>\n";
                        echo "<td><a href=\"https://codeforces.com/profile/" . str_replace('*', '', $students[$i]['nik']) . "\">" . $students[$i]['nik'] . "</a></td>\n";
                        echo "<td>" . $students[$i]['sum'] . "</td>\n";
                        for($j = 3; $j < count($students[$i]); $j++){
                            echo "<td style=\"text-align: center\">" . $students[$i][$j] . "</td>\n";
                        }
                        echo "</tr>\n";
                    }
                ?>
            </table>
        </main>
    </body>
</html>
