<?php
/**
 * 演示文章插入脚本 - 营销数字员工(112) + 客服数字员工(113)
 * ⚠️ 执行后请删除本文件
 */

$host = '82.156.40.94';
$user = 'eastaiai';
$pass = 'alibaba';
$db   = 'eastaiai';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('DB连接失败: ' . $conn->connect_error);
}
$conn->query("SET NAMES utf8");
$conn->set_charset('utf8');

// 只过滤emoji（4字节UTF-8字符），保留中文和其他内容
function strip_emoji($str) {
    // emoji的UTF-8编码以 F0 9F 80-BF 开头（4字节）
    return preg_replace('/[\x{1F000}-\x{1FFFF}]/u', '', $str);
}

// 获取当前最大aid
$res = $conn->query("SELECT MAX(aid) as max_aid FROM lvbo_article");
$row = $res->fetch_assoc();
echo "<h2>当前最大aid: {$row['max_aid']}，将从 aid=" . (intval($row['max_aid']) + 1) . " 开始插入</h2><hr>";

$articles = array(
    array(
        'title'       => '营销数字员工 - 产品介绍',
        'content'     => '<h2>营销数字员工 - 让获客自动化</h2>
<p>营销数字员工是专为市场团队打造的AI智能助手，能够自动完成从<strong>内容生成->多平台发布->线索收集->效果分析</strong>的全流程营销工作。</p>
<h3>核心功能</h3>
<ul>
    <li><strong>自动化内容生成</strong>：基于热点话题自动生成营销文案，支持微信公众号、小红书、抖音等多平台格式</li>
    <li><strong>智能评分筛选</strong>：AI对热点话题进行病毒式传播潜力评分，优先生成高价值内容</li>
    <li><strong>精准获客</strong>：自动在文章中添加引流入口，收集潜在客户信息</li>
    <li><strong>效果分析</strong>：实时追踪各平台阅读量、转化率，优化营销策略</li>
</ul>
<h3>演示视频</h3>
<p><strong>即将上线</strong>：我们会录制完整的操作演示视频，展示从热点采集到内容发布的全流程。</p>
<p>视频将发布在：<a href="#" target="_blank">微信公众号</a> | <a href="#" target="_blank">抖音</a>（链接待更新）</p>
<h3>适用场景</h3>
<ul>
    <li>需要高频输出内容的B2B企业市场部</li>
    <li>希望提升品牌曝光但缺乏内容创作能力的团队</li>
    <li>需要多渠道分发内容的营销团队</li>
</ul>
<p style="margin-top:30px;"><a href="/index.php?s=lists&typeid=112" style="padding:10px 30px;background:#1E90FF;color:#fff;text-decoration:none;border-radius:5px;">查看详情</a></p>',
        'description' => '营销数字员工产品介绍，自动化内容生成与精准获客',
        'typeid'      => 112,
    ),
    array(
        'title'       => '演示视频 - 营销数字员工操作演示',
        'content'     => '<h2>营销数字员工操作演示视频</h2>
<p>本视频完整演示营销数字员工从<strong>热点采集->AI评分->内容生成->多平台发布</strong>的全流程。</p>
<div style="background:#f5f5f5;padding:20px;border-radius:10px;text-align:center;margin:20px 0;">
    <h3 style="color:#999;">演示视频即将上线</h3>
    <p>我们正在录制详细的操作演示视频，将展示：</p>
    <ul style="text-align:left;display:inline-block;">
        <li>如何配置热点采集源（微博、知乎、抖音等）</li>
        <li>AI如何对热点进行病毒式传播潜力评分</li>
        <li>一键生成多平台格式内容（公众号/小红书/抖音）</li>
        <li>自动发布到CMS并同步到各平台草稿箱</li>
        <li>效果追踪与数据分析面板</li>
    </ul>
    <p style="margin-top:20px;"><strong>视频发布渠道：</strong></p>
    <p>微信公众号：[待更新链接]</p>
    <p>抖音：[待更新链接]</p>
</div>
<h3>预约演示</h3>
<p>如果您希望提前体验营销数字员工的功能，可以：</p>
<ul>
    <li>添加微信：[待更新微信号]</li>
    <li>发送邮件至：[待更新邮箱]</li>
    <li>拨打咨询热线：<strong>186-0192-1816</strong></li>
</ul>',
        'description' => '营销数字员工操作演示视频，完整展示从热点采集到多平台发布全流程',
        'typeid'      => 112,
    ),
    array(
        'title'       => '成功案例 - 企业如何使用营销数字员工提升获客效率',
        'content'     => '<h2>成功案例 - 营销数字员工助力企业获客</h2>
<h3>案例一：某工业互联网平台</h3>
<p><strong>挑战</strong>：市场团队仅3人，需要每日输出5篇以上优质内容，覆盖微信公众号、官网博客、知乎等平台。</p>
<p><strong>解决方案</strong>：部署营销数字员工，自动采集行业热点->AI生成初稿->人工审核->自动发布。</p>
<p><strong>效果：</strong></p>
<ul>
    <li>内容产出效率提升 <strong>500%</strong></li>
    <li>官网流量增长 <strong>200%</strong></li>
    <li>获客成本降低 <strong>40%</strong></li>
</ul>
<h3>案例二：某PLM软件厂商</h3>
<p><strong>挑战</strong>：B2B决策周期长，需要通过持续的内容输出建立品牌认知。</p>
<p><strong>解决方案</strong>：使用营销数字员工定期发布技术深度文章，并在文章中嵌入产品试用申请入口。</p>
<p><strong>效果：</strong></p>
<ul>
    <li>公众号粉丝增长 <strong>150%</strong></li>
    <li>线索转化率提升 <strong>80%</strong></li>
    <li>销售团队接收到的有效线索数量翻倍</li>
</ul>
<h3>获取完整案例报告</h3>
<p>如果您希望了解更详细的实施过程和效果数据，请联系我们的客户成功团队：</p>
<ul>
    <li>微信：[待更新]</li>
    <li>邮箱：[待更新]</li>
</ul>',
        'description' => '营销数字员工成功案例，展示企业如何使用AI提升获客效率',
        'typeid'      => 112,
    ),
    array(
        'title'       => '客服数字员工 - 产品介绍',
        'content'     => '<h2>客服数字员工 - 7x24小时智能客服</h2>
<p>客服数字员工是基于大模型的智能对话系统，能够<strong>理解用户意图、回答产品问题、引导用户转化</strong>，替代传统客服的大部分工作。</p>
<h3>核心功能</h3>
<ul>
    <li><strong>智能问答</strong>：基于企业知识库，准确回答用户关于产品功能、价格、使用方法等问题</li>
    <li><strong>意图识别</strong>：精准识别用户需求，自动推荐相关产品或解决方案</li>
    <li><strong>工单流转</strong>：复杂问题自动生成工单，流转至人工客服处理</li>
    <li><strong>对话分析</strong>：分析用户高频问题，帮助企业优化产品和服务</li>
    <li><strong>多入口接入</strong>：支持网站嵌入、微信公众号、企业微信、APP等多渠道</li>
</ul>
<h3>演示视频</h3>
<p><strong>即将上线</strong>：我们会录制客服数字员工的对话演示视频，展示如何智能回答用户问题。</p>
<p>视频将发布在：<a href="#" target="_blank">微信公众号</a> | <a href="#" target="_blank">抖音</a>（链接待更新）</p>
<h3>适用场景</h3>
<ul>
    <li>产品功能复杂，需要大量售前咨询的B2B企业</li>
    <li>客户问题重复度高，希望降低客服成本的团队</li>
    <li>需要提供7x24小时在线服务的企业</li>
</ul>
<h3>在线咨询</h3>
<p>如果您想了解客服数字员工是否适合您的企业，请：</p>
<ul>
    <li>添加微信咨询：[待更新微信号]</li>
    <li>在线留言：<a href="/index.php?s=guestbook">点击这里</a></li>
    <li>拨打咨询电话：<strong>186-0192-1816</strong></li>
</ul>',
        'description' => '客服数字员工产品介绍，7x24小时智能问答与用户引导',
        'typeid'      => 113,
    ),
    array(
        'title'       => '智能问答演示 - 客服数字员工如何回答用户问题',
        'content'     => '<h2>客服数字员工智能问答演示</h2>
<p>以下展示客服数字员工如何智能回答用户关于<strong>PLM系统</strong>的常见问题。</p>
<h3>示例对话一：产品功能咨询</h3>
<div style="background:#f0f8ff;padding:15px;border-radius:10px;margin:15px 0;">
    <p><strong>用户</strong>：你们PLM系统支持哪些CAD软件？</p>
    <p><strong>客服数字员工</strong>：您好！我们的PLM系统支持主流CAD软件，包括：</p>
    <ul>
        <li>SolidWorks</li>
        <li>CATIA</li>
        <li>AutoCAD</li>
        <li>Pro/E (Creo)</li>
        <li>UG NX</li>
    </ul>
    <p>同时支持超过200种文件格式的在线预览。您目前使用的是哪款CAD软件？我可以为您提供更详细的信息。</p>
</div>
<h3>示例对话二：价格咨询</h3>
<div style="background:#f0fff0;padding:15px;border-radius:10px;margin:15px 0;">
    <p><strong>用户</strong>：PLM系统怎么收费？</p>
    <p><strong>客服数字员工</strong>：我们的PLM系统提供灵活的付费方案：</p>
    <ul>
        <li><strong>企业版</strong>：按用户数授权，适合中大型企业</li>
        <li><strong>云订阅版</strong>：按年付费，无需自建服务器</li>
        <li><strong>教育版</strong>：针对高校和培训机构提供优惠</li>
    </ul>
    <p>为了方便您了解详情，我可以为您安排一次<strong>免费演示</strong>，我们的售前工程师会为您详细介绍并解答疑问。请问方便留个联系方式吗？</p>
</div>
<h3>完整演示视频</h3>
<p>我们正在录制完整的对话演示视频，将展示更多复杂场景的处理能力。</p>
<p>视频发布渠道：微信公众号 [待更新] | 抖音 [待更新]</p>
<h3>立即体验</h3>
<p>如果您想亲自体验客服数字员工，请：</p>
<ul>
    <li><a href="/index.php?s=guestbook">在线留言咨询</a></li>
    <li>添加微信：[待更新]</li>
</ul>',
        'description' => '客服数字员工智能问答演示，展示如何回答用户关于产品的常见问题',
        'typeid'      => 113,
    ),
    array(
        'title'       => '成功案例 - 企业如何使用客服数字员工提升服务质量',
        'content'     => '<h2>成功案例 - 客服数字员工助力企业服务升级</h2>
<h3>案例一：某工业软件公司</h3>
<p><strong>挑战</strong>：产品功能复杂，客户咨询量大且重复度高，原有3人客服团队应接不暇，客户等待时间长导致满意度下降。</p>
<p><strong>解决方案</strong>：部署客服数字员工，接入官网和微信公众号，处理80%的常见问题，复杂问题转人工。</p>
<p><strong>效果：</strong></p>
<ul>
    <li>客服响应速度提升 <strong>90%</strong>（从平均5分钟降至30秒内）</li>
    <li>客服团队工作量减少 <strong>60%</strong>，转为专注高价值客户</li>
    <li>客户满意度从 <strong>72% 提升至 91%</strong></li>
    <li>年均节省客服人力成本 <strong>约30万元</strong></li>
</ul>
<h3>案例二：某设备制造商</h3>
<p><strong>挑战</strong>：售后咨询电话量大，且多集中在产品使用方法咨询，占用技术人员大量时间。</p>
<p><strong>解决方案</strong>：使用客服数字员工提供7x24小时在线支持，并关联产品手册和视频教程。</p>
<p><strong>效果：</strong></p>
<ul>
    <li>售后咨询电话减少 <strong>50%</strong></li>
    <li>技术人员有更多时间专注研发</li>
    <li>客户问题解决速度提升 <strong>3倍</strong></li>
</ul>
<h3>获取详细案例报告</h3>
<p>如果您希望了解客服数字员工是否适合您的企业，请联系我们：</p>
<ul>
    <li>微信：[待更新]</li>
    <li>邮箱：[待更新]</li>
    <li>咨询热线：<strong>186-0192-1816</strong></li>
</ul>',
        'description' => '客服数字员工成功案例，展示企业如何使用AI提升客服质量和降低人力成本',
        'typeid'      => 113,
    ),
);

$success = 0;
$fail    = 0;

foreach ($articles as $a) {
    $title = $conn->real_escape_string($a['title']);
    $content = $conn->real_escape_string($a['content']);
    $description = $conn->real_escape_string($a['description']);
    $typeid = intval($a['typeid']);
    $now = time();

    // 去重
    $check = $conn->query("SELECT aid FROM lvbo_article WHERE title='" . $title . "'");
    if ($check && $check->num_rows > 0) {
        echo '<p>[OK] 已存在，跳过：' . htmlspecialchars($a['title']) . '</p>';
        continue;
    }

    $sql = "INSERT INTO lvbo_article
            (title, content, description, typeid, status, addtime, author, copyfrom, hits)
            VALUES ('" . $title . "','" . $content . "','" . $description . "'," . $typeid . ",1,'" . $now . "','SCSAI','SCSAI ContentOS'," . rand(10, 200) . ")";

    if ($conn->query($sql)) {
        echo '<p>[OK] 插入成功 (aid=' . $conn->insert_id . ')：' . htmlspecialchars($a['title']) . '</p>';
        $success++;
    } else {
        echo '<p>[FAIL] 插入失败：' . htmlspecialchars($a['title']) . ' - ' . $conn->error . '</p>';
        $fail++;
    }
}

$conn->close();
echo '<hr><h3>完成！成功=' . $success . '，失败=' . $fail . '</h3>';
echo '<p><a href="/">返回首页</a></p>';