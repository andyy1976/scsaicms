<?php
// 临时诊断脚本 - 检查栏目数据
// 用完后请删除此文件！
header('Content-Type: text/plain; charset=utf-8');

// 连接数据库
$mysqli = new mysqli('82.156.40.94', 'eastaiai', 'Scsai2024!eastaiai', 'eastaiai');
if ($mysqli->connect_error) {
    die("DB连接失败: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8');

echo "=== lvbo_type 完整数据 ===\n";
$result = $mysqli->query(
    "SELECT typeid, typename, fid, ismenu, path, drank FROM lvbo_type ORDER BY path"
);

echo str_pad('typeid', 7) . str_pad('typename', 24) . str_pad('fid', 4) . str_pad('ismenu', 7) . str_pad('path', 14) . "drank\n";
echo str_repeat('-', 70) . "\n";

while ($r = $result->fetch_assoc()) {
    echo str_pad($r['typeid'], 7) .
         str_pad($r['typename'], 24) .
         str_pad($r['fid'], 4) .
         str_pad($r['ismenu'], 7) .
         str_pad($r['path'] || '', 14) .
         $r['drank'] . "\n";
}

echo "\n=== 模拟 PublicAction submenu 查询 ===\n";

// 查一级菜单
$top = $mysqli->query("SELECT typeid, typename FROM lvbo_type WHERE fid=0 AND ismenu=1 ORDER BY drank asc");
while ($m = $top->fetch_assoc()) {
    $subs = $mysqli->query(
        "SELECT typeid, typename, ismenu FROM lvbo_type WHERE fid={$m['typeid']} AND ismenu=1 ORDER BY drank asc"
    );
    $subList = [];
    while ($s = $subs->fetch_assoc()) {
        $subList[] = "[{$s['typeid']}]{$s['typename']}(ismenu={$s['ismenu']})";
    }
    // 也查一下 ismenu=0 的子项（看看是不是 ismenu 导致的）
    $subs0 = $mysqli->query(
        "SELECT typeid, typename, ismenu FROM lvbo_type WHERE fid={$m['typeid']} AND ismenu=0 ORDER BY drank asc"
    );
    $subList0 = [];
    while ($s0 = $subs0->fetch_assoc()) {
        $subList0[] = "[{$s0['typeid']}]{$s0['typename']}(ismenu=0)";
    }
    
    echo "[{$m['typeid']}] {$m['typename']} -> \n";
    echo "  启用子菜单(" . count($subList) . "): " . (count($subList) ? implode(', ', $subList) : '(无)') . "\n";
    if (count($subList0)) {
        echo "  禁用子菜单(" . count($subList0) . "): " . implode(', ', $subList0) . " <<< 这些不会显示!\n";
    }
}

$mysqli->close();
echo "\n=== 诊断完成 ===\n";
?>
