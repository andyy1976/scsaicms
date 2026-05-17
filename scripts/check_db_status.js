// 检查数据库当前实际状态
var mysql = require('mysql2/promise');

async function check() {
    var conn;
    try {
        conn = await mysql.createConnection({
            host: '82.156.40.94',
            user: 'eastaiai',
            password: 'East@2024!AI',
            database: 'eastaiai'
        });
        
        // 查询所有 ismenu=1 的栏目
        var [rows] = await conn.query(
            "SELECT typeid, typename, fid, ismenu, drank, path FROM lvbo_type WHERE ismenu=1 ORDER BY fid ASC, drank ASC"
        );
        
        console.log('=== 所有 ismenu=1 的栏目 ===');
        console.log(JSON.stringify(rows, null, 2));
        
        console.log('\n=== 一级栏目 (fid=0) ===');
        var primary = rows.filter(r => r.fid === 0);
        primary.forEach(function(r) {
            console.log('[ID=' + r.typeid + '] ' + r.typename + ' | fid=' + r.fid + ' | path=' + r.path + ' | drank=' + r.drank);
        });
        
        console.log('\n=== 子栏目 (fid>0) ===');
        var sub = rows.filter(r => r.fid > 0);
        sub.forEach(function(r) {
            console.log('[ID=' + r.typeid + '] ' + r.typename + ' | fid=' + r.fid + ' | path=' + r.path + ' | drank=' + r.drank);
        });
        
        // 检查关键问题
        console.log('\n=== 问题检查 ===');
        var problems = [];
        rows.forEach(function(r) {
            // 检查 path 是否以正确的父级路径开头
            if (r.fid > 0) {
                var parent = rows.find(p => p.typeid === r.fid);
                var expectedPathPrefix = parent ? (parent.path + '-' + r.typeid) : ('0-' + r.fid + '-' + r.typeid);
                if (r.path !== expectedPathPrefix) {
                    problems.push({
                        typeid: r.typeid,
                        typename: r.typename,
                        current_path: r.path,
                        expected_path: expectedPathPrefix,
                        fid: r.fid
                    });
                }
            } else {
                // 一级栏目的 path 应该是 '0-typeid'
                var expectedPath = '0-' + r.typeid;
                if (r.path !== expectedPath) {
                    problems.push({
                        typeid: r.typeid,
                        typename: r.typename,
                        current_path: r.path,
                        expected_path: expectedPath,
                        fid: r.fid
                    });
                }
            }
        });
        
        if (problems.length > 0) {
            console.log('发现 ' + problems.length + ' 个 path/fid 不匹配问题:');
            problems.forEach(function(p) {
                console.log('  [ID=' + p.typeid + '] ' + p.typename + ': path="' + p.current_path + '" 应为 "' + p.expected_path + '" (fid=' + p.fid + ')');
            });
        } else {
            console.log('✅ 所有 path 和 fid 匹配正确！');
        }
        
        await conn.end();
    } catch(e) {
        console.error('Error:', e.message);
    }
}

check();
