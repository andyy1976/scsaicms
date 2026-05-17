const mysql = require('mysql2/promise');
async function check() {
  const conn = await mysql.createConnection({host:'82.156.40.94',user:'eastaiai',password:'alibaba',database:'eastaiai'});
  const [arts] = await conn.execute('SELECT typeid, COUNT(*) as cnt FROM lvbo_article GROUP BY typeid ORDER BY typeid');
  const [types] = await conn.execute('SELECT typeid, typename FROM lvbo_type');
  const map = {};
  types.forEach(r => map[r.typeid] = r.typename);
  console.log('=== 各栏目文章数 ===');
  arts.forEach(r => console.log(r.typeid+'\t'+(map[r.typeid]||'?')+'\t'+r.cnt+'篇'));
  await conn.end();
}
check();