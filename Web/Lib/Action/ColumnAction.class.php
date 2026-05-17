<?php
/**
 * 栏目管理控制器
 * 访问：
 *   - http://localhost/index.php?s=Column/check  (检查栏目结构)
 *   - http://localhost/index.php?s=Column/simplify  (执行栏目简化)
 *   - http://localhost/index.php?s=Column/fixMenu  (修复菜单显示)
 *   - http://localhost/index.php?s=Column/diagnose  (诊断栏目结构)
 *   - http://localhost/index.php?s=Column/fixPath  (修复 fid 和 path 字段)
 */
class ColumnAction extends Action {
    
    /**
     * 修复 fid 和 path 字段（核心修复方法）
     * 
     * 问题：path 字段与 fid 不匹配导致下拉菜单不显示
     * 解决：同时更新 fid 和 path
     */
    public function fixPath() {
        header("Content-Type: text/html; charset=utf-8");
        
        echo "<h2>🔧 修复 fid 和 path 字段</h2>";
        echo "<p><strong>问题</strong>：path 字段与 fid 不匹配导致下拉菜单不显示</p>";
        echo "<p><strong>解决</strong>：同时更新 fid 和 path</p>";
        echo "<hr>";
        
        // Step 1: 产品方案(ID=2) - 一级栏目
        M('type')->where("typeid=2")->save(array(
            'typename' => '产品方案',
            'ismenu' => 1,
            'fid' => 0,
            'path' => '0-2',
            'drank' => 3
        ));
        echo "<p>✅ Step 1: ID=2 已改名为'产品方案'，path='0-2'，drank=3</p>";
        
        // Step 2: PLM/MES/工业软件 (131/132/133) - 产品方案的子栏目
        $updates = array(
            131 => array('fid' => 2, 'path' => '0-2-131'),
            132 => array('fid' => 2, 'path' => '0-2-132'),
            133 => array('fid' => 2, 'path' => '0-2-133'),
        );
        
        foreach ($updates as $typeid => $data) {
            M('type')->where("typeid=$typeid")->save(array(
                'fid' => $data['fid'],
                'path' => $data['path'],
                'ismenu' => 1,
                'drank' => 1
            ));
        }
        echo "<p>✅ Step 2: 131/132/133 的 fid=2, path 已更新为 '0-2-xxx'</p>";
        
        // Step 3: AI数字员工的子栏目 (111/112/113)
        $updates = array(
            111 => array('fid' => 4, 'path' => '0-4-111'),
            112 => array('fid' => 4, 'path' => '0-4-112'),
            113 => array('fid' => 4, 'path' => '0-4-113'),
        );
        
        foreach ($updates as $typeid => $data) {
            M('type')->where("typeid=$typeid")->save(array(
                'fid' => $data['fid'],
                'path' => $data['path'],
                'ismenu' => 1,
                'drank' => 1
            ));
        }
        echo "<p>✅ Step 3: 111/112/113 的 fid=4, path 已更新为 '0-4-xxx'</p>";
        
        // Step 4: 技术博客的子栏目 (121/122/123) - 确认
        $updates = array(
            121 => array('fid' => 12, 'path' => '0-12-121'),
            122 => array('fid' => 12, 'path' => '0-12-122'),
            123 => array('fid' => 12, 'path' => '0-12-123'),
        );
        
        foreach ($updates as $typeid => $data) {
            M('type')->where("typeid=$typeid")->save(array(
                'fid' => $data['fid'],
                'path' => $data['path'],
                'ismenu' => 1,
                'drank' => 1
            ));
        }
        echo "<p>✅ Step 4: 121/122/123 的 fid=12, path 已确认为 '0-12-xxx'</p>";
        
        // Step 5: 重新排序一级栏目的 drank
        $drankUpdates = array(
            1 => 1,   // 首页
            4 => 2,   // AI数字员工
            2 => 3,   // 产品方案
            10 => 4,  // 案例
            12 => 5,  // 技术博客
            13 => 6,  // 关于我们
        );
        
        foreach ($drankUpdates as $typeid => $drank) {
            M('type')->where("typeid=$typeid")->save(array('drank' => $drank));
        }
        echo "<p>✅ Step 5: 一级栏目排序已更新（首页→AI数字员工→产品方案→案例→技术博客→关于我们）</p>";
        
        // Step 6: 确保一级栏目正确
        M('type')->where("typeid=1")->save(array('ismenu' => 1, 'fid' => 0, 'path' => '0-1', 'drank' => 1));
        M('type')->where("typeid=4")->save(array('ismenu' => 1, 'fid' => 0, 'path' => '0-4', 'drank' => 2));
        M('type')->where("typeid=10")->save(array('ismenu' => 1, 'fid' => 0, 'path' => '0-10', 'drank' => 4));
        M('type')->where("typeid=12")->save(array('ismenu' => 1, 'fid' => 0, 'path' => '0-12', 'drank' => 5));
        M('type')->where("typeid=13")->save(array('ismenu' => 1, 'fid' => 0, 'path' => '0-13', 'drank' => 6));
        echo "<p>✅ Step 6: 一级栏目的 path 已确认</p>";
        
        // Step 7: 禁用其他不需要的一级栏目
        $keepIds = array(1, 2, 4, 10, 12, 13);
        M('type')->where("fid=0 AND typeid NOT IN (1, 2, 4, 10, 12, 13)")->save(array('ismenu' => 0));
        echo "<p>✅ Step 7: 其他一级栏目已禁用</p>";
        
        // 显示最终结果
        echo "<hr>";
        echo "<h3>📊 最终一级栏目（fid=0, ismenu=1）</h3>";
        $primary = M('type')->where('fid=0 AND ismenu=1')->order('drank ASC')->select();
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>drank</th><th>path</th></tr>";
        foreach ($primary as $col) {
            echo "<tr>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $col['typename'] . "</td>";
            echo "<td>" . $col['drank'] . "</td>";
            echo "<td>" . $col['path'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3>📊 最终子栏目（fid>0, ismenu=1）</h3>";
        $subColumns = M('type')->where('fid>0 AND ismenu=1')->order('fid ASC, drank ASC')->select();
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>fid</th><th>path</th><th>父级名称</th></tr>";
        foreach ($subColumns as $col) {
            $parent = M('type')->where("typeid=" . $col['fid'])->find();
            $parentName = $parent ? $parent['typename'] : '未知';
            echo "<tr>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $col['typename'] . "</td>";
            echo "<td>" . $col['fid'] . "</td>";
            echo "<td>" . $col['path'] . "</td>";
            echo "<td>" . $parentName . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<hr>";
        echo "<p style='color:green; font-weight:bold;'>✅ 修复完成！</p>";
        echo "<p>目标导航结构：</p>";
        echo "<pre>";
        echo "首页\n";
        echo "AI数字员工 → 内容数字员工 / 营销数字员工 / 客服数字员工\n";
        echo "产品方案 → PLM系统 / MES系统 / 工业软件\n";
        echo "案例\n";
        echo "技术博客 → 大模型 / 智能体 / AI应用\n";
        echo "关于我们（无子菜单）\n";
        echo "</pre>";
        
        echo "<h3>⚠️ 请执行以下操作：</h3>";
        echo "<ol>";
        echo "<li><strong>删除缓存目录</strong>：<br><code>Remove-Item D:\\scsaicms\\Web\\Runtime\\* -Recurse -Force</code><br><code>Remove-Item D:\\scsaicms\\Admin\\Runtime\\* -Recurse -Force</code></li>";
        echo "<li><strong>按 Ctrl + F5 强制刷新浏览器</strong></li>";
        echo "<li><a href='/' target='_blank'><strong>访问首页查看效果</strong></a></li>";
        echo "<li>鼠标悬停在 AI数字员工、产品方案、技术博客 上，查看下拉菜单是否显示</li>";
        echo "</ol>";
        
        echo "<p><a href='/index.php?s=Column/diagnose'>再次诊断栏目结构</a></p>";
        echo "<p><a href='/'>返回首页</a></p>";
    }
    
    /**
     * 诊断栏目结构 - 显示所有栏目的完整信息
     */
    public function diagnose() {
        header("Content-Type: text/html; charset=utf-8");
        
        echo "<h2>诊断栏目结构</h2>";
        echo "<p>这个页面显示所有栏目的完整信息（typeid, typename, fid, ismenu, drank, path）</p>";
        
        $allColumns = M('type')->order('fid ASC, drank ASC')->select();
        
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>fid (父级ID)</th><th>级别</th><th>ismenu</th><th>drank</th><th>path</th></tr>";
        
        foreach ($allColumns as $col) {
            $level = $col['fid'] == 0 ? '【一级】' : '【二级】';
            $isman = $col['ismenu'] == 1 ? '✅' : '❌';
            $fidWarning = ($col['fid'] == 0 && $col['typeid'] > 20) ? ' ⚠️ 应该是二级！' : '';
            
            echo "<tr>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $col['typename'] . "</td>";
            echo "<td>" . $col['fid'] . $fidWarning . "</td>";
            echo "<td>" . $level . "</td>";
            echo "<td>" . $isman . "</td>";
            echo "<td>" . $col['drank'] . "</td>";
            echo "<td>" . $col['path'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
        
        echo "<hr>";
        echo "<h3>⚠️ 可能的问题：</h3>";
        echo "<ul>";
        echo "<li>如果 <strong>111/112/113</strong> 的 <code>path='0-11-xxx'</code>，应该改为 <code>path='0-4-xxx'</code>（fid=4）</li>";
        echo "<li>如果 <strong>131/132/133</strong> 的 <code>path='0-13-xxx'</code>，应该改为 <code>path='0-2-xxx'</code>（fid=2）</li>";
        echo "<li>如果 <strong>path</strong> 字段与 <strong>fid</strong> 不匹配，下拉菜单不会显示</li>";
        echo "</ul>";
        
        echo "<p><a href='/index.php?s=Column/fixPath'>点击这里修复 fid 和 path</a></p>";
        echo "<p><a href='/index.php?s=Column/check'>查看栏目结构</a></p>";
        echo "<p><a href='/'>返回首页</a></p>";
    }
    
    /**
     * 检查栏目结构（一级栏目和二级栏目）
     */
    public function check() {
        header("Content-Type: text/html; charset=utf-8");
        
        echo "<h2>一级栏目（fid=0）</h2>";
        $primaryColumns = M('type')->where('fid=0')->order('drank ASC')->select();
        
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>ismenu</th><th>drank</th><th>path</th></tr>";
        foreach ($primaryColumns as $col) {
            $isman = $col['ismenu'] == 1 ? '✅ 显示' : '❌ 隐藏';
            echo "<tr>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $col['typename'] . "</td>";
            echo "<td>" . $isman . "</td>";
            echo "<td>" . $col['drank'] . "</td>";
            echo "<td>" . $col['path'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h2>二级栏目（子栏目 fid>0）</h2>";
        $subColumns = M('type')->where('fid > 0')->order('fid, drank ASC')->select();
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>父级ID</th><th>ismenu</th><th>drank</th><th>path</th></tr>";
        foreach ($subColumns as $col) {
            $isman = $col['ismenu'] == 1 ? '✅' : '❌';
            echo "<tr>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $col['typename'] . "</td>";
            echo "<td>" . $col['fid'] . "</td>";
            echo "<td>" . $isman . "</td>";
            echo "<td>" . $col['drank'] . "</td>";
            echo "<td>" . $col['path'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h2>活跃导航栏目（ismenu=1）</h2>";
        $activeNav = M('type')->where('ismenu=1')->order('fid ASC, drank ASC')->select();
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>ID</th><th>栏目名称</th><th>父级</th><th>drank</th><th>path</th></tr>";
        foreach ($activeNav as $col) {
            $prefix = $col['fid'] == 0 ? '[一级]' : '[二级]';
            echo "<tr>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $prefix . " " . $col['typename'] . "</td>";
            echo "<td>" . $col['fid'] . "</td>";
            echo "<td>" . $col['drank'] . "</td>";
            echo "<td>" . $col['path'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p>共 " . count($activeNav) . " 个活跃栏目（ismenu=1）</p>";
        echo "<p><a href='/index.php?s=Column/fixPath'>修复 fid 和 path</a></p>";
        echo "<p><a href='/index.php?s=Column/diagnose'>诊断栏目结构（查看 fid）</a></p>";
        echo "<p><a href='/'>返回首页</a></p>";
    }
    
    /**
     * 修复菜单显示 - 启用所有子菜单，并修复 fid 字段（旧方法，不修复 path）
     */
    public function fixMenu() {
        header("Content-Type: text/html; charset=utf-8");
        
        echo "<h2>修复菜单显示（旧方法，不修复 path）</h2>";
        echo "<p style='color:red'>⚠️ 此方法只修复 fid，不修复 path。建议使用 <a href='/index.php?s=Column/fixPath'>fixPath</a> 方法。</p>";
        
        // 1. 启用核心一级栏目
        $keepIds = array(1, 4, 10, 12, 13);
        foreach ($keepIds as $id) {
            M('type')->where("typeid=$id")->save(array('ismenu' => 1));
        }
        echo "<p>✅ 已启用 " . count($keepIds) . " 个核心一级栏目</p>";
        
        // 2. 修复子栏目的 fid（父级ID）
        $fidFixes = array(
            111 => 4,
            112 => 4,
            113 => 4,
            121 => 12,
            122 => 12,
            123 => 12,
            131 => 13,
            132 => 13,
            133 => 13,
        );
        
        foreach ($fidFixes as $id => $correctFid) {
            M('type')->where("typeid=$id")->save(array('fid' => $correctFid, 'drank' => 1));
        }
        echo "<p>✅ 已修复 " . count($fidFixes) . " 个子栏目的 fid（父级ID）</p>";
        
        // 3. 启用所有子栏目
        $submenuIds = array(111, 112, 113, 121, 122, 123, 131, 132, 133);
        foreach ($submenuIds as $id) {
            M('type')->where("typeid=$id")->save(array('ismenu' => 1, 'drank' => 1));
        }
        echo "<p>✅ 已启用 " . count($submenuIds) . " 个子栏目</p>";
        
        // 4. 隐藏非核心一级栏目
        $allPrimary = M('type')->where('fid=0')->select();
        $hideCount = 0;
        foreach ($allPrimary as $col) {
            if (!in_array($col['typeid'], $keepIds)) {
                M('type')->where("typeid=" . $col['typeid'])->save(array('ismenu' => 0));
                $hideCount++;
            }
        }
        echo "<p>📌 已隐藏 $hideCount 个非核心一级栏目</p>";
        
        // 5. 显示最终结果
        echo "<hr>";
        echo "<h3>✅ 修复完成！当前菜单状态：</h3>";
        
        echo "<h4>一级栏目（fid=0 且 ismenu=1）</h4>";
        $primary = M('type')->where('fid=0 AND ismenu=1')->order('drank ASC')->select();
        echo "<ul>";
        foreach ($primary as $col) {
            echo "<li>[" . $col['typeid'] . "] " . $col['typename'] . " (drank=" . $col['drank'] . ", path=" . $col['path'] . ")</li>";
        }
        echo "</ul>";
        
        echo "<h4>子栏目（fid>0 且 ismenu=1）</h4>";
        $children = M('type')->where('fid>0 AND ismenu=1')->order('fid, drank ASC')->select();
        echo "<ul>";
        foreach ($children as $col) {
            echo "<li>[" . $col['typeid'] . "] " . $col['typename'] . " (fid=" . $col['fid'] . ", path=" . $col['path'] . ")</li>";
        }
        echo "</ul>";
        
        echo "<hr>";
        echo "<p style='color:red'>⚠️ 注意：此方法只修复了 fid，path 可能仍然不正确。</p>";
        echo "<p>建议使用 <a href='/index.php?s=Column/fixPath'>fixPath</a> 方法同时修复 fid 和 path。</p>";
        echo "<p><a href='/index.php?s=Column/diagnose'>诊断栏目结构（查看 fid 是否正确）</a></p>";
        echo "<p><a href='/index.php?s=Column/check'>再次查看栏目结构</a></p>";
    }
    
    /**
     * 执行栏目简化 - 使用 ThinkPHP ORM（正确方式）
     */
    public function simplify() {
        header("Content-Type: text/html; charset=utf-8");
        
        echo "<h2>SCSAI CMS 栏目简化</h2>";
        
        // 保留的 5 个一级栏目 ID
        $keepIds = array(1, 4, 10, 12, 13);  // 首页、数字员工、案例、技术博客、关于我们
        
        // Step 1: 隐藏不需要的一级栏目
        $allPrimary = M('type')->where('fid=0')->select();
        $hideCount = 0;
        foreach ($allPrimary as $col) {
            if (!in_array($col['typeid'], $keepIds)) {
                M('type')->where("typeid=" . $col['typeid'])->save(array('ismenu' => 0));
                $hideCount++;
            }
        }
        echo "<p>📌 已隐藏 $hideCount 个一级栏目</p>";
        
        // Step 2: 确保 5 个保留栏目 ismenu=1
        foreach ($keepIds as $id) {
            M('type')->where("typeid=$id")->save(array('ismenu' => 1));
        }
        echo "<p>✅ 已确保 " . count($keepIds) . " 个核心栏目为启用状态</p>";
        
        // Step 3: 确保栏目排序正确
        $rankings = array(
            1 => 1,   // 首页
            4 => 2,   // 数字员工
            10 => 6,  // 案例
            12 => 4,  // 技术博客
            13 => 10, // 关于我们
        );
        foreach ($rankings as $id => $rank) {
            M('type')->where("typeid=$id")->save(array('drank' => $rank));
        }
        echo "<p>✅ 已更新栏目排序</p>";
        
        // Step 4: 最终验证
        echo "<hr>";
        echo "<h3>✅ 最终活跃导航栏目（fid=0 且 ismenu=1）</h3>";
        $final = M('type')->where('fid=0 AND ismenu=1')->order('drank ASC')->select();
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>#</th><th>ID</th><th>栏目名称</th><th>排序</th></tr>";
        $i = 1;
        foreach ($final as $col) {
            echo "<tr>";
            echo "<td>" . $i++ . "</td>";
            echo "<td>" . $col['typeid'] . "</td>";
            echo "<td>" . $col['typename'] . "</td>";
            echo "<td>" . $col['drank'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<hr>";
        echo "<p style='color:green'>栏目简化完成！</p>";
        echo "<p>请删除缓存目录：<code>D:\\scsaicms\\Web\\Runtime\\Cache\\</code></p>";
        echo "<p><a href='/index.php?s=Column/check'>再次查看栏目结构</a></p>";
        echo "<p><a href='/'>返回首页</a></p>";
    }
}
?>
