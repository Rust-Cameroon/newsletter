import { useState } from "react";

export default function Body() {
    const [Posts, setPost] = useState(
        [
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp0",
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp",
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"]);
    return (
        <>
            {Posts.forEach(post => {
                <div className="card bg-base-100 w-96 shadow-xl">
                    <figure>
                        <img
                            src={post}
                            alt="Shoes" />
                    </figure>
                    <div className="card-body">
                        <h2 className="card-title">Shoes!</h2>
                        <p>If a dog chews shoes whose shoes does he choose?</p>
                        <div className="card-actions justify-end">
                        </div>
                    </div>
                </div>
            })
            }

        </>
    )
}