/**
 * 执行方案 B：创建"产品方案"一级栏目
 * 
 * 目标结构：
 * 首页 → AI数字员工 → 产品方案 → 案例 → 技术博客 → 关于我们
 * 
 * 子栏目分布：
 * - AI数字员工(ID=4): 111/112/113
 * - 产品方案(ID=2): 131/132/133
 * - 技术博客(ID=12): 121/122/123
 * - 关于我们(ID=13): 无子栏目
 */

const mysql = require('mysql2/promise');

async function fixPlanB() {
  const connection = await mysql.createConnection({
    host: '82.156.40.94',
    user: 'eastaiai',
    password: 'East@2024!AI',
    database: 'eastaiai'
  });

  console.log('✅ 连接数据库成功');

  try {
    // Step 1: 复用 ID=2，改名为"产品方案"，启用为一级栏目
    await connection.execute(`
      UPDATE lvbo_type 
      SET typename = '产品方案', ismenu = 1, fid = 0, drank = 3
      WHERE typeid = 2
    `);
    console.log('✅ Step 1: ID=2 已改名为"产品方案"，启用为一级栏目');

    // Step 2: 将 131/132/133 的 fid 从 13 改为 2（移到"产品方案"下）
    await connection.execute(`
      UPDATE lvbo_type 
      SET fid = 2, drank = 1
      WHERE typeid IN (131, 132, 133)
    `);
    console.log('✅ Step 2: 131/132/133 的 fid 已改为 2（产品方案）');

    // Step 3: 确保关于我们(ID=13)没有子栏目，保持一级栏目
    await connection.execute(`
      UPDATE lvbo_type 
      SET ismenu = 1, fid = 0, drank = 6
      WHERE typeid = 13
    `);
    console.log('✅ Step 3: 关于我们(ID=13)保持一级栏目，无子栏目');

    // Step 4: 重新排序一级栏目的 drank
    const drankUpdates = [
      [1, 1],   // 首页
      [4, 2],   // AI数字员工
      [2, 3],   // 产品方案
      [10, 4],  // 案例
      [12, 5],  // 技术博客
      [13, 6],  // 关于我们
    ];

    for (const [typeid, drank] of drankUpdates) {
      await connection.execute(`
        UPDATE lvbo_type SET drank = ? WHERE typeid = ?
      `, [drank, typeid]);
    }
    console.log('✅ Step 4: 一级栏目排序已更新（首页→AI数字员工→产品方案→案例→技术博客→关于我们）');

    // Step 5: 确保所有子栏目的 ismenu=1 和 drank 正确
    // AI数字员工的子栏目 (111/112/113)
    await connection.execute(`
      UPDATE lvbo_type 
      SET fid = 4, ismenu = 1, drank = 1
      WHERE typeid IN (111, 112, 113)
    `);
    console.log('✅ Step 5a: 111/112/113 已确认 fid=4（AI数字员工）');

    // 技术博客的子栏目 (121/122/123)
    await connection.execute(`
      UPDATE lvbo_type 
      SET fid = 12, ismenu = 1, drank = 1
      WHERE typeid IN (121, 122, 123)
    `);
    console.log('✅ Step 5b: 121/122/123 已确认 fid=12（技术博客）');

    // 产品方案的子栏目 (131/132/133) - 再次确认
    await connection.execute(`
      UPDATE lvbo_type 
      SET fid = 2, ismenu = 1, drank = 1
      WHERE typeid IN (131, 132, 133)
    `);
    console.log('✅ Step 5c: 131/132/133 已确认 fid=2（产品方案）');

    // Step 6: 禁用其他不需要的一级栏目
    const keepIds = [1, 2, 4, 10, 12, 13];
    await connection.execute(`
      UPDATE lvbo_type 
      SET ismenu = 0 
      WHERE fid = 0 AND typeid NOT IN (1, 2, 4, 10, 12, 13)
    `);
    console.log('✅ Step 6: 其他一级栏目已禁用');

    // Step 7: 查询最终结果
    console.log('\n📊 最终一级栏目（fid=0, ismenu=1）：');
    const [primary] = await connection.execute(`
      SELECT typeid, typename, drank 
      FROM lvbo_type 
      WHERE fid = 0 AND ismenu = 1 
      ORDER BY drank ASC
    `);
    primary.forEach(row => {
      console.log(`  [${row.typeid}] ${row.typename} (drank=${row.drank})`);
    });

    console.log('\n📊 最终子栏目（fid>0, ismenu=1）：');
    const [subColumns] = await connection.execute(`
      SELECT typeid, typename, fid, drank 
      FROM lvbo_type 
      WHERE fid > 0 AND ismenu = 1 
      ORDER BY fid ASC, drank ASC
    `);
    subColumns.forEach(row => {
      console.log(`  [${row.typeid}] ${row.typename} (fid=${row.fid})`);
    });

    console.log('\n✅ 方案 B 执行完成！请清理 ThinkPHP 缓存后刷新浏览器。');

  } catch (error) {
    console.error('❌ 错误:', error.message);
  } finally {
    await connection.end();
  }
}

fixPlanB();