<!-- <pre> -->
<?php
include("./sudoku.php");
// print_r($sudoku);
$all = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
function logs($msg)
{
    echo $msg . "<br>";
}

function available_numbers($ii, $jj, $kk, $ll, $sudoku)
{
    global $all;
    $temp_available = $all;
    // Test 1;
    for ($k = 0; $k < 3; $k++) {
        for ($l = 0; $l < 3; $l++) {
            if ($sudoku[$ii][$jj][$k][$l] != " ") {
                if (($key = array_search($sudoku[$ii][$jj][$k][$l], $temp_available)) !== false) {
                    unset($temp_available[$key]);
                }
            }
        }
    }

    // Test 2;
    for ($j = 0; $j < 3; $j++) {
        for ($l = 0; $l < 3; $l++) {
            if ($sudoku[$ii][$j][$kk][$l] != " ") {
                if (($key = array_search($sudoku[$ii][$j][$kk][$l], $temp_available)) !== false) {
                    unset($temp_available[$key]);
                }
            }
        }
    }

    // Test 3;
    for ($i = 0; $i < 3; $i++) {
        for ($k = 0; $k < 3; $k++) {
            if ($sudoku[$i][$jj][$k][$ll] != " ") {
                if (($key = array_search($sudoku[$i][$jj][$k][$ll], $temp_available)) !== false) {
                    unset($temp_available[$key]);
                }
            }
        }
    }
    return array_values($temp_available);
}

function solve_unsolved_count($sudoku)
{
    $solved = 0;
    $unsolved = 0;
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            for ($k = 0; $k < 3; $k++) {
                for ($l = 0; $l < 3; $l++) {
                    if ($sudoku[$i][$j][$k][$l] == " ") {
                        $unsolved += 1;
                    } else {
                        $solved += 1;
                    }
                }
            }
        }
    }
    return array("solved" => $solved, "unsolved" => $unsolved);
}
function solve_sudoku_limited($sudoku, $limit = 1)
{

    logs("Solve Sudoku for Limit " . $limit);
    $last_solved = 0;
    for ($x = 1; $x <= 5; $x++) {
        logs("<br>Loop Number $x");
        $counts = solve_unsolved_count($sudoku);
        $solved = $counts["solved"];
        if ($solved > $last_solved) {
            $last_solved = $solved;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = 0; $l < 3; $l++) {
                            if ($sudoku[$i][$j][$k][$l] == " ") {
                                $available = available_numbers($i, $j, $k, $l, $sudoku);
                                print_r($available);
                                echo "<br>";
                                if (count($available) <= $limit) {
                                    if (count($available) == 1) {
                                        echo "Assignine";
                                        $sudoku[$i][$j][$k][$l] = $available[0];
                                    }
                                    /*else if (count($available) == 2) {
                                        // Here it need to use back track
                                        $test1 = $sudoku;
                                        $test2 = $sudoku;

                                        $test1[$i][$j][$k][$l] = $available[0];
                                        $test2[$i][$j][$k][$l] = $available[1];

                                        $test1 = solve_sudoku($test1, 1);
                                        $test2 = solve_sudoku($test2, 1);

                                        $test1_count = solve_unsolved_count($test1);
                                        $test2_count = solve_unsolved_count($test2);
                                        var_dump($test1_count);
                                        var_dump($test2_count);
                                        exit();
                                        if ($test1_count["unsolved"] == 0) {
                                            echo "Test 1";
                                            $sudoku = $test1;
                                        }

                                        if ($test2_count["unsolved"] == 0) {
                                            echo "Test 2";
                                            $sudoku = $test2;
                                        }
                                    } else {
                                        echo "Its More than 2";
                                        $test1 = $sudoku;
                                        $test2 = $sudoku;
                                        $test3 = $sudoku;

                                        $test1[$i][$j][$k][$l] = $available[0];
                                        $test2[$i][$j][$k][$l] = $available[1];
                                        $test3[$i][$j][$k][$l] = $available[2];

                                        $test1 = solve_sudoku($test1, 1);
                                        $test2 = solve_sudoku($test2, 1);
                                        $test3 = solve_sudoku($test3, 1);

                                        $test1_count = solve_unsolved_count($test1);
                                        $test2_count = solve_unsolved_count($test2);
                                        $test3_count = solve_unsolved_count($test3);
                                        var_dump($test1_count);
                                        var_dump($test2_count);
                                        var_dump($test3_count);
                                        exit();
                                        if ($test1_count["unsolved"] == 0) {
                                            echo "Test 1";
                                            $sudoku = $test1;
                                        }

                                        if ($test2_count["unsolved"] == 0) {
                                            echo "Test 2";
                                            $sudoku = $test2;
                                        }
                                        if ($test3_count["unsolved"] == 0) {
                                            echo "Test 3";
                                            $sudoku = $test3;
                                        }
                                    }*/
                                }
                            }
                        }
                    }
                }
            }
        }
        logs("Loop Number $x Over <br>");
    }
    return $sudoku;
}
function solve_sudokux($sudoku, $max = 1)
{
    logs("Solve Sudoku for Max " . $max);
    $total = 81;
    $last_solved = 0;
    if ($max >= 1) {
        $sudoku = solve_sudoku_limited($sudoku, 1);
    }
    // if ($max >= 2) {
    //     $sudoku = solve_sudoku_limited($sudoku, 2);
    // }
    // if ($max >= 3) {
    //     $sudoku = solve_sudoku_limited($sudoku, 3);
    // }

    // for ($x = 1; $x <= 10; $x++) {
    //     $counts = solve_unsolved_count($sudoku);
    //     $solved = $counts["solved"];
    //     if ($solved > $last_solved) {
    //         $last_solved = $solved;
    //         for ($i = 0; $i < 3; $i++) {
    //             for ($j = 0; $j < 3; $j++) {
    //                 for ($k = 0; $k < 3; $k++) {
    //                     for ($l = 0; $l < 3; $l++) {
    //                         if ($sudoku[$i][$j][$k][$l] == " ") {
    //                             $available = available_numbers($i, $j, $k, $l, $sudoku);
    //                             echo $sudoku[$i][$j][$k][$l] . " == ";
    //                             print_r($available);
    //                             if (count($available) == 1) {
    //                                 echo "Can be " . $available[0];
    //                                 $sudoku[$i][$j][$k][$l] = $available[0];
    //                             }
    //                             echo "<br>";
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         echo "Failed";
    //         break;
    //     }
    // }
    return $sudoku;
}


function solve_sudoku_final($sudoku, $retry = true)
{
    $last_solved = 0;
    for ($x = 1; $x <= 6; $x++) {
        $counts = solve_unsolved_count($sudoku);
        $solved = $counts["solved"];
        if ($solved > $last_solved) {
            $last_solved = $solved;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = 0; $l < 3; $l++) {
                            if ($sudoku[$i][$j][$k][$l] == " ") {
                                $available = available_numbers($i, $j, $k, $l, $sudoku);
                                if (count($available) == 1) {
                                    $sudoku[$i][$j][$k][$l] = $available[0];
                                }
                            }
                        }
                    }
                }
            }
        } else {
            if ($retry) {
                return solve_sudoku_semifinal($sudoku, false);
            }
        }
    }
    return $sudoku;
}


function solve_sudoku_semifinal($sudoku, $retry = true)
{
    $last_solved = 0;
    for ($x = 1; $x <= 6; $x++) {
        $counts = solve_unsolved_count($sudoku);
        $solved = $counts["solved"];
        if ($solved > $last_solved) {
            $last_solved = $solved;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = 0; $l < 3; $l++) {
                            if ($sudoku[$i][$j][$k][$l] == " ") {
                                $available = available_numbers($i, $j, $k, $l, $sudoku);
                                // echo $sudoku[$i][$j][$k][$l] . " == ";
                                // print_r($available);
                                if (count($available) == 1) {
                                    $sudoku[$i][$j][$k][$l] = $available[0];
                                }
                                // echo "<br>";
                            }
                        }
                    }
                }
            }
        } else {
            // echo "<h1>OVER</h1>";
            // echo "<h1>FAILED 2</h1>";
            $tests = array();
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = 0; $l < 3; $l++) {
                            if ($sudoku[$i][$j][$k][$l] == " ") {
                                $available = available_numbers($i, $j, $k, $l, $sudoku);
                                // echo $sudoku[$i][$j][$k][$l] . " == ";
                                // print_r($available);
                                if (count($available) == 2) {
                                    $temp1 = $sudoku;
                                    $temp2 = $sudoku;
                                    $temp1[$i][$j][$k][$l] = $available[0];
                                    $temp2[$i][$j][$k][$l] = $available[1];
                                    $tests[] = $temp1;
                                    $tests[] = $temp2;
                                }

                                if (count($available) == 3) {
                                    $temp1 = $sudoku;
                                    $temp2 = $sudoku;
                                    $temp3 = $sudoku;
                                    $temp1[$i][$j][$k][$l] = $available[0];
                                    $temp2[$i][$j][$k][$l] = $available[1];
                                    $temp3[$i][$j][$k][$l] = $available[2];
                                    $tests[] = $temp1;
                                    $tests[] = $temp2;
                                    $tests[] = $temp3;
                                }
                                // echo "<br>";
                            }
                        }
                    }
                }
            }
            // var_dump(count($tests));
            // exit();
            foreach ($tests as $key => $test) {
                // echo "<h2>Final</h2>";
                $tests[$key] = solve_sudoku_final($test, $retry);
                $counts = solve_unsolved_count($tests[$key]);
                if ($counts["unsolved"] == 0) {
                    return $tests[$key];
                }
                // echo "<br>";
            }
            // echo "<h1>FAILED2 OVER</h1>";
            return $sudoku;
        }
    }
    return $sudoku;
}

function solve_sudokuxx($sudoku)
{
    $last_solved = 0;
    for ($x = 1; $x <= 10; $x++) {
        $counts = solve_unsolved_count($sudoku);
        $solved = $counts["solved"];
        if ($solved > $last_solved) {
            $last_solved = $solved;
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = 0; $l < 3; $l++) {
                            if ($sudoku[$i][$j][$k][$l] == " ") {
                                $available = available_numbers($i, $j, $k, $l, $sudoku);
                                // echo $sudoku[$i][$j][$k][$l] . " == ";
                                // print_r($available);
                                if (count($available) == 1) {
                                    echo "Can be " . $available[0];
                                    $sudoku[$i][$j][$k][$l] = $available[0];
                                }
                                // echo "<br>";
                            }
                        }
                    }
                }
            }
        } else {
            echo "<h1>FAILED</h1>";
            $tests = array();
            for ($i = 0; $i < 3; $i++) {
                for ($j = 0; $j < 3; $j++) {
                    for ($k = 0; $k < 3; $k++) {
                        for ($l = 0; $l < 3; $l++) {
                            if ($sudoku[$i][$j][$k][$l] == " ") {
                                $available = available_numbers($i, $j, $k, $l, $sudoku);
                                echo $sudoku[$i][$j][$k][$l] . " == ";
                                print_r($available);
                                if (count($available) == 2) {
                                    $temp1 = $sudoku;
                                    $temp2 = $sudoku;
                                    $temp1[$i][$j][$k][$l] = $available[0];
                                    $temp2[$i][$j][$k][$l] = $available[1];
                                    $tests[] = $temp1;
                                    $tests[] = $temp2;
                                }
                                if (count($available) == 3) {
                                    $temp1 = $sudoku;
                                    $temp2 = $sudoku;
                                    $temp3 = $sudoku;
                                    $temp1[$i][$j][$k][$l] = $available[0];
                                    $temp2[$i][$j][$k][$l] = $available[1];
                                    $temp3[$i][$j][$k][$l] = $available[2];
                                    $tests[] = $temp1;
                                    $tests[] = $temp2;
                                    $tests[] = $temp3;
                                }
                                if (count($available) == 4) {
                                    $temp1 = $sudoku;
                                    $temp2 = $sudoku;
                                    $temp3 = $sudoku;
                                    $temp4 = $sudoku;
                                    $temp1[$i][$j][$k][$l] = $available[0];
                                    $temp2[$i][$j][$k][$l] = $available[1];
                                    $temp3[$i][$j][$k][$l] = $available[2];
                                    $temp4[$i][$j][$k][$l] = $available[3];
                                    $tests[] = $temp1;
                                    $tests[] = $temp2;
                                    $tests[] = $temp3;
                                    $tests[] = $temp4;
                                }
                                echo "<br>";
                            }
                        }
                    }
                }
            }
            foreach ($tests as $key => $test) {
                // $tests[$key] = solve_sudoku_semifinal($test);
                // $counts = solve_unsolved_count($tests[$key]);
                // if($counts["unsolved"] == 0){
                //     return $tests[$key];
                // }
            }
            var_dump(count($tests));
            echo "<h1>FAILED OVER</h1>";
            return $sudoku;
        }
    }
    return $sudoku;
}



function solve_sudoku($sudoku, $level = 2)
{
    if ($level <= 5) {
        $last_solved = 0;
        for ($x = 1; $x <= 8; $x++) {
            $counts = solve_unsolved_count($sudoku);
            $solved = $counts["solved"];
            if ($solved > $last_solved) {
                $last_solved = $solved;
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        for ($k = 0; $k < 3; $k++) {
                            for ($l = 0; $l < 3; $l++) {
                                if ($sudoku[$i][$j][$k][$l] == " ") {
                                    $available = available_numbers($i, $j, $k, $l, $sudoku);
                                    if (count($available) == 1) {
                                        $sudoku[$i][$j][$k][$l] = $available[0];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $tests = array();
                for ($i = 0; $i < 3; $i++) {
                    for ($j = 0; $j < 3; $j++) {
                        for ($k = 0; $k < 3; $k++) {
                            for ($l = 0; $l < 3; $l++) {
                                if ($sudoku[$i][$j][$k][$l] == " ") {
                                    $available = available_numbers($i, $j, $k, $l, $sudoku);
                                    // print_r($available);
                                    // echo "<br>";
                                    if (count($available) <= $level) {
                                        foreach ($available as $a) {
                                            $temp = $sudoku;
                                            $temp[$i][$j][$k][$l] = $a;
                                            $tests[] = $temp;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (count($tests) > 0) {
                    foreach ($tests as $key => $test) {
                        $tests[$key] = solve_sudoku($test, $level + 1);
                        $counts = solve_unsolved_count($tests[$key]);
                        // print_r($counts);
                        // echo "<br>";
                        if ($counts["unsolved"] == 0) {
                            return $tests[$key];
                        }
                    }
                }

                return $sudoku;
            }
        }
    } else {
        // exit();
    }
    return $sudoku;
}






$sudoku_old = $sudoku;

var_dump(solve_unsolved_count($sudoku));
echo "<br><br>";
$sudoku = solve_sudoku($sudoku);
echo "<br><br>";
var_dump(solve_unsolved_count($sudoku));
$inspect = false;
$size = "20";
if ($inspect) {
    $size = "40";
}
echo "<table cellspacing='0'>";
for ($i = 0; $i < 3; $i++) {
    echo "<tr>";
    for ($j = 0; $j < 3; $j++) {
        echo "<td>";
        echo "<table border='1'>";
        for ($k = 0; $k < 3; $k++) {
            echo "<tr>";
            for ($l = 0; $l < 3; $l++) {
                if ($sudoku_old[$i][$j][$k][$l] == " ") {
                    $color = "blue";
                } else {
                    $color = "black";
                }
                echo "<td height='" . $size . "' width='" . $size . "' style='color:$color;' align='center'>";
                print_r($sudoku[$i][$j][$k][$l]);
                if ($inspect) {
                    echo  "<br>" . $i . $j . $k . $l;
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";
