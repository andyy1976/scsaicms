import { createRouter, createWebHistory } from 'vue-router'
import ChatInterface from '@/components/ChatInterface.vue'
import TaskManager from '@/components/TaskManager.vue'
import ArticlePolish from '@/components/ArticlePolish.vue'
import Settings from '@/components/Settings.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: ChatInterface },
    { path: '/tasks', component: TaskManager },
    { path: '/polish', component: ArticlePolish },
    { path: '/settings', component: Settings }
  ]
})

export default router
