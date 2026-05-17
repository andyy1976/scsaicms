/**
 * 简化 CMS 栏目（分类）
 * 将 lvbo_type 表中的栏目从 13 个精简到 5 个
 * 保留：首页、数字员工、技术博客、案例展示、关于我们
 * 禁用其他栏目（设置 status = 0）
 */

const mysql = require('mysql2/promise');

// 数据库配置
const dbConfig = {
  host: '82.156.40.94',
  user: 'eastaiai',
  password: 'alibaba',
  database: 'eastaiai',
  port: 3306,
  charset: 'utf8mb4'
};

async function simplifyColumns() {
  let connection;
  
  try {
    // 连接数据库
    console.log('🔗 连接数据库...');
    connection = await mysql.createConnection(dbConfig);
    console.log('✅ 数据库连接成功！');
    
    // 1. 查看当前所有栏目
    console.log('\n📋 当前栏目列表：');
    const [rows] = await connection.execute('SELECT id, typename, status FROM lvbo_type ORDER BY id');
    console.table(rows);
    
    // 2. 定义要保留的栏目（ID）
    // 根据之前 API 返回的栏目列表：
    // ID: 1 = 首页
    // ID: 4 = AI数字员工
    // ID: 5 = 数字员工
    // ID: 10 = 案例
    // 需要创建：技术博客、关于我们
    const keepIds = [1, 4, 5, 10]; // 保留这些栏目
    
    // 3. 禁用其他栏目（设置 status = 0）
    console.log('\n🗑️  禁用不需要的栏目...');
    const [updateResult] = await connection.execute(
      'UPDATE lvbo_type SET status = 0 WHERE id NOT IN (?)',
      [keepIds]
    );
    console.log(`✅ 已禁用 ${updateResult.affectedRows} 个栏目`);
    
    // 4. 重命名栏目，聚焦"数字员工"
    console.log('\n✏️  重命名栏目...');
    
    // 合并"AI数字员工"和"数字员工"为一个栏目
    await connection.execute(
      'UPDATE lvbo_type SET typename = "数字员工", status = 1 WHERE id = 4'
    );
    console.log('✅ ID: 4 重命名为"数字员工"');
    
    // 禁用 ID: 5（数字员工），使用 ID: 4 作为主栏目
    await connection.execute(
      'UPDATE lvbo_type SET status = 0 WHERE id = 5'
    );
    console.log('✅ ID: 5 已禁用（合并到 ID: 4）');
    
    // 5. 创建"技术博客"栏目（如果不存在）
    console.log('\n📝 创建"技术博客"栏目...');
    const [existing] = await connection.execute(
      'SELECT id FROM lvbo_type WHERE typename = "技术博客"'
    );
    
    if (existing.length === 0) {
      await connection.execute(
        'INSERT INTO lvbo_type (typename, status, site_id) VALUES ("技术博客", 1, 1)'
      );
      console.log('✅ 已创建"技术博客"栏目');
    } else {
      console.log('ℹ️ "技术博客"栏目已存在');
    }
    
    // 6. 创建"关于我们"栏目（如果不存在）
    console.log('\n📝 创建"关于我们"栏目...');
    const [existingAbout] = await connection.execute(
      'SELECT id FROM lvbo_type WHERE typename = "关于我们"'
    );
    
    if (existingAbout.length === 0) {
      await connection.execute(
        'INSERT INTO lvbo_type (typename, status, site_id) VALUES ("关于我们", 1, 1)'
      );
      console.log('✅ 已创建"关于我们"栏目');
    } else {
      console.log('ℹ️ "关于我们"栏目已存在');
    }
    
    // 7. 查看最终栏目列表
    console.log('\n📋 最终栏目列表：');
    const [finalRows] = await connection.execute('SELECT id, typename, status FROM lvbo_type WHERE status = 1 ORDER BY id');
    console.table(finalRows);
    
    console.log('\n🎉 栏目简化完成！');
    console.log('保留的栏目：');
    finalRows.forEach(row => {
      console.log(`  - ID: ${row.id}, 名称: ${row.typename}`);
    });
    
  } catch (error) {
    console.error('❌ 错误：', error.message);
    console.error('详细错误：', error);
  } finally {
    if (connection) {
      await connection.end();
      console.log('🔌 数据库连接已关闭');
    }
  }
}

// 执行
simplifyColumns();
