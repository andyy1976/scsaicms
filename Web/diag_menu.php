<?php
// diag_menu.php - 诊断栏目导航问题
header('Content-Type: text/plain; charset=utf-8');

$type = M('type');
$rows = $type->order('typeid asc')->select();

echo "=== lvbo_type 全表 ===\n";
echo "typeid | typename          | fid | path           | ismenu\n";
echo "-------+--------------------+-----+----------------+-------\n";

$problems = array();
foreach ($rows as $r) {
    $line = str_pad($r['typeid'], 6) . ' | ' . 
            str_pad($r['typename'], 18) . ' | ' . 
            str_pad($r['fid'], 3) . ' | ' . 
            str_pad($r['path'] ?: '', 14) . ' | ' . $r['ismenu'];
    
    // fid=0 + ismenu=1 但不是首页 = 会显示为一级导航
    if ($r['fid'] == 0 && $r['ismenu'] == 1 && $r['typeid'] != 1) {
        $problems[] = $r;
        $line .= "  <<< PROBLEM: shows as TOP-LEVEL nav!";
    }
    echo $line . "\n";
}

echo "\n=== Problems: " . count($problems) . " ===\n";
if (count($problems) > 0) {
    echo "These columns have fid=0 AND ismenu=1 (NOT homepage), so they show as top-level:\n";
    foreach ($problems as $p) {
        echo "  typeid={$p['typeid']} \"{$p['typename']}\" fid={$p['fid']} path={$p['path']}\n";
    }
}
?>
