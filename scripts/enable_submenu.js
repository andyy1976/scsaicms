// 启用子栏目（ismenu=1）以便下拉菜单显示
const mysql = require('mysql2/promise');
async function enableSubmenu() {
  const conn = await mysql.createConnection({host:'82.156.40.94',user:'eastaiai',password:'alibaba',database:'eastaiai'});
  
  // 启用数字员工(4)的子栏目
  await conn.execute('UPDATE lvbo_type SET ismenu=1 WHERE typeid IN (111,112,113)');
  console.log('✅ 数字员工子栏目: 111(内容), 112(营销), 113(客服) 已启用');
  
  // 启用技术博客(12)的子栏目
  await conn.execute('UPDATE lvbo_type SET ismenu=1 WHERE typeid IN (121,122,123)');
  console.log('✅ 技术博客子栏目: 121(大模型), 122(智能体), 123(AI应用) 已启用');
  
  // 启用关于我们(13)的子栏目
  await conn.execute('UPDATE lvbo_type SET ismenu=1 WHERE typeid IN (131,132,133)');
  console.log('✅ 关于我们子栏目: 131(PLM系统), 132(MES系统), 133(工业软件) 已启用');
  
  // 验证
  const [subs] = await conn.execute('SELECT typeid, typename, ismenu FROM lvbo_type WHERE typeid IN (111,112,113,121,122,123,131,132,133)');
  console.log('\n子栏目状态:');
  subs.forEach(r => console.log('  typeid='+r.typeid+' ismenu='+r.ismenu+' '+r.typename));
  
  await conn.end();
  console.log('\n✅ 完成！刷新首页查看下拉菜单。');
}
enableSubmenu();