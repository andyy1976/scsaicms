<template>
  <div class="chat-interface">
    <el-card class="chat-card">
      <template #header>
        <div class="card-header">
          <span>💬 WorkBuddy 对话界面</span>
          <el-button type="primary" size="small" @click="clearChat" v-if="chatHistory.length > 0">清空对话</el-button>
        </div>
      </template>
      
      <!-- 聊天消息区域 -->
      <div class="chat-messages" ref="messageContainer">
        <div v-if="chatHistory.length === 0" class="welcome-area">
          <el-empty description=""></el-empty>
          <div class="welcome-text">
            <h3>👋 欢迎使用 WorkBuddy！</h3>
            <p>我是您的 AI 内容助手，可以帮您：</p>
            <ul>
              <li>📝 <strong>生成内容</strong> - 输入主题，我会为您生成高质量文章</li>
              <li>🔄 <strong>反 AI 味处理</strong> - 让 AI 生成的内容更自然、更有人情味</li>
              <li>📤 <strong>推送到 CMS</strong> - 将生成的内容直接发布到网站</li>
              <li>📋 <strong>管理任务</strong> - 查看和控制内容生成任务</li>
            </ul>
            <p class="example-title">💡 您可以这样问我：</p>
            <div class="example-questions">
              <el-button size="small" @click="message='帮我写一篇关于工业互联网的文章'">帮我写一篇关于工业互联网的文章</el-button>
              <el-button size="small" @click="message='如何让 AI 生成的内容更自然？'">如何让 AI 生成的内容更自然？</el-button>
              <el-button size="small" @click="message='把这篇文章推送到 CMS 的首页栏目'">把这篇文章推送到 CMS 的首页栏目</el-button>
            </div>
          </div>
        </div>
        <div v-for="(msg, index) in chatHistory" :key="index" class="message-item" :class="msg.role">
          <div class="message-content">
            <div class="message-role">{{ msg.role === 'user' ? '您' : 'WorkBuddy' }}</div>
            <div class="message-text">{{ msg.content }}</div>
          </div>
        </div>
      </div>
      
      <!-- 输入区域 -->
      <div class="chat-input-area">
        <el-input
          v-model="message"
          type="textarea"
          :rows="3"
          placeholder="输入您的问题..."
          @keyup.ctrl.enter="sendMessage"
        />
        <div class="input-actions">
          <span class="input-tip">Ctrl + Enter 发送</span>
          <el-button type="primary" @click="sendMessage" :loading="sending">发送</el-button>
        </div>
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { ElMessage } from 'element-plus'
import api from '@/api/workbuddy'

const message = ref('')
const chatHistory = ref<Array<{role: string, content: string}>>([])
const sending = ref(false)

console.log('ChatInterface loaded')

const sendMessage = async () => {
  if (!message.value.trim()) {
    ElMessage.warning('请输入消息')
    return
  }
  
  // 添加用户消息到历史
  chatHistory.value.push({
    role: 'user',
    content: message.value
  })
  
  const userMessage = message.value
  message.value = ''
  sending.value = true
  
  try {
    // 调用 API
    const response = await api.sendMessage({
      message: userMessage,
      history: chatHistory.value.slice(0, -1) // 不包含当前消息
    })
    
    if (response && response.reply) {
      chatHistory.value.push({
        role: 'assistant',
        content: response.reply
      })
    } else {
      chatHistory.value.push({
        role: 'assistant',
        content: '抱歉，暂时无法回复。'
      })
    }
  } catch (error) {
    console.error('发送消息失败:', error)
    ElMessage.error('发送失败，请稍后重试')
    chatHistory.value.push({
      role: 'assistant',
      content: '⚠️ 网络错误，请检查后端服务是否启动（端口 3456）'
    })
  } finally {
      sending.value = false
  }
}

const clearChat = () => {
  chatHistory.value = []
  ElMessage.success('对话已清空')
}
</script>

<style scoped>
.chat-interface {
  max-width: 1200px;
  margin: 0 auto;
  height: calc(100vh - 100px);
  display: flex;
  flex-direction: column;
}

.chat-card {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 18px;
  font-weight: bold;
}

.chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
  background: #f5f7fa;
  border-radius: 4px;
  margin-bottom: 20px;
  min-height: 400px;
  max-height: 600px;
}

.welcome-message {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}

.message-item {
  margin-bottom: 16px;
  padding: 12px;
  border-radius: 8px;
  max-width: 80%;
}

.message-item.user {
  margin-left: auto;
  background: #409eff;
  color: white;
}

.message-item.assistant {
  margin-right: auto;
  background: white;
  color: #333;
  border: 1px solid #e4e7ed;
}

.message-role {
  font-size: 12px;
  font-weight: bold;
  margin-bottom: 6px;
  color: #909399;
}

.message-item.user .message-role {
  color: rgba(255, 255, 255, 0.8);
}

.message-text {
  font-size: 14px;
  line-height: 1.6;
  white-space: pre-wrap;
  word-break: break-word;
}

.chat-input-area {
  margin-top: 20px;
}

.input-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 12px;
}

.input-tip {
  font-size: 12px;
  color: #909399;
}

.welcome-text {
  text-align: center;
  padding: 40px 20px;
}

.welcome-text h3 {
  font-size: 24px;
  color: #303133;
  margin-bottom: 16px;
}

.welcome-text p {
  font-size: 14px;
  color: #606266;
  line-height: 1.8;
  margin-bottom: 12px;
}

.welcome-text ul {
  text-align: left;
  display: inline-block;
  margin: 12px 0;
}

.welcome-text li {
  font-size: 14px;
  color: #606266;
  line-height: 2;
}

.example-title {
  font-size: 14px;
  color: #909399;
  margin-top: 24px;
  margin-bottom: 12px;
}

.example-questions {
  display: flex;
  gap: 12px;
  justify-content: center;
  flex-wrap: wrap;
}
</style>
