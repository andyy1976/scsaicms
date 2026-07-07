#!/usr/bin/env node
/**
 * 公开体验引擎 v1.0
 * 3个公开Skill，无需注册/Token即可调用。
 */
'use strict';
const P = require('path');
const F = require('fs');
function loadProv() {
    const p = P.join(__dirname,'..','config','ai-providers.json');
    if (F.existsSync(p)) { try { const c=JSON.parse(F.readFileSync(p,'utf8')); return c.providers?.filter(x=>x.enabled!==false)||[]; }catch(e){} }
    return [{name:'deepseek',baseUrl:process.env.AI_BASE_URL||'https://api.deepseek.com',apiKey:process.env.AI_API_KEY||'',models:[process.env.AI_MODEL||'deepseek-v4-flash']}];
}
function getProv() { return loadProv().sort((a,b)=>(a.priority||99)-(b.priority||99))[0]; }
async function callAI(msg,op) {
    op=op||{}; const prov=getProv(); const m=op.model||prov.models[0]||'deepseek-v4-flash';
    const https=require('https'); const body=JSON.stringify({model:m,messages:msg,temperature:op.temperature||0.7,max_tokens:op.maxTokens||2000});
    return new Promise((res,rej)=>{
        const u=new URL(prov.baseUrl||'https://api.deepseek.com/v1/chat/completions');
        const r=https.request({hostname:u.hostname,port:u.port||443,path:u.pathname||'/v1/chat/completions',method:'POST',headers:{'Content-Type':'application/json','Authorization':'Bearer '+prov.apiKey,'Content-Length':Buffer.byteLength(body)},timeout:60000},(resp)=>{let d='';resp.on('data',c=>d+=c);resp.on('end',()=>{try{res(JSON.parse(d).choices[0].message.content||d);}catch(e){rej(new Error('AI解析失败'))}})});
        r.on('error',rej); r.on('timeout',()=>{r.destroy();rej(new Error('超时'))}); r.write(body); r.end();
    });
}

async function bomCmp(inp) {
    const d=inp.bomData||inp.text||'';
    const p='你是一个BOM结构分析专家。请分析以下BOM数据，找出可能的结构问题。\n\nBOM数据：\n'+d.substring(0,3000)+'\n\n请按JSON返回：{"issues":[{"type":"结构缺失|层级异常|数量错误|重复物料|编码不规范","severity":"high|medium|low","detail":"问题描述"}],"stats":{"totalItems":0,"issueCount":0,"healthScore":0},"summary":"总体评价","highlight":"最需要关注的发现"}\n返回纯JSON。';
    try { const r=JSON.parse((await callAI([{role:'system',content:'你是BOM分析专家，输出严格JSON。'},{role:'user',content:p}],{temperature:0.3})).replace(/```json\n?/g,'').replace(/```\n?/g,'').trim());
    return {success:true,skillId:'bom_compare',skillName:'BOM结构比对',inputType:d.length>200?'upload':'sample',inputSummary:d.substring(0,100),result:r,shareData:{title:'BOM结构健康检查报告',highlight:r.highlight||r.summary,stats:{score:r.stats?.healthScore||0,issues:r.stats?.issueCount||0,items:r.stats?.totalItems||0}}};}
    catch(e){return{success:false,error:e.message};}
}

async function procOpt(inp) {
    const d=inp.text||inp.processDesc||'';
    const p='你是一个工艺优化专家。请分析以下工艺参数或工艺描述，给出优化建议。\n\n工艺数据：\n'+d.substring(0,3000)+'\n\n请按JSON返回：{"currentState":"当前状态","optimizations":[{"parameter":"参数名","currentValue":"当前值","suggestedValue":"建议值","expectedImprovement":"预期提升","confidence":"high|medium|low","reason":"优化理由"}],"stats":{"totalOptimizations":0,"estimatedEfficiencyGain":"效率提升","estimatedCostReduction":"成本降低"},"summary":"一句话总结","highlight":"最大优化机会"}\n返回纯JSON。';
    try { const r=JSON.parse((await callAI([{role:'system',content:'你是工艺优化专家，输出严格JSON。'},{role:'user',content:p}],{temperature:0.3})).replace(/```json\n?/g,'').replace(/```\n?/g,'').trim());
    return {success:true,skillId:'process_optimize',skillName:'工艺参数优化',inputType:d.length>100?'custom':'sample',inputSummary:d.substring(0,100),result:r,shareData:{title:'工艺优化建议报告',highlight:r.highlight||r.summary,stats:{optimizations:r.stats?.totalOptimizations||0,efficiency:r.stats?.estimatedEfficiencyGain||'N/A',costReduction:r.stats?.estimatedCostReduction||'N/A'}}};}
    catch(e){return{success:false,error:e.message};}
}

async function cntGen(inp) {
    const t=inp.text||inp.topic||'';
    const p='你是一个制造业内容创作专家。请根据话题生成一篇微信公众号技术文章。\n\n话题：'+t.substring(0,500)+'\n\n要求：卡兹克风格，800-1200字，有吸引力的开头→2-3论点→案例/数据→总结\n\n请按JSON返回：{"title":"标题","content":"全文markdown","summary":"一句话摘要","keywords":["kw1","kw2"],"suggestedCoverDesc":"封面图描述","stats":{"wordCount":0}}\n返回纯JSON。';
    try { const r=JSON.parse((await callAI([{role:'system',content:'你是制造业内容创作专家，输出严格JSON。'},{role:'user',content:p}],{temperature:0.8,maxTokens:3000})).replace(/```json\n?/g,'').replace(/```\n?/g,'').trim());
    return {success:true,skillId:'content_generate',skillName:'智能内容生成',inputType:'topic',inputSummary:t,result:r,shareData:{title:r.title||'内容生成结果',highlight:r.summary||'一篇由AI辅助生成的技术文章',stats:{words:r.stats?.wordCount||r.content?.length||0,keywords:r.keywords?.length||0}}};}
    catch(e){return{success:false,error:e.message};}
}

const SKILLS={bom_compare:{name:'BOM结构比对',handler:bomCmp,description:'上传或输入BOM数据，3秒发现结构问题'},process_optimize:{name:'工艺参数优化',handler:procOpt,description:'输入工艺参数，获得AI优化建议'},content_generate:{name:'智能内容生成',handler:cntGen,description:'输入话题，20秒生成一篇技术文章'}};

async function runSkill(id,inp){const s=SKILLS[id];if(!s)return{success:false,error:'未知Skill: '+id};return await s.handler(inp);}
function getSkillList(){return Object.entries(SKILLS).map(([id,s])=>({id,name:s.name,description:s.description}));}

module.exports={runSkill,getSkillList,SKILLS,bomCmp,procOpt,cntGen};
