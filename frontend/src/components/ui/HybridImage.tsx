import React, { useState, useEffect } from 'react';

interface HybridImageProps {
  src: string;
  alt: string;
  className?: string;
  fallbackSrc?: string;
  isFirstFive?: boolean;
}

const HybridImage: React.FC<HybridImageProps> = ({ 
  src, 
  alt, 
  className = '', 
  fallbackSrc,
  isFirstFive = false 
}) => {
  const [imageSrc, setImageSrc] = useState<string>('');
  const [isLoading, setIsLoading] = useState(true);
  const [hasError, setHasError] = useState(false);

  useEffect(() => {
    const loadImage = async () => {
      setIsLoading(true);
      setHasError(false);

      // For first 5 posts, try local storage first
      if (isFirstFive && src) {
        // Extract post ID from MinIO URL or use a fallback
        const postId = extractPostIdFromUrl(src);
        if (postId) {
          const localUrl = `/static/images/${postId}.jpg`;
          
          // Try to load local image first
          try {
            const response = await fetch(localUrl, { method: 'HEAD' });
            if (response.ok) {
              setImageSrc(localUrl);
              setIsLoading(false);
              return;
            }
          } catch (error) {
            console.log('Local image not found, falling back to MinIO');
          }
        }
      }

      // Fallback to original MinIO URL
      setImageSrc(src);
      setIsLoading(false);
    };

    loadImage();
  }, [src, isFirstFive]);

  const extractPostIdFromUrl = (url: string): string | null => {
    // Extract post ID from MinIO URL
    // URL format: https://rustcameroon.com/minio/rust-cameroon-images/2025/01/27/filename.jpg
    const match = url.match(/\/([^\/]+)\.(jpg|jpeg|png|gif)$/i);
    return match ? match[1] : null;
  };

  const handleImageError = () => {
    if (!hasError && fallbackSrc) {
      setHasError(true);
      setImageSrc(fallbackSrc);
    }
  };

  if (isLoading) {
    return (
      <div className={`bg-gray-200 dark:bg-gray-700 animate-pulse ${className}`}>
        <div className="w-full h-full flex items-center justify-center">
          <svg className="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>
    );
  }

  return (
    <img
      src={imageSrc}
      alt={alt}
      className={className}
      onError={handleImageError}
      loading="lazy"
    />
  );
};

export default HybridImage;
