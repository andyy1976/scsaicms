<?php
require './Conf/config.php';
$conn = mysqli_connect(C('DB_HOST'), C('DB_USER'), C('DB_PWD'), C('DB_NAME'));
if (mysqli_connect_errno()) { die("Connect failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, 'utf8');

// 查文章1820的typeid和对应栏目的page_path
$sql = "SELECT a.aid, a.title, a.typeid, t.typename, t.page_path, t.fid 
        FROM lvbo_article a 
        LEFT JOIN lvbo_type t ON a.typeid = t.typeid 
        WHERE a.aid = 1820";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo "Article 1820:\n";
echo "  typeid: " . $row['typeid'] . "\n";
echo "  typename: " . $row['typename'] . "\n";  
echo "  page_path: " . ($row['page_path'] ?: '(empty)') . "\n";
echo "  fid: " . $row['fid'] . "\n\n";

// 列出所有有page_path的栏目
echo "All types with page_path:\n";
$result2 = $conn->query("SELECT typeid, typename, page_path, fid FROM lvbo_type WHERE page_path != '' AND page_path IS NOT NULL");
while($r = $result2->fetch_assoc()) {
    echo "  typeid={$r['typeid']} | {$r['typename']} | path={$r['page_path']} | fid={$r['fid']}\n";
}

// 检查page_default.html是否存在
$tpath = './Tpl/sciotai/page_default.html';
echo "\npage_default.html exists: " . (file_exists($tpath) ? 'YES' : 'NO') . "\n";

// 也检查是否有其他可能的模板文件
echo "\nFiles in Tpl/sciotai/ containing 'page':\n";
$files = glob('./Tpl/sciotai/*page*');
foreach($files as $f) echo "  $f\n";
$files2 = glob('./Tpl/sciotai/article/**/*');
foreach($files2 as $f) echo "  article/: $f\n";

mysqli_close($conn);
?>
