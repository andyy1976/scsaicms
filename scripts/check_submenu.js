const mysql = require('mysql2/promise');

(async () => {
  const c = await mysql.createConnection({
    host: '82.156.40.94',
    user: 'eastaiai',
    password: 'Scsai2024!eastaiai',
    database: 'eastaiai'
  });
  
  const [rows] = await c.query(
    'SELECT typeid, typename, fid, ismenu, path, drank FROM lvbo_type ORDER BY path'
  );
  
  console.log('=== lvbo_type 完整数据 ===');
  console.log('typeid | typename              | fid | ismenu | path         | drank');
  console.log('-------|------------------------|-----|--------|--------------|------');
  rows.forEach(r => {
    console.log(
      String(r.typeid).padEnd(7),
      (r.typename || '').padEnd(24),
      String(r.fid).padEnd(4),
      String(r.ismenu).padEnd(7),
      (r.path || '').padEnd(14),
      r.drank
    );
  });
  
  // Check submenu logic
  console.log('\n=== 模拟 PublicAction submenu 查询 ===');
  const topMenu = rows.filter(r => r.fid === 0 && r.ismenu === 1);
  for (const m of topMenu) {
    const subs = rows.filter(r => Number(r.fid) === m.typeid && r.ismenu === 1);
    console.log(`[${m.typeid}] ${m.typename} -> 子菜单(${subs.length}): ${subs.map(s => '[' + s.typeid + ']' + s.typename).join(', ') || '(无)'}`);
  }
  
  await c.end();
})().catch(e => console.error(e.message));
