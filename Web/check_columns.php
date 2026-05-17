<?php
/**
 * 检查栏目结构（一级栏目和二级栏目）
 * 访问：http://localhost/check_columns.php
 */

// 加载 ThinkPHP 数据库配置
$config = require './Conf/config.php';

// 连接数据库
$conn = new mysqli(
    $config['DB_HOST'],
    $config['DB_USER'],
    $config['DB_PWD'],
    $config['DB_NAME'],
    $config['DB_PORT']
);

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$conn->query("SET NAMES 'utf8'");

echo "<h2>活跃一级栏目（status=1, parentid=0）</h2>";
$result = $conn->query("SELECT id, typename, status, parentid FROM {$config['DB_PREFIX']}type WHERE status=1 AND parentid=0 ORDER BY id");
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>ID</th><th>栏目名称</th><th>状态</th><th>parentid</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['typename']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>{$row['parentid']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>所有栏目</h2>";
$result = $conn->query("SELECT id, typename, status, parentid FROM {$config['DB_PREFIX']}type ORDER BY parentid, id");
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr><th>ID</th><th>栏目名称</th><th>状态</th><th>parentid</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['typename']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>{$row['parentid']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>二级栏目（子栏目）检查</h2>";
$result = $conn->query("SELECT id, typename, status, parentid FROM {$config['DB_PREFIX']}type WHERE status=1 AND parentid=0 ORDER BY id");
$primaryColumns = $result->fetch_all(MYSQLI_ASSOC);

foreach ($primaryColumns as $col) {
    $subResult = $conn->query("SELECT id, typename, status, parentid FROM {$config['DB_PREFIX']}type WHERE parentid={$col['id']} ORDER BY id");
    $subColumns = $subResult->fetch_all(MYSQLI_ASSOC);
    
    if (count($subColumns) > 0) {
        echo "<h3>【{$col['typename']}】的子栏目：</h3>";
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>状态</th><th>parentid</th></tr>";
        foreach ($subColumns as $sub) {
            echo "<tr>";
            echo "<td>{$sub['id']}</td>";
            echo "<td>{$sub['typename']}</td>";
            echo "<td>{$sub['status']}</td>";
            echo "<td>{$sub['parentid']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>【{$col['typename']}】没有子栏目</p>";
    }
}

$conn->close();
?>
