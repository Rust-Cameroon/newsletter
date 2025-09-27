import axios from 'axios';
import { Post, Event } from '../types';

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
    console.log('Fetching post by slug from:', API_BASE_URL + `/posts/slug/${slug}`);
    const response = await api.get(`/posts/slug/${slug}`);
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

export const eventsApi = {
  getAll: async (): Promise<Event[]> => {
    console.log('Fetching all events from:', API_BASE_URL + '/events');
    const response = await api.get('/events');
    return response.data;
  },

  getUpcoming: async (): Promise<Event[]> => {
    console.log('Fetching upcoming events from:', API_BASE_URL + '/events/upcoming');
    const response = await api.get('/events/upcoming');
    return response.data;
  },

  getPast: async (): Promise<Event[]> => {
    console.log('Fetching past events from:', API_BASE_URL + '/events/past');
    const response = await api.get('/events/past');
    return response.data;
  },

  create: async (event: Omit<Event, 'id' | 'status' | 'created_at'>): Promise<Event> => {
    console.log('Creating event at:', API_BASE_URL + '/events');
    const response = await api.post('/events', event);
    return response.data;
  },

  update: async (id: string, event: Partial<Event>): Promise<Event> => {
    console.log('Updating event at:', API_BASE_URL + `/events/update/${id}`);
    const response = await api.put(`/events/update/${id}`, event);
    return response.data;
  },

  delete: async (id: string): Promise<void> => {
    console.log('Deleting event at:', API_BASE_URL + `/events/delete/${id}`);
    await api.delete(`/events/delete/${id}`);
  },
};
