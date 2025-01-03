import { useEffect } from "react";

export function Alert({ message, onClose }: { message: string; onClose: () => void }) {
  useEffect(() => {
    const timer = setTimeout(() => {
      onClose(); // Automatically dismiss after 5 seconds
    }, 5000);
    return () => clearTimeout(timer);
  }, [onClose]);

  return (
    <div
      role="alert"
      className="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 z-50 
                 bg-accentcolor text-white px-4 py-3 rounded shadow-lg animate-slide-down"
    >
      <div className="flex justify-between items-center">
        <span className="ml-2">{message}</span>
      </div>
    </div>
  );
}
