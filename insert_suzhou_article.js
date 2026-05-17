/**
 * 插入苏州市"AI+制造"应用场景需求清单文章
 * 使用Node.js直接连接MySQL
 */

const mysql = require('mysql2/promise');

// 数据库配置
const dbConfig = {
    host: '82.156.40.94',
    user: 'eastaiai',
    password: 'Eastaiai@2024',
    database: 'eastaiai',
    charset: 'utf8mb4'
};

const TABLE_PREFIX = 'lvbo_';

// 文章内容
const title = '苏州市"AI+制造"应用场景需求清单（第一批）';
const content = `<p>本文档为苏州市首批"AI+制造"应用场景需求清单的完整规范化整理版，全量清单共计<strong>65项需求</strong>，覆盖<strong>电子信息、装备制造、新能源、生物医药、冶金业、纺织业、轻工业、其他</strong>共8大行业领域。</p>

<h2>整体行业分布统计</h2>
<table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse;width:100%;">
<tr style="background:#f5f5f5;"><th>行业类别</th><th>需求数量</th><th>对应序号范围</th></tr>
<tr><td>电子信息</td><td>14项</td><td>1-14</td></tr>
<tr><td>装备制造</td><td>20项</td><td>15-19、22-36</td></tr>
<tr><td>新能源</td><td>19项</td><td>37-55</td></tr>
<tr><td>生物医药</td><td>4项</td><td>56-59</td></tr>
<tr><td>冶金业</td><td>2项</td><td>60-61</td></tr>
<tr><td>纺织业</td><td>1项</td><td>62</td></tr>
<tr><td>轻工业</td><td>1项</td><td>63</td></tr>
<tr><td>其他</td><td>2项</td><td>64-65</td></tr>
<tr style="background:#e8f4f8;"><td><strong>合计</strong></td><td><strong>65项</strong></td><td><strong>1-65</strong></td></tr>
</table>
<p><em>注：序号20、21项无有效内容，实际可落地完整需求共63项。</em></p>

<h2>分行业需求核心特征</h2>

<h3>📱 电子信息行业（14项）</h3>
<p><strong>核心诉求：</strong>解决多品种小批量生产模式下的人工依赖度高、客户响应慢、技术经验难沉淀问题。</p>
<p><strong>需求方向：</strong>AI快速报价、设备预测性维护、工艺参数智能寻优、图纸AI自动识别与建模、AI驱动的敏捷BI、代码自动化开发。</p>

<h3>⚙️ 装备制造行业（20项）</h3>
<p><strong>核心诉求：</strong>破解高端装备制造多品种小批量、工艺复杂、人工经验依赖强、换产效率低的行业痛点。</p>
<p><strong>需求方向：</strong>多智能体AI加工全流程管控、柔性生产智能排程、AI视觉全流程质检、2D图纸3D还原与BOM自动生成、设备预测性维护、标准化文档AI自动生成。</p>

<h3>🔋 新能源行业（19项）</h3>
<p><strong>核心诉求：</strong>围绕储能、光伏等新能源核心产品，实现全生命周期AI赋能，兼顾生产提质降本、运营收益最大化、双碳合规。</p>
<p><strong>需求方向：</strong>产线设备智能监控、具身智能柔性生产应用、多能源协同智能管控、全生命周期碳资产管理、储能电池SOH预测与智能调度。</p>

<h3>💊 生物医药行业（4项）</h3>
<p><strong>核心诉求：</strong>解决医疗器械检测人工依赖度高、医药研发周期长成本高的核心痛点。</p>
<p><strong>需求方向：</strong>医疗器械AI自动质检、染色体核型AI智能分析、企业级研发知识库建设、AI辅助RNA药物序列设计。</p>

<h3>🏭 冶金业（2项）</h3>
<p><strong>核心诉求：</strong>破解钢铁材料研发专家经验依赖、检测人工效率低的痛点。</p>
<p><strong>需求方向：</strong>AI驱动钢铁材料成分与工艺逆向设计、金相高倍智能检测与自动评级。</p>

<h3>🧵 纺织业、轻工业及其他（4项）</h3>
<p><strong>核心诉求：</strong>解决细分行业的特定人工依赖痛点，实现生产与运营的单点智能化突破。</p>
<p><strong>需求方向：</strong>多语言AI翻译智能体、注塑机械臂AI调度优化、通用型设备运维与生产全流程AI管控。</p>

<h2>典型应用场景示例</h2>

<h3>场景1：电子信息 - AI快速报价系统</h3>
<p>公司业务以小批量多品种的包装盒为主，目前的报价流程需要涉及到结构制图、采购询价、物料计算，工序分析。工作量大，完全依赖人工经验，不能快速响应客户需求。<strong>需引入AI对物料成本、工序成本、物流成本、产品结构等进行快速分析，精准、快速的报价。</strong></p>

<h3>场景2：装备制造 - 智能切削工作站</h3>
<p>高端铝合金铸件内部型腔、油路或水道的多余浇冒口、飞边毛刺清除作业，面临质量一致性差、效率瓶颈突出、柔性生产能力缺失、人员依赖与安全风险四大核心痛点。<strong>需构建一个"感知-决策-执行-优化"一体化的AI智能切削工作站。</strong></p>

<h3>场景3：新能源 - 储能电池SOH预测</h3>
<p>针对储能电池管理系统（BMS），需通过AI技术实现电池健康状态（SOH）精准预测，实时监测电池电芯、模组的运行数据，提前识别电池衰减、故障风险，量化电池健康程度，<strong>为储能电池的运维、梯次利用及更换提供数据支撑，提升储能系统整体运行安全性和使用寿命。</strong></p>

<h3>场景4：生物医药 - 染色体核型AI分析</h3>
<p>面向医学遗传学与临床检验领域中染色体核型分析自动化、智能化水平不足的问题，依托人工智能与医学影像处理技术，构建高效、精准的染色体核型分析智能应用场景，<strong>实现染色体核型分析由"人工主导"向"智能辅助决策"的转变。</strong></p>

<h2>完整需求清单获取</h2>
<p>如需获取完整的65项需求清单详细内容，请联系我们的业务团队，我们将为您提供：</p>
<ul>
<li>✅ 完整的需求清单Excel/Word版本</li>
<li>✅ 分行业解决方案匹配建议</li>
<li>✅ 供需对接资源引荐</li>
<li>✅ 政策落地咨询服务</li>
</ul>

<p style="text-align:center;margin-top:30px;">
<a href="/index.php?s=Lists/index/typeid/112" style="display:inline-block;padding:12px 30px;background:#007bff;color:#fff;text-decoration:none;border-radius:4px;">了解更多AI+制造解决方案</a>
</p>`;

// 文章数据
const articleData = {
    typeid: 113, // 案例栏目
    title: title,
    content: content,
    addtime: Math.floor(Date.now() / 1000),
    updatetime: Math.floor(Date.now() / 1000),
    status: 1,
    hits: Math.floor(Math.random() * 400) + 100,
    author: 'SCSAI编辑部',
    source: '苏州市工业和信息化局',
    copyfrom: '苏州市工信局',
    keywords: 'AI+制造,智能制造,工业互联网,数字化转型,苏州,应用场景',
    description: '苏州市首批"AI+制造"应用场景需求清单，覆盖8大行业领域65项需求，为AI技术供应商与制造企业搭建供需对接桥梁。'
};

async function insertArticle() {
    let connection;
    try {
        // 连接数据库
        connection = await mysql.createConnection(dbConfig);
        console.log('✅ 数据库连接成功');

        // 检查是否已存在
        const [existing] = await connection.execute(
            `SELECT aid FROM ${TABLE_PREFIX}article WHERE title = ?`,
            [title]
        );

        if (existing.length > 0) {
            console.log(`文章已存在，文章ID: ${existing[0].aid}`);
            console.log(`访问链接: /index.php?s=/articles/${existing[0].aid}.html`);
            return;
        }

        // 插入文章
        const [result] = await connection.execute(
            `INSERT INTO ${TABLE_PREFIX}article 
            (typeid, title, content, addtime, updatetime, status, hits, author, source, copyfrom, keywords, description) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
            [
                articleData.typeid,
                articleData.title,
                articleData.content,
                articleData.addtime,
                articleData.updatetime,
                articleData.status,
                articleData.hits,
                articleData.author,
                articleData.source,
                articleData.copyfrom,
                articleData.keywords,
                articleData.description
            ]
        );

        const aid = result.insertId;
        console.log('\n✅ 文章插入成功！');
        console.log(`文章ID: ${aid}`);
        console.log(`标题: ${title}`);
        console.log(`栏目ID: ${articleData.typeid} (案例栏目)`);
        console.log(`访问链接: /index.php?s=/articles/${aid}.html`);

    } catch (error) {
        console.error('❌ 错误:', error.message);
    } finally {
        if (connection) {
            await connection.end();
        }
    }
}

insertArticle();
