import { useState } from "react";

export default function Body() {
    const [Posts, setPost] = useState(
        [
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp0",
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp",
            "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"]);
    return (
        <>

            <body className="grid bg-gray-700 grid-cols-4 gap-4">
                <div className="grid bg-blue-900">01</div>
                <div>2</div>
                <video width="320" height="240" controls></video>
                <div>2</div>
                <div>3</div>
                <div>6</div>
                <div className="grid bg-blue-900">09</div>
            </body>

        </>
    )
}