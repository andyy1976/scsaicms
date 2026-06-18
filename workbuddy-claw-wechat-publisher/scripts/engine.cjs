/**
 * WorkBuddy 微信发布器 - 核心引擎入口
 * 作为index.js的引擎入口文件
 */

const path = require('path');
const fs = require('fs');

// 优先使用v3引擎
const engineV3Path = path.join(__dirname, 'engine-v3.cjs');
const engineV2Path = path.join(__dirname, 'enhanced-engine.js');

let engine = null;

if (fs.existsSync(engineV3Path)) {
    const v3 = require('./engine-v3.cjs');
    engine = v3.main || v3;
} else if (fs.existsSync(engineV2Path)) {
    const v2 = require('./enhanced-engine.js');
    engine = typeof v2 === 'function' ? v2 : (v2.main || v2);
} else {
    console.error('❌ 找不到可用的引擎文件');
    process.exit(1);
}

/**
 * 引擎主入口函数
 * @param {string} command - 命令参数
 */
async function runEngine(command) {
    try {
        if (typeof engine === 'function') {
            await engine(command);
        } else {
            console.error('❌ 引擎不是可调用函数');
            process.exit(1);
        }
    } catch (error) {
        console.error('❌ 引擎执行失败:', error.message);
        throw error;
    }
}

module.exports = runEngine;
