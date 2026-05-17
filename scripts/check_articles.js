// 检查文章分布
const mysql = require('mysql2/promise');
async function check() {
  const conn = await mysql.createConnection({host:'82.156.40.94',user:'eastaiai',password:'alibaba',database:'eastaiai'});
  
  // Check articles by typeid
  const [arts] = await conn.execute('SELECT typeid, COUNT(*) as cnt FROM lvbo_article GROUP BY typeid ORDER BY cnt DESC LIMIT 30');
  console.log('=== 文章分布 ===');
  arts.forEach(r => console.log('typeid='+r.typeid+' => '+r.cnt+'篇'));
  
  // Get typeid -> typename mapping
  const [types] = await conn.execute('SELECT typeid, typename, fid FROM lvbo_type');
  const typeMap = {};
  types.forEach(r => typeMap[r.typeid] = r);
  
  console.log('\n=== 栏目名称 ===');
  arts.forEach(r => {
    const t = typeMap[r.typeid];
    if (t) console.log('typeid='+r.typeid+' = '+t.typename+' (fid='+t.fid+') => '+r.cnt+'篇');
  });
  
  await conn.end();
  console.log('\n完成！');
}
check();