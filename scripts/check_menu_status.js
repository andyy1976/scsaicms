const mysql = require('mysql2/promise');

async function checkMenuStatus() {
  const connection = await mysql.createConnection({
    host: '82.156.40.94',
    user: 'eastaiai',
    password: 'ea1XNc6pl',
    database: 'eastaiai'
  });

  console.log('=== 检查菜单状态 ===\n');

  // 1. 检查一级栏目（ismenu=1）
  console.log('【一级栏目 ismenu=1】');
  const [primary] = await connection.execute(
    'SELECT typeid, typename, ismenu, drank FROM lvbo_type WHERE fid=0 ORDER BY drank ASC'
  );
  primary.forEach(row => {
    console.log(`  typeid=${row.typeid}, typename=${row.typename}, ismenu=${row.ismenu}, drank=${row.drank}`);
  });

  // 2. 检查子栏目
  console.log('\n【子栏目】');
  const [children] = await connection.execute(
    'SELECT typeid, typename, fid, ismenu, drank FROM lvbo_type WHERE fid>0 ORDER BY fid, drank ASC'
  );
  children.forEach(row => {
    console.log(`  typeid=${row.typeid}, typename=${row.typename}, fid=${row.fid}, ismenu=${row.ismenu}, drank=${row.drank}`);
  });

  // 3. 检查将显示在前台的菜单
  console.log('\n【将显示在前台的菜单（ismenu=1）】');
  const [visible] = await connection.execute(
    'SELECT typeid, typename, fid, ismenu, drank FROM lvbo_type WHERE ismenu=1 ORDER BY fid ASC, drank ASC'
  );
  visible.forEach(row => {
    const prefix = row.fid === 0 ? '[一级]' : '  [二级]';
    console.log(`  ${prefix} typeid=${row.typeid}, typename=${row.typename}, ismenu=${row.ismenu}, drank=${row.drank}`);
  });

  await connection.end();
}

checkMenuStatus().catch(console.error);
