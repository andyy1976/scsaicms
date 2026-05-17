<template>
  <div class="task-manager">
    <el-card>
      <template #header>
        <div class="card-header">
          <span>任务管理</span>
          <el-button type="primary" @click="showCreateDialog = true">
            <el-icon><Plus /></el-icon>
            新建任务
          </el-button>
        </div>
      </template>

      <el-table :data="tasks" style="width: 100%">
        <el-table-column prop="task_id" label="任务ID" width="180" />
        <el-table-column prop="status" label="状态" width="120">
          <template #default="scope">
            <el-tag :type="getStatusType(scope.row.status)">
              {{ scope.row.status }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="progress" label="进度" width="150">
          <template #default="scope">
            <el-progress :percentage="scope.row.progress" />
          </template>
        </el-table-column>
        <el-table-column prop="created_at" label="创建时间" width="180" />
        <el-table-column label="操作" width="200">
          <template #default="scope">
            <el-button size="small" @click="viewTask(scope.row)">查看</el-button>
            <el-button
              size="small"
              type="danger"
              @click="cancelTask(scope.row)"
              :disabled="scope.row.status === 'completed' || scope.row.status === 'failed'"
            >
              取消
            </el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-card>

    <!-- 创建任务对话框 -->
    <el-dialog v-model="showCreateDialog" title="新建任务" width="500px">
      <el-form :model="newTask" label-width="100px">
        <el-form-item label="任务类型">
          <el-select v-model="newTask.type" placeholder="请选择任务类型">
            <el-option label="内容生成" value="content_generate" />
            <el-option label="CMS推送" value="cms_push" />
            <el-option label="文章润色" value="article_polish" />
          </el-select>
        </el-form-item>
        <el-form-item label="产品数据">
          <el-select v-model="newTask.product_id" placeholder="请选择产品">
            <el-option
              v-for="product in products"
              :key="product.id"
              :label="product.name"
              :value="product.id"
            />
          </el-select>
        </el-form-item>
        <el-form-item label="模板类型">
          <el-select v-model="newTask.template_type" placeholder="请选择模板">
            <el-option label="技术博客" value="tech_blog" />
            <el-option label="案例研究" value="case_study" />
            <el-option label="落地页" value="landing_page" />
            <el-option label="社交媒体" value="social_media" />
          </el-select>
        </el-form-item>
      </el-form>
      <template #footer>
        <el-button @click="showCreateDialog = false">取消</el-button>
        <el-button type="primary" @click="createTask">创建</el-button>
      </template>
    </el-dialog>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { Plus } from '@element-plus/icons-vue'
import { ElMessage } from 'element-plus'
import type { TaskStatus } from '../types'

const tasks = ref<TaskStatus[]>([])
const products = ref<any[]>([])
const showCreateDialog = ref(false)
const newTask = ref({
  type: '',
  product_id: '',
  template_type: ''
})

const getStatusType = (status: string) => {
  const map: Record<string, string> = {
    pending: 'info',
    running: 'warning',
    completed: 'success',
    failed: 'danger'
  }
  return map[status] || 'info'
}

const loadTasks = async () => {
  try {
    const response = await fetch('http://localhost:3456/api/tasks')
    const result = await response.json()
    if (result.code === 0) {
      tasks.value = result.data
    }
  } catch (error) {
    ElMessage.error('加载任务列表失败')
  }
}

const loadProducts = async () => {
  try {
    const response = await fetch('http://localhost:3456/api/products')
    const result = await response.json()
    if (result.code === 0) {
      products.value = result.data
    }
  } catch (error) {
    ElMessage.error('加载产品列表失败')
  }
}

const createTask = async () => {
  try {
    const response = await fetch('http://localhost:3456/api/tasks/create', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(newTask.value)
    })
    const result = await response.json()
    if (result.code === 0) {
      ElMessage.success('任务创建成功')
      showCreateDialog.value = false
      loadTasks()
    }
  } catch (error) {
    ElMessage.error('任务创建失败')
  }
}

const viewTask = (task: TaskStatus) => {
  ElMessage.info(`查看任务: ${task.task_id}`)
}

const cancelTask = async (task: TaskStatus) => {
  try {
    const response = await fetch(`http://localhost:3456/api/tasks/${task.task_id}/cancel`, {
      method: 'POST'
    })
    const result = await response.json()
    if (result.code === 0) {
      ElMessage.success('任务已取消')
      loadTasks()
    }
  } catch (error) {
    ElMessage.error('取消任务失败')
  }
}

onMounted(() => {
  loadTasks()
  loadProducts()
})
</script>

<style scoped>
.task-manager {
  padding: 20px;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
