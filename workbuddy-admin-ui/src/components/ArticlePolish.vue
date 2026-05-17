<template>
  <div class="article-polish">
    <el-card>
      <template #header>
        <div class="card-header">
          <span>文章润色</span>
        </div>
      </template>

      <el-row :gutter="20">
        <el-col :span="12">
          <el-form label-width="120px">
            <el-form-item label="润色级别">
              <el-radio-group v-model="polishConfig.polish_level">
                <el-radio value="light">轻度</el-radio>
                <el-radio value="medium">中度</el-radio>
                <el-radio value="heavy">重度</el-radio>
              </el-radio-group>
            </el-form-item>

            <el-form-item label="目标受众">
              <el-select v-model="polishConfig.target_audience" placeholder="请选择目标受众">
                <el-option label="技术人员" value="technical" />
                <el-option label="管理人员" value="manager" />
                <el-option label="普通用户" value="general" />
                <el-option label="客户" value="client" />
              </el-select>
            </el-form-item>

            <el-form-item label="保留术语">
              <el-switch v-model="polishConfig.preserve_technical_terms" />
              <span class="hint">保留专业术语和技术名词</span>
            </el-form-item>
          </el-form>

          <el-divider />

          <el-form-item label="原始内容">
            <el-input
              v-model="originalContent"
              type="textarea"
              :rows="12"
              placeholder="请输入需要润色的文章内容..."
            />
          </el-form-item>

          <el-form-item>
            <el-button type="primary" @click="polishArticle" :loading="polishing">
              开始润色
            </el-button>
            <el-button @click="clearContent">清空</el-button>
          </el-form-item>
        </el-col>

        <el-col :span="12">
          <div class="result-section">
            <div class="result-header">
              <span>润色结果</span>
              <el-button
                v-if="polishedContent"
                size="small"
                type="success"
                @click="copyToClipboard"
              >
                复制
              </el-button>
            </div>

            <div v-if="polishing" class="loading-container">
              <el-icon class="is-loading" :size="30"><Loading /></el-icon>
              <p>正在润色文章，请稍候...</p>
            </div>

            <div v-else-if="polishedContent" class="polished-content">
              <el-input
                v-model="polishedContent"
                type="textarea"
                :rows="18"
                readonly
              />
            </div>

            <div v-else class="empty-result">
              <el-empty description="润色结果将在此显示" />
            </div>
          </div>
        </el-col>
      </el-row>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Loading } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'
import type { ArticlePolishRequest } from '../types'

const originalContent = ref('')
const polishedContent = ref('')
const polishing = ref(false)

const polishConfig = ref<ArticlePolishRequest>({
  content: '',
  polish_level: 'medium',
  target_audience: 'technical',
  preserve_technical_terms: true
})

const polishArticle = async () => {
  if (!originalContent.value.trim()) {
    ElMessage.warning('请输入需要润色的文章内容')
    return
  }

  polishing.value = true
  polishConfig.value.content = originalContent.value

  try {
    const response = await fetch('http://localhost:3456/api/article/polish', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(polishConfig.value)
    })

    const result = await response.json()
    if (result.code === 0) {
      polishedContent.value = result.data.polished_content
      ElMessage.success('文章润色完成')
    } else {
      ElMessage.error(result.message || '润色失败')
    }
  } catch (error) {
    ElMessage.error('调用润色API失败')
  } finally {
    polishing.value = false
  }
}

const clearContent = () => {
  originalContent.value = ''
  polishedContent.value = ''
}

const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(polishedContent.value)
    ElMessage.success('已复制到剪贴板')
  } catch (error) {
    ElMessage.error('复制失败')
  }
}
</script>

<style scoped>
.article-polish {
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

.result-section {
  height: 100%;
}

.result-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  font-weight: bold;
}

.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 400px;
  color: #999;
}

.polished-content {
  height: 100%;
}

.empty-result {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 400px;
}
</style>
