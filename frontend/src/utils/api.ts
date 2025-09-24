import axios from 'axios';
import { Post } from '../types';

const API_BASE_URL = "https://rustcameroon.com/api";

const api = axios.create({
  baseURL: "https://rustcameroon.com/api",
  headers: {
    'Content-Type': 'application/json',
  },
});

export const postsApi = {
  getAll: async (): Promise<Post[]> => {
    console.log('Fetching all posts from:', API_BASE_URL + '/posts');
    const response = await api.get('/posts');
    return response.data;
  },

  getBySlug: async (slug: string): Promise<Post> => {
    console.log('Fetching post by slug from:', API_BASE_URL + `/posts/${slug}`);
    const response = await api.get(`/posts/${slug}`);
    return response.data;
  },

  create: async (formData: FormData): Promise<Post> => {
    console.log('Creating post at:', API_BASE_URL + '/posts');
    const response = await fetch(API_BASE_URL + '/posts', {
      method: 'POST',
      body: formData,
    });
    
    if (!response.ok) {
      throw new Error(`Failed to create post: ${response.statusText}`);
    }
    
    return response.json();
  },

  update: async (id: string, post: Partial<Post>): Promise<Post> => {
    console.log('Updating post at:', API_BASE_URL + `/posts/${id}`);
    const response = await api.put(`/posts/${id}`, post);
    return response.data;
  },

  delete: async (id: string): Promise<void> => {
    console.log('Deleting post at:', API_BASE_URL + `/posts/delete/${id}`);
    await api.delete(`/posts/delete/${id}`);
  },

};
