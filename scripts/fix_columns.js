/**
 * 修复 CMS 栏目（lvbo_type）
 * 字段名是 typeid（不是 id），ismenu（不是 status）
 * 
 * lvbo_type 表字段：
 * - typeid: 主键
 * - typename: 栏目名称
 * - ismenu: 1=显示在导航，0=隐藏
 * - fid: 父级ID（0=一级栏目）
 * - drank: 排序
 */

const mysql = require('mysql2/promise');

const dbConfig = {
  host: '82.156.40.94',
  user: 'eastaiai',
  password: 'alibaba',
  database: 'eastaiai',
  port: 3306,
  charset: 'utf8mb4'
};

async function fixColumns() {
  let conn;
  try {
    conn = await mysql.createConnection(dbConfig);

    // 1. 查看当前所有栏目
    const [all] = await conn.execute('SELECT typeid, typename, ismenu, fid, drank FROM lvbo_type ORDER BY typeid');
    console.log('当前所有栏目：');
    all.forEach(r => console.log(`  typeid=${r.typeid} fid=${r.fid} ismenu=${r.ismenu} drank=${r.drank} ${r.typename}`));

    // 2. 保留5个核心栏目，禁用其他
    // 目标：首页(1)、数字员工(4)、案例(10)、技术博客(12)、关于我们(13)
    // 其他全部 ismenu=0
    const keepIds = [1, 4, 10, 12, 13];
    
    console.log('\n设置 ismenu=0（非核心栏目）...');
    await conn.execute(`UPDATE lvbo_type SET ismenu=0 WHERE typeid NOT IN (${keepIds.join(',')})`);
    
    console.log('设置 ismenu=1（核心栏目）...');
    await conn.execute(`UPDATE lvbo_type SET ismenu=1 WHERE typeid IN (${keepIds.join(',')})`);

    // 3. 清理子栏目 fid 引用
    // 如果父栏目被禁用，子栏目也隐藏
    console.log('\n禁用没有启用父栏目的子栏目...');
    await conn.execute(`
      UPDATE lvbo_type t1
      INNER JOIN lvbo_type t2 ON t1.fid = t2.typeid
      SET t1.ismenu = 0
      WHERE t2.ismenu = 0 AND t1.fid > 0
    `);

    // 4. 重新检查最终结果
    console.log('\n最终栏目状态（ismenu=1）：');
    const [active] = await conn.execute('SELECT typeid, typename, fid, ismenu, drank FROM lvbo_type WHERE ismenu=1 ORDER BY drank, typeid');
    active.forEach(r => console.log(`  typeid=${r.typeid} fid=${r.fid} drank=${r.drank} → ${r.typename}`));

    console.log('\n全部栏目状态：');
    const [final] = await conn.execute('SELECT typeid, typename, ismenu, fid FROM lvbo_type ORDER BY typeid');
    final.forEach(r => console.log(`  typeid=${r.typeid} ismenu=${r.ismenu} fid=${r.fid} → ${r.typename}`));

    console.log('\n✅ 完成！请清缓存后刷新首页。');
  } catch (err) {
    console.error('❌ 错误:', err.message);
  } finally {
    if (conn) await conn.end();
  }
}

fixColumns();