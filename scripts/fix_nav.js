// 设置栏目排序并清理重复
const mysql = require('mysql2/promise');
async function clean() {
  const conn = await mysql.createConnection({host:'82.156.40.94',user:'eastaiai',password:'alibaba',database:'eastaiai'});
  
  // 禁用 typeid=9（旧的关于我们）
  await conn.execute('UPDATE lvbo_type SET ismenu=0 WHERE typeid=9');
  
  // 设置排序顺序
  await conn.execute('UPDATE lvbo_type SET drank=1 WHERE typeid=1');  // 首页
  await conn.execute('UPDATE lvbo_type SET drank=2 WHERE typeid=4');  // AI数字员工
  await conn.execute('UPDATE lvbo_type SET drank=3 WHERE typeid=12'); // 技术博客
  await conn.execute('UPDATE lvbo_type SET drank=4 WHERE typeid=10'); // 案例
  await conn.execute('UPDATE lvbo_type SET drank=5 WHERE typeid=13'); // 关于我们
  
  const [r] = await conn.execute('SELECT typeid, typename, ismenu, fid, drank FROM lvbo_type WHERE ismenu=1 ORDER BY drank');
  console.log('最终导航栏目：');
  r.forEach(x => console.log('  typeid='+x.typeid+' drank='+x.drank+' '+x.typename));
  
  // 同时清理子栏目（如果父栏目 ismenu=0）
  await conn.execute(`
    UPDATE lvbo_type t1
    INNER JOIN lvbo_type t2 ON t1.fid = t2.typeid
    SET t1.ismenu = 0
    WHERE t2.ismenu = 0 AND t1.fid > 0
  `);
  
  const [all] = await conn.execute('SELECT typeid, typename, ismenu, fid, drank FROM lvbo_type WHERE ismenu=1 ORDER BY drank');
  console.log('\n最终导航（含子栏目隐藏）：');
  all.forEach(x => console.log('  typeid='+x.typeid+' fid='+x.fid+' drank='+x.drank+' '+x.typename));
  
  await conn.end();
  console.log('\n✅ 完成！清缓存后刷新首页。');
}
clean();