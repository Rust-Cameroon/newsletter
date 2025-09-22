import axios from 'axios';
import { Post } from '../types';

// const API_BASE_URL = "https://rustcameroon.com/api";

const api = axios.create({
  baseURL: "https://rustcameroon.com/api",
  headers: {
    'Content-Type': 'application/json',
  },
});

export const postsApi = {
  getAll: async (): Promise<Post[]> => {
    const response = await api.get('/posts');
    return response.data;
  },

  getBySlug: async (slug: string): Promise<Post> => {
    const response = await api.get(`/posts/${slug}`);
    return response.data;
  },

  create: async (post: Omit<Post, 'id' | 'slug' | 'date'>): Promise<Post> => {
    const response = await api.post('/posts', post);
    return response.data;
  },

  update: async (id: string, post: Partial<Post>): Promise<Post> => {
    const response = await api.put(`/posts/${id}`, post);
    return response.data;
  },

  delete: async (id: string): Promise<void> => {
    await api.delete(`/posts/delete/${id}`);
  },
};
