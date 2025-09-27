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

      // The backend already returns local URLs for first 5 posts
      // So we can directly use the src URL
      setImageSrc(src);
      setIsLoading(false);
    };

    loadImage();
  }, [src, isFirstFive]);


  const handleImageError = () => {
    if (!hasError) {
      setHasError(true);
      // If this is a local URL that failed, try the original MinIO URL
      if (imageSrc.includes('/static/images/') && src && !src.includes('/static/images/')) {
        console.log('Local image failed, falling back to MinIO URL:', src);
        setImageSrc(src);
      } else if (fallbackSrc) {
        setImageSrc(fallbackSrc);
      }
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
