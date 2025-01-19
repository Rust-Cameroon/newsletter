import { useEffect, useState } from "react";

const images = [
    "../src/assets/rust.png",
]
const Carousel = () => {
    const [currentSlide, setCurrentSlide] = useState(0);

    // Auto-slide every 3 seconds
    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentSlide((prev) => (prev + 1) % images.length);
        }, 5000);

        return () => clearInterval(interval);
    }, []);

    return (
        
        <div className=" w-2/3 mx-auto mt-10">
            {/* Carousel Wrapper */}
            <div className="relative h-96 md:h-[40rem] overflow-hidden rounded-lg">
                {images.map((image, index) => (
                    <img
                        key={index}
                        src={image}
                        className={`absolute block w-full h-full object-contain transition-opacity duration-700 ${
                            index === currentSlide ? "opacity-100" : "opacity-0"
                        }`}
                        alt={`Slide ${index + 1}`}
                    />
                ))}
            </div>
        </div>
    );
};

export default Carousel;