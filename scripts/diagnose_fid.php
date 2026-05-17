<?php
/**
 * 诊断栏目父子关系 - 检查数据库中实际的fid值
 */
header('Content-Type: text/html; charset=utf-8');
$host = '82.156.40.94';
$user = 'eastaiai';
$pass = 'eastaiai123';
$db = 'eastaiai';

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die('连接失败: ' . mysqli_connect_error());
}

mysqli_query($conn, "SET NAMES utf8");

// 查询所有ismenu=1的栏目
echo "=== 所有 ismenu=1 的栏目（一级导航） ===\n";
$result = mysqli_query($conn, "SELECT typeid, typename, fid, ismenu, path FROM lvbo_type WHERE ismenu=1 ORDER BY typeid");
echo "<table border='1'>";
echo "<tr><th>typeid</th><th>typename</th><th>fid</th><th>path</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['typeid']}</td>";
    echo "<td>{$row['typename']}</td>";
    echo "<td>{$row['fid']}</td>";
    echo "<td>{$row['path']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "\n\n=== 检查子栏目的 fid 值 ===\n";
$child_ids = array(111, 112, 113, 121, 122, 123, 131, 132, 133);
echo "<table border='1'>";
echo "<tr><th>typeid</th><th>typename</th><th>fid(当前)</th><th>正确的fid</th><th>问题</th></tr>";

$fixes = array();
foreach ($child_ids as $id) {
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT typeid, typename, fid FROM lvbo_type WHERE typeid=$id"));
    if ($row) {
        $current_fid = $row['fid'];
        $typename = $row['typename'];
        
        // 计算正确的fid
        $correct_fid = 0;
        $problem = '';
        
        if ($id >= 111 && $id <= 113) {
            // 数字员工子栏目
            $correct_fid = 4;
            if ($current_fid != 4) {
                $problem = "应 fid=4(数字员工)";
            }
        } elseif ($id >= 121 && $id <= 123) {
            // 技术博客子栏目
            $correct_fid = 12;
            if ($current_fid != 12) {
                $problem = "应 fid=12(技术博客)";
            }
        } elseif ($id >= 131 && $id <= 133) {
            // 产品方案子栏目 - 目前错误地指向13
            $correct_fid = 14; // 新建产品方案
            if ($current_fid != 14) {
                $problem = "应 fid=14(产品方案)";
            }
        }
        
        echo "<tr>";
        echo "<td>{$id}</td>";
        echo "<td>{$typename}</td>";
        echo "<td>{$current_fid}</td>";
        echo "<td>{$correct_fid}</td>";
        echo "<td style='color:red'>{$problem}</td>";
        echo "</tr>";
        
        if ($current_fid != $correct_fid && $correct_fid > 0) {
            $fixes[] = "UPDATE lvbo_type SET fid={$correct_fid} WHERE typeid={$id}";
        }
    }
}
echo "</table>";

echo "\n\n=== 需要执行的SQL ===\n";
if (count($fixes) > 0) {
    foreach ($fixes as $sql) {
        echo $sql . ";\n";
    }
} else {
    echo "无需修复，fid已正确";
}

mysqli_close($conn);