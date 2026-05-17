const mysql = require('mysql2/promise');
async function check() {
  const conn = await mysql.createConnection({host:'82.156.40.94',user:'eastaiai',password:'alibaba',database:'eastaiai'});
  
  const [arts] = await conn.execute('SELECT aid, title, typeid FROM lvbo_article WHERE typeid=10 ORDER BY aid');
  console.log('案例(typeid=10) 共 '+arts.length+' 篇:');
  arts.forEach(r => console.log('  ['+r.aid+'] '+r.title.substring(0,50)));
  
  const [t] = await conn.execute("SELECT typeid, typename FROM lvbo_type WHERE typeid IN (111,112,113,121,122,123,131,132,133) ORDER BY typeid");
  console.log('\n新栏目名称:');
  t.forEach(r => console.log('  typeid='+r.typeid+' '+r.typename));
  
  // 总文章数
  const [cnt] = await conn.execute('SELECT COUNT(*) as total FROM lvbo_article');
  console.log('\n总文章数: '+cnt[0].total);
  
  await conn.end();
}
check();