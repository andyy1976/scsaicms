const mysql = require('mysql2/promise');

(async () => {
  const conn = await mysql.createConnection({
    host: '82.156.40.94',
    user: 'eastaiai',
    password: 'eastaiai2024!',
    database: 'eastaiai'
  });

  const [rows] = await conn.query(
    'SELECT typeid, typename, fid, path, ismenu FROM lvbo_type ORDER BY typeid'
  );

  console.log('=== Current lvbo_type state ===');
  console.log('typeid | typename          | fid | path        | ismenu');
  console.log('-------+--------------------+-----+-------------+-------');
  
  let problems = [];
  rows.forEach(r => {
    const line = String(r.typeid).padStart(6) + ' | ' + 
                 r.typename.padEnd(18) + ' | ' + 
                 String(r.fid).padStart(3) + ' | ' + 
                 (r.path || '').padStart(11) + ' | ' + r.ismenu;
    
    // Problem: fid=0 AND ismenu=1 but NOT the homepage (typeid=1)
    if (r.fid === 0 && r.ismenu === 1 && r.typeid !== 1) {
      problems.push(r);
      line += '  <<< PROBLEM: shows as TOP-LEVEL menu!';
    }
    console.log(line);
  });

  console.log('\n=== Problems found: ' + problems.length + ' ===');
  if (problems.length > 0) {
    console.log('These columns have fid=0 + ismenu=1, so they appear as top-level nav:');
    problems.forEach(p => {
      console.log('  typeid=' + p.typeid + ' "' + p.typename + '" fid=' + p.fid + ' path=' + p.path);
    });
  }

  await conn.end();
})().catch(e => console.error('Error:', e.message));
