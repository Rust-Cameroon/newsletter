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
  time: string;
  location: string;
  event_type: string;
  status: string; // "upcoming" or "past"
  registration_url?: string; // Optional registration link
  created_at: string;
}

export interface AdminUser {
  username: string;
  isAuthenticated: boolean;
}
