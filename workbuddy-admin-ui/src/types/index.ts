// WorkBuddy v6.0 - TypeScript 类型定义

// API 响应类型
export interface ApiResponse<T = any> {
  code: number;
  message: string;
  data: T;
}

// 内容生成请求
export interface ContentGenerateRequest {
  product_data: ProductData;
  template_type: 'tech_blog' | 'case_study' | 'landing_page' | 'social_media';
  anti_ai_taste: boolean;
  tone: 'professional' | 'casual' | 'technical';
  length: 'short' | 'medium' | 'long';
}

// 产品数据（BOM/工艺/质量）
export interface ProductData {
  id: string;
  name: string;
  category: string;
  bom: BOMItem[];
  process: ProcessStep[];
  quality: QualityMetric[];
  metadata: Record<string, any>;
}

export interface BOMItem {
  part_number: string;
  name: string;
  quantity: number;
  material: string;
  specifications: string;
}

export interface ProcessStep {
  step: number;
  name: string;
  description: string;
  duration: number;
  equipment: string;
}

export interface QualityMetric {
  parameter: string;
  standard: string;
  actual: string;
  status: 'pass' | 'fail' | 'warning';
}

// CMS推送请求
export interface CMSPushRequest {
  title: string;
  content: string;
  typeid: number;
  writer: string;
  source: string;
  keywords: string;
  description: string;
  thumbnail?: string;
}

// CMS栏目
export interface CMSCategory {
  id: number;
  typename: string;
  fid: number;
  path: string;
  ismenu: number;
}

// 对话消息
export interface ChatMessage {
  id: string;
  role: 'user' | 'assistant' | 'system';
  content: string;
  timestamp: number;
  metadata?: Record<string, any>;
}

// 任务状态
export interface TaskStatus {
  task_id: string;
  status: 'pending' | 'running' | 'completed' | 'failed';
  progress: number;
  result?: any;
  error?: string;
}

// 文章润色请求
export interface ArticlePolishRequest {
  content: string;
  polish_level: 'light' | 'medium' | 'heavy';
  target_audience: string;
  preserve_technical_terms: boolean;
}

// 设置配置
export interface AppSettings {
  api_endpoint: string;
  llm_model: string;
  anti_ai_taste: boolean;
  auto_push_cms: boolean;
  default_category: number;
  notification_enabled: boolean;
}
