import React from 'react';

const CampusTour: React.FC = () => {
  return (
    <iframe
      src="/ractconf/index.html"
      style={{ width: '100%', height: '100vh', border: 'none' }}
      title="Campus Tour"
    />
  );
};

export default CampusTour;