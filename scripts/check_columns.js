const mysql = require('mysql2/promise');

async function checkColumns() {
    const connection = await mysql.createConnection({
        host: '82.156.40.94',
        user: 'eastaiai',
        password: 'alibaba',
        database: 'eastaiai',
        port: 3306
    });

    console.log('=== 查询活跃栏目（一级栏目） ===');
    const [primaryColumns] = await connection.execute(
        'SELECT id, typename, status, parentid FROM lvbo_type WHERE status = 1 AND parentid = 0 ORDER BY id'
    );
    
    console.table(primaryColumns);

    console.log('\n=== 查询所有栏目（包括禁用的） ===');
    const [allColumns] = await connection.execute(
        'SELECT id, typename, status, parentid FROM lvbo_type ORDER BY parentid, id'
    );
    
    console.table(allColumns);

    console.log('\n=== 查询二级栏目（子栏目） ===');
    for (const col of primaryColumns) {
        const [subColumns] = await connection.execute(
            'SELECT id, typename, status, parentid FROM lvbo_type WHERE parentid = ? ORDER BY id',
            [col.id]
        );
        
        if (subColumns.length > 0) {
            console.log(`\n【${col.typename}】的子栏目：`);
            console.table(subColumns);
        } else {
            console.log(`\n【${col.typename}】没有子栏目`);
        }
    }

    await connection.end();
}

checkColumns().catch(console.error);
