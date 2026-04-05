export interface NewsArticle {
  id: number
  slug: string
  title: string
  tag: string
  excerpt: string
  body: string
  image_url: string | null
  published: boolean
  published_at: string | null
  created_at: string
  updated_at: string
}

export interface NewsResponse {
  data: NewsArticle[]
  meta?: { current_page: number; last_page: number; total: number }
}
