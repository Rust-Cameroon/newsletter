import React from 'react';
import { Helmet } from 'react-helmet-async';
import { useTranslation } from 'react-i18next';
import { usePosts } from '../hooks/usePosts';
import PostCard from '../components/ui/PostCard';
import LoadingSpinner from '../components/ui/LoadingSpinner';

const Blog: React.FC = () => {
  const { t } = useTranslation();
  const { posts, loading, error } = usePosts();

  return (
    <>
      <Helmet>
        <title>Blog - Rust Cameroon | Articles, Tutorials & Community Insights</title>
        <meta 
          name="description" 
          content="Read the latest articles, tutorials, and insights from the Rust Cameroon community. Learn Rust programming, best practices, and stay updated with community news." 
        />
        <meta name="keywords" content="rust blog, rust tutorials, rust articles, programming tutorials, rust community, software development, rust programming language, cameroon tech blog" />
        <link rel="canonical" href="https://rustcameroon.com/blog" />
        
        {/* Open Graph */}
        <meta property="og:title" content="Blog - Rust Cameroon | Articles, Tutorials & Community Insights" />
        <meta property="og:description" content="Read the latest articles, tutorials, and insights from the Rust Cameroon community." />
        <meta property="og:url" content="https://rustcameroon.com/blog" />
        <meta property="og:type" content="blog" />
        
        {/* Twitter */}
        <meta name="twitter:title" content="Blog - Rust Cameroon | Articles, Tutorials & Community Insights" />
        <meta name="twitter:description" content="Read the latest articles, tutorials, and insights from the Rust Cameroon community." />
        
        {/* Structured Data */}
        <script type="application/ld+json">
        {JSON.stringify({
          "@context": "https://schema.org",
          "@type": "Blog",
          "name": "Rust Cameroon Blog",
          "description": "Read the latest articles, tutorials, and insights from the Rust Cameroon community.",
          "url": "https://rustcameroon.com/blog",
          "publisher": {
            "@type": "Organization",
            "name": "Rust Cameroon",
            "logo": "https://rustcameroon.com/assets/rustcm.svg"
          },
          "inLanguage": "en",
          "about": {
            "@type": "Thing",
            "name": "Rust Programming Language"
          }
        })}
        </script>
      </Helmet>

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center mb-12">
          <h1 className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
            {t('blog.title')}
          </h1>
          <p className="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            {t('blog.subtitle')}
          </p>
        </div>

        {loading ? (
          <LoadingSpinner size="lg" text={t('blog.loadingPosts')} />
        ) : error ? (
          <div className="text-center py-12">
            <div className="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 max-w-md mx-auto">
              <svg className="w-12 h-12 text-red-600 dark:text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <h3 className="text-lg font-medium text-red-800 dark:text-red-200 mb-2">
                {t('blog.errorLoadingPosts')}
              </h3>
              <p className="text-red-600 dark:text-red-400">
                {error}
              </p>
            </div>
          </div>
        ) : posts.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {posts.map((post) => (
              <PostCard key={post.id} post={post} />
            ))}
          </div>
          ) : (
            <div className="text-center py-12">
              <svg className="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-2">
                {t('blog.noPostsYet')}
              </h3>
              <p className="text-gray-600 dark:text-gray-400">
                {t('blog.noPostsYetDescription')}
              </p>
            </div>
          )}

        {/* Categories/Tags Section */}
        {posts.length > 0 && (
          <section className="mt-16">
            <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-8">
              {t('blog.popularTags')}
            </h2>
            <div className="flex flex-wrap gap-3">
              {Array.from(new Set(posts.flatMap(post => post.tags)))
                .slice(0, 10)
                .map((tag) => (
                  <span
                    key={tag}
                    className="px-4 py-2 bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-full text-sm font-medium hover:bg-orange-200 dark:hover:bg-orange-900/30 transition-colors cursor-pointer"
                  >
                    {tag}
                  </span>
                ))}
            </div>
          </section>
        )}
      </div>
    </>
  );
};

export default Blog;
