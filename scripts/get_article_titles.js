// 获取所有文章标题用于手动分配
const mysql = require('mysql2/promise');
async function getTitles() {
  const conn = await mysql.createConnection({host:'82.156.40.94',user:'eastaiai',password:'alibaba',database:'eastaiai'});
  
  // Get all articles with their category
  const [arts] = await conn.execute(`
    SELECT a.aid, a.title, a.typeid, t.typename, t.fid,
           (SELECT typename FROM lvbo_type WHERE typeid = t.fid) as parent_typename
    FROM lvbo_article a
    JOIN lvbo_type t ON a.typeid = t.typeid
    ORDER BY t.typename, a.aid
  `);
  
  console.log('=== 所有文章（共 '+arts.length+' 篇）===\n');
  let currentType = '';
  arts.forEach((r, i) => {
    if (r.typename !== currentType) {
      currentType = r.typename;
      console.log('【'+r.typename+'】(typeid='+r.typeid+')');
    }
    console.log('  '+(i+1)+'. ['+r.aid+'] '+r.title);
  });
  
  // New subcategory mapping
  console.log('\n\n=== 新栏目结构 ===');
  console.log('AI数字员工(4): 111=内容数字员工, 112=营销数字员工, 113=客服数字员工');
  console.log('技术博客(12): 121=大模型, 122=智能体, 123=AI应用');
  console.log('关于我们(13): 131=PLM系统, 132=MES系统, 133=工业软件');
  console.log('案例(10): 保持不变，现有8篇');
  
  await conn.end();
}
getTitles();