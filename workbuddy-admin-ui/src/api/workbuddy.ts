import axios, { type AxiosInstance } from 'axios'
import type {
  ApiResponse,
  ContentGenerateRequest,
  CMSPushRequest,
  ArticlePolishRequest,
  TaskStatus,
  ProductData,
  CMSCategory
} from '../types'

class WorkBuddyAPI {
  private client: AxiosInstance

  constructor() {
    this.client = axios.create({
      baseURL: '/api',
      timeout: 30000,
      headers: {
        'Content-Type': 'application/json'
      }
    })
  }

  // 健康检查
  async healthCheck(): Promise<ApiResponse> {
    const response = await this.client.get<ApiResponse>('/health')
    return response.data
  }

  // 内容生成
  async generateContent(data: ContentGenerateRequest): Promise<ApiResponse<{ content: string; task_id: string }>> {
    const response = await this.client.post<ApiResponse>('/content/generate', data)
    return response.data
  }

  // 反AI味处理
  async deaiify(data: { content: string }): Promise<ApiResponse<{ content: string }>> {
    const response = await this.client.post<ApiResponse>('/content/deaiify', data)
    return response.data
  }

  // CMS推送
  async pushToCms(data: CMSPushRequest): Promise<ApiResponse<{ aid: number; url: string }>> {
    const response = await this.client.post<ApiResponse>('/cms/push', data)
    return response.data
  }

  // 获取产品列表
  async getProductList(): Promise<ApiResponse<ProductData[]>> {
    const response = await this.client.get<ApiResponse>('/products')
    return response.data
  }

  // 获取CMS栏目
  async getCMSCategories(): Promise<ApiResponse<CMSCategory[]>> {
    const response = await this.client.get<ApiResponse>('/cms/categories')
    return response.data
  }

  // 任务管理
  async getTasks(): Promise<ApiResponse<TaskStatus[]>> {
    const response = await this.client.get<ApiResponse>('/tasks')
    return response.data
  }

  async createTask(data: { type: string; product_id: string; template_type: string }): Promise<ApiResponse<TaskStatus>> {
    const response = await this.client.post<ApiResponse>('/tasks/create', data)
    return response.data
  }

  async cancelTask(taskId: string): Promise<ApiResponse> {
    const response = await this.client.post<ApiResponse>(`/tasks/${taskId}/cancel`)
    return response.data
  }

  // 文章润色
  async polishArticle(data: ArticlePolishRequest): Promise<ApiResponse<{ polished_content: string }>> {
    const response = await this.client.post<ApiResponse>('/article/polish', data)
    return response.data
  }

  // 对话接口
  async sendMessage(data: { message: string; history?: any[] }): Promise<ApiResponse<{ reply: string }>> {
    const response = await this.client.post<ApiResponse>('/chat', data)
    return response.data
  }
}

const api = new WorkBuddyAPI()

export default api
export { api }
