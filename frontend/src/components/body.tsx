// src/components/Body.tsx
import { useState } from "react";
import { Post, PostCard } from "./postcard";

function Body() {
    const [posts] = useState<Post[]>([
        {
            id: "1",
            title: "Understanding JavaScript Closures",
            description: "A deep dive into closures and how they work in JavaScript.",
            imageUrl: "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp",
            link: "/post/js-closures"
        },
        {
            id: "2",
            title: "React Performance Optimization",
            description: "Learn how to optimize your React apps for speed and efficiency.",
            imageUrl: "https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp",
            link: "/post/react-performance"
        },
        // Add more posts here or fetch them from an API
    ]);

    return (
        <>
<<<<<<< HEAD
            <h2>
                <button className="btn bg-accentcolor mb-5 hover:bg-accentcolor font-mono font-semibold text-2xl">
                    Recent
                </button>
            </h2>
=======
            <h2><button className="btn bg-accentcolor mb-5 hover:bg-accentcolor font-mono font-semibold text-2xl">Recent</button></h2>

            <div className="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-12 justify-content-center ">
                {[
                    'Primary',
                    'Secondary',
                    'Success',
                    'Danger',
                    'Warning',
                    'Info',
                    'Light',
                    'Dark',

                ].map(() => (
                    <div className="card card-compact bg-base-100 w-96 shadow-2xl hover:shadow-md self-center">
                        <figure>
                            <img
                                src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                                alt="POSTS" />
                        </figure>
                        <a href="https://medium.com/@yemelechristian2/didcomm-messaging-vs-email-messaging-b98a3e116c82">
                            <div className="card-body" >
                                <h2 className="card-title">Know more</h2>
                                <p>Keep reading—valuable insights await just ahead.</p>
                                <div className="card-actions justify-end">
                                    <button className="btn btn-primary">Continue...</button>
                                </div>
                            </div>
                        </a>
                    </div>
>>>>>>> f4b0d0405e06c31b0b688cbf51f9570c17dc64ff

            <div className="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-12 justify-content-center">
                {posts.map((post) => (
                    <PostCard key={post.id} post={post} />
                ))}
            </div>
        </>
    );
}

export default Body;
