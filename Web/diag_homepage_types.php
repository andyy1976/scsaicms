<?php
header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ALL);

$conn = @mysqli_connect('82.156.40.94', 'eastaiai', 'alibaba', 'eastaiai');
if (!$conn) {
    echo "MySQLi connection FAILED: " . mysqli_connect_error() . "\n";
    exit;
}
echo "MySQLi connected OK\n";

// Check typeids 18,20,22
$r = mysqli_query($conn, 'SELECT typeid,typename,fid,path,ismenu FROM lvbo_type WHERE typeid IN (18,20,22)');
if(mysqli_num_rows($r) == 0) {
    echo "NOTICE: Type IDs 18, 20, 22 do NOT exist in lvbo_type\n";
} else {
    while($row = mysqli_fetch_assoc($r)) {
        echo "typeid={$row['typeid']} typename={$row['typename']} fid={$row['fid']}\n";
    }
}

// Article counts
foreach([18,20,22] as $tid) {
    $r2 = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM lvbo_article WHERE typeid=$tid AND status=1");
    $row = mysqli_fetch_assoc($r2);
    echo "typeid=$tid: ".$row['cnt']." articles\n";
}

// All ismenu=1 types
echo "\n=== ismenu=1 types (navigation) ===\n";
$r3 = mysqli_query($conn, 'SELECT typeid,typename,fid,ismenu FROM lvbo_type WHERE ismenu=1 ORDER BY typeid');
while($row = mysqli_fetch_assoc($r3)) {
    echo "typeid={$row['typeid']} typename={$row['typename']} fid={$row['fid']}\n";
}
?>