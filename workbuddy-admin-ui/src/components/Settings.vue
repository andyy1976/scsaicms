<template>
  <div class="settings">
    <el-card>
      <template #header>
        <div class="card-header">
          <span>系统设置</span>
        </div>
      </template>

      <el-form :model="settings" label-width="150px" ref="formRef">
        <el-divider content-position="left">API 配置</el-divider>

        <el-form-item label="API 端点">
          <el-input v-model="settings.api_endpoint" placeholder="http://localhost:3456/api" />
          <div class="hint">WorkBuddy 后端 API 地址</div>
        </el-form-item>

        <el-form-item label="LLM 模型">
          <el-select v-model="settings.llm_model" placeholder="请选择模型">
            <el-option label="qclaw/pool-hy3-preview" value="qclaw/pool-hy3-preview" />
            <el-option label="DeepSeek-V2" value="deepseek-v2" />
            <el-option label="GLM-4" value="glm-4" />
            <el-option label="Qwen2.5" value="qwen2.5" />
          </el-select>
          <div class="hint">用于内容生成的 LLM 模型</div>
        </el-form-item>

        <el-divider content-position="left">内容生成</el-divider>

        <el-form-item label="反AI味">
          <el-switch v-model="settings.anti_ai_taste" />
          <span class="hint">启用后自动去除"首先/其次/总之"等模式化表达</span>
        </el-form-item>

        <el-form-item label="自动推送CMS">
          <el-switch v-model="settings.auto_push_cms" />
          <span class="hint">内容生成完成后自动推送到 CMS</span>
        </el-form-item>

        <el-form-item label="默认栏目">
          <el-select v-model="settings.default_category" placeholder="请选择默认栏目">
            <el-option
              v-for="category in categories"
              :key="category.id"
              :label="category.typename"
              :value="category.id"
            />
          </el-select>
          <div class="hint">内容推送的默认栏目</div>
        </el-form-item>

        <el-divider content-position="left">通知设置</el-divider>

        <el-form-item label="启用通知">
          <el-switch v-model="settings.notification_enabled" />
          <span class="hint">任务完成或失败时发送通知</span>
        </el-form-item>

        <el-form-item label="通知方式">
          <el-checkbox-group v-model="notificationMethods">
            <el-checkbox value="email">邮件</el-checkbox>
            <el-checkbox value="wechat">微信</el-checkbox>
            <el-checkbox value="webhook">Webhook</el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-divider content-position="left"> danger Zone</el-divider>

        <el-form-item>
          <el-button type="danger" @click="resetSettings">恢复默认设置</el-button>
          <el-button type="warning" @click="clearCache">清除缓存</el-button>
        </el-form-item>

        <el-form-item>
          <el-button type="primary" @click="saveSettings" :loading="saving">
            保存设置
          </el-button>
          <el-button @click="loadSettings">重置</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import type { AppSettings } from '../types'

const settings = ref<AppSettings>({
  api_endpoint: 'http://localhost:3456/api',
  llm_model: 'qclaw/pool-hy3-preview',
  anti_ai_taste: true,
  auto_push_cms: false,
  default_category: 0,
  notification_enabled: true
})

const categories = ref<any[]>([])
const notificationMethods = ref<string[]>(['wechat'])
const saving = ref(false)
const formRef = ref()

const loadSettings = async () => {
  try {
    const saved = localStorage.getItem('workbuddy_settings')
    if (saved) {
      settings.value = JSON.parse(saved)
    }

    // 加载CMS栏目
    const response = await fetch(`${settings.value.api_endpoint.replace(/\/api$/, '')}/api/cms/categories`)
    const result = await response.json()
    if (result.code === 0) {
      categories.value = result.data
    }
  } catch (error) {
    ElMessage.error('加载设置失败')
  }
}

const saveSettings = async () => {
  saving.value = true
  try {
    localStorage.setItem('workbuddy_settings', JSON.stringify(settings.value))
    ElMessage.success('设置已保存')
  } catch (error) {
    ElMessage.error('保存设置失败')
  } finally {
    saving.value = false
  }
}

const resetSettings = async () => {
  try {
    await ElMessageBox.confirm('确定要恢复默认设置吗？', '确认', {
      confirmButtonText: '确定',
      cancelButtonText: '取消',
      type: 'warning'
    })

    settings.value = {
      api_endpoint: 'http://localhost:3456/api',
      llm_model: 'qclaw/pool-hy3-preview',
      anti_ai_taste: true,
      auto_push_cms: false,
      default_category: 0,
      notification_enabled: true
    }
    ElMessage.success('已恢复默认设置')
  } catch (error) {
    // 用户取消
  }
}

const clearCache = async () => {
  try {
    localStorage.clear()
    sessionStorage.clear()
    ElMessage.success('缓存已清除')
  } catch (error) {
    ElMessage.error('清除缓存失败')
  }
}

onMounted(() => {
  loadSettings()
})
</script>

<style scoped>
.settings {
  padding: 20px;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.hint {
  margin-left: 10px;
  color: #999;
  font-size: 12px;
}

.el-divider {
  margin: 30px 0;
}
</style>
