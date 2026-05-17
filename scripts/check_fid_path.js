/**
 * 检查 lvbo_type 表的 fid 和 path 字段
 * 运行: node check_fid_path.js
 */

const mysql = require('mysql2/promise');

async function main() {
  let connection;
  try {
    connection = await mysql.createConnection({
      host: '82.156.40.94',
      user: 'eastaiai',
      password: 'eastaiai',
      database: 'eastaiai',
      port: 3306
    });

    console.log('✅ 数据库连接成功\n');

    // 检查关键栏目的 fid 和 path
    const typeids = [1, 2, 4, 10, 12, 13, 111, 112, 113, 121, 122, 123, 131, 132, 133];
    
    const [rows] = await connection.execute(
      `SELECT typeid, typename, fid, path, ismenu, drank FROM lvbo_type WHERE typeid IN (${typeids.join(',')}) ORDER BY typeid`
    );

    console.log('📊 关键栏目 fid 和 path 字段检查：\n');
    console.log('typeid | typename | fid | path | ismenu | drank');
    console.log('-'.repeat(80));

    rows.forEach(row => {
      console.log(
        `${String(row.typeid).padEnd(6)} | ${row.typename.padEnd(20)} | ${String(row.fid).padEnd(4)} | ${row.path.padEnd(12)} | ${row.ismenu} | ${row.drank}`
      );
    });

    console.log('\n✅ 预期结果：');
    console.log('  - typeid=2 (产品方案): fid=0, path=0-2');
    console.log('  - typeid=131/132/133: fid=2, path=0-2-xxx');
    console.log('  - typeid=111/112/113: fid=4, path=0-4-xxx');
    console.log('  - typeid=121/122/123: fid=12, path=0-12-xxx');

    // 检查子菜单查询
    console.log('\n🔍 检查子菜单查询（模拟 PublicAction.class.php）：\n');
    
    const [menu] = await connection.execute(
      `SELECT * FROM lvbo_type WHERE ismenu=1 ORDER BY drank asc`
    );

    console.log(`一级栏目数量: ${menu.length}`);
    
    for (const item of menu) {
      const [submenu] = await connection.execute(
        `SELECT * FROM lvbo_type WHERE fid=${item.typeid} AND ismenu=1 ORDER BY drank asc`
      );
      
      if (submenu.length > 0) {
        console.log(`  ✅ ${item.typename} (typeid=${item.typeid}) 有 ${submenu.length} 个子菜单:`);
        submenu.forEach(sub => {
          console.log(`      - ${sub.typename} (typeid=${sub.typeid}, fid=${sub.fid}, path=${sub.path})`);
        });
      } else {
        console.log(`  ❌ ${item.typename} (typeid=${item.typeid}) 没有子菜单`);
      }
    }

    console.log('\n🔧 如果子菜单没有显示，请执行：');
    console.log('  1. 访问 http://localhost/index.php?s=Column/fixPath');
    console.log('  2. 清理缓存: Remove-Item D:\\scsaicms\\Web\\Runtime\\Cache\\* -Recurse -Force');
    console.log('  3. 刷新浏览器 (Ctrl+F5)');

  } catch (error) {
    console.error('❌ 错误:', error.message);
  } finally {
    if (connection) await connection.end();
  }
}

main();