const http = require('http');

// 通过CMS的API检查栏目数据
const options = {
  hostname: 'localhost',
  port: 80,
  path: '/index.php?s=/Api/health',
  method: 'GET',
  timeout: 5000
};

const req = http.request(options, (res) => {
  let data = '';
  res.on('data', chunk => data += chunk);
  res.on('end', () => console.log('Health:', data));
});
req.on('error', e => console.error('Error:', e.message));
req.end();
