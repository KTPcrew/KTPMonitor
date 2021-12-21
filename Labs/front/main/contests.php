<?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $url = parse_url($actual_link);
    parse_str($url['query'],$params);
    // echo $params["div"]
    $file = "../../server/data/" . $params['div'] . "/contests/descriptions.txt";
    $file_content = file_get_contents($file);   // raw input
    $contests_list = explode("\n", $file_content); // parse to array of strings
    $contests = array();
    for($i = 0; $i < count($contests_list); $i++){ // fill students array
        $tmp = explode(",,", $contests_list[$i]);
        $contests[$i] = array('name' => $tmp[0],
                                'id' => $tmp[1],
                                'author' => $tmp[2],
                                'duration' => $tmp[3]);
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
            <table style="width:50%;">
                <?php
                    echo "<thead>";
                    echo "<tr><td>#</td>";
                    foreach ($contests[0] as &$desc) {
                        echo "<td style=\"text-align: center\">" . $desc . "</td>\n";
                    }
                    echo "</tr>";
                    echo "</thead>";
                    for($i = 1; $i < count($contests); $i++){
                        echo "<tr>";
                        echo "<td>" . ($i) . "</td>\n";
                        echo "<td>" . $contests[$i]['name'] . "</td>";
                        echo "<td><a href=\"./contest.php?div=" . $params["div"] . "&id=" . $contests[$i]['id'] . "\">" . $contests[$i]['id'] . "</a></td>\n";
                        echo "<td><a href=\"https://codeforces.com/profile/" . $contests[$i]['author'] ."\">" . $contests[$i]['author'] . "</a></td>\n";
                        $hours = intdiv((int)$contests[$i]['duration'], 3600);
                        $minutes = intdiv(((int)$contests[$i]['duration'] % 60), 60);
                        $duration = $hours . "ч. " . $minutes . "м.";
                        echo "<td>" . $duration . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </main>
    </body>
</html>
