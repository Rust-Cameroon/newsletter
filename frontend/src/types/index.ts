export interface Post {
  id: string;
  title: string;
  content: string;
  excerpt: string;
  author: string;
  date: string;
  tags: string[];
  image_url?: string;
  slug: string;
}

export interface Event {
  id: string;
  title: string;
  description: string;
  date: string;
  location: string;
  image_url?: string;
  registration_url?: string;
}

export interface AdminUser {
  username: string;
  isAuthenticated: boolean;
}
