import { useEffect } from 'react';
import { useApp } from '../context/AppContext';
import { postsApi } from '../utils/api';

export const usePosts = () => {
  const { state, dispatch } = useApp();

  useEffect(() => {
    const fetchPosts = async () => {
      if (state.posts.length > 0) return; // Don't fetch if already loaded
      
      try {
        dispatch({ type: 'SET_LOADING', payload: true });
        const posts = await postsApi.getAll();
        dispatch({ type: 'SET_POSTS', payload: posts });
      } catch (error) {
        dispatch({ type: 'SET_ERROR', payload: 'Failed to fetch posts' });
      } finally {
        dispatch({ type: 'SET_LOADING', payload: false });
      }
    };

    fetchPosts();
  }, [dispatch, state.posts.length]);

  const refreshPosts = async () => {
    try {
      dispatch({ type: 'SET_LOADING', payload: true });
      const posts = await postsApi.getAll();
      dispatch({ type: 'SET_POSTS', payload: posts });
    } catch (error) {
      dispatch({ type: 'SET_ERROR', payload: 'Failed to refresh posts' });
    } finally {
      dispatch({ type: 'SET_LOADING', payload: false });
    }
  };

  return {
    posts: state.posts,
    loading: state.loading,
    error: state.error,
    refreshPosts
  };
};
