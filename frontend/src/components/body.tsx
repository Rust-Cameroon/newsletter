import { useState } from "react";

export default function Body() {
    const [Posts, setPost] = useState(
        [
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp0",
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp",
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"]);
    return (
        <>
         
                <div className="card bg-neutral-700 dark:bg-black-700">
                    <figure>
                        <img
                            src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp0"
                            alt="Shoes"/>
                    </figure>
                    <div className="card-body">
                        <h2 className="card-title">Shoes!</h2>
                        <p>If a dog chews shoes whose shoes does he choose?</p>
                        <div className="card-actions justify-end">
                        </div>
                    </div>
                </div>
            

        </>
    )
}