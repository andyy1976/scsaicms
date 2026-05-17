<?php
/**
 * AgentAction - 供本地AI agent调用的内部接口
 * ThinkPHP URL: /index.php?s=agent/nav  → publicNav()
 */
class AgentAction extends Action {

    public function nav() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $host = '82.156.40.94';
        $user = 'eastaiai';
        $pass = 'Eastaiai@2024';
        $db   = 'eastaiai';
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            echo json_encode(['error' => $conn->connect_error]);
            return;
        }
        $conn->set_charset('utf8mb4');

        // 查询数字员工相关栏目（typeid=4为数字员工一级）
        $sql = "SELECT typeid, typename, fid, path, description, url 
                FROM lvbo_type 
                WHERE path LIKE '0-4-%' OR typeid = 4 
                ORDER BY path";
        $res = $conn->query($sql);

        $items = [];
        while ($row = $res->fetch_assoc()) {
            $items[] = $row;
        }

        // 所有一级栏目
        $sql2 = "SELECT typeid, typename, fid, path FROM lvbo_type WHERE fid=0 AND ismenu=1 ORDER BY sort ASC, typeid ASC";
        $res2 = $conn->query($sql2);
        $topNav = [];
        while ($row = $res2->fetch_assoc()) {
            $topNav[] = $row;
        }

        // 数字员工下的子栏目
        $sql3 = "SELECT typeid, typename, fid, path, description FROM lvbo_type WHERE fid=4 ORDER BY sort ASC, typeid ASC";
        $res3 = $conn->query($sql3);
        $deStaffChildren = [];
        while ($row = $res3->fetch_assoc()) {
            $deStaffChildren[] = $row;
        }

        echo json_encode([
            'mainNav' => $topNav,
            'deStaffChildren' => $deStaffChildren,
            'deStaffTree' => $items
        ], JSON_UNESCAPED_UNICODE);

        $conn->close();
    }
}
