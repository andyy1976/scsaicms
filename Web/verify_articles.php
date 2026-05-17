<?php
/**
 * 数据库验证脚本
 */
$host = '82.156.40.94';
$user = 'eastaiai';
$pass = 'alibaba';
$db   = 'eastaiai';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('DB连接失败: ' . $conn->connect_error);
}
$conn->query("SET NAMES utf8");

// 查询112和113栏目的最新3篇文章
foreach ([112, 113] as $typeid) {
    $res = $conn->query("SELECT aid, title, addtime, status, typeid FROM lvbo_article WHERE typeid=$typeid ORDER BY aid DESC LIMIT 3");
    echo "<h3>栏目 $typeid 最新3篇：</h3>";
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            echo "aid={$row['aid']} | title=" . strlen($row['title']) . "字符 | addtime={$row['addtime']} | status={$row['status']}<br>";
            echo "  标题内容: " . substr($row['title'], 0, 50) . "<br>";
        }
    } else {
        echo "无数据<br>";
    }
    echo "<hr>";
}

// 查询总文章数
$res2 = $conn->query("SELECT COUNT(*) as cnt, typeid FROM lvbo_article WHERE typeid IN (112,113) GROUP BY typeid");
echo "<h3>栏目统计：</h3>";
while ($r = $res2->fetch_assoc()) {
    echo "typeid={$r['typeid']}: {$r['cnt']} 篇<br>";
}

$conn->close();