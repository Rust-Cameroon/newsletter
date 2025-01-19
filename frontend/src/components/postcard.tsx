// src/components/PostCard.tsx
export type Post = {
    id: string;
    title: string;
    description: string;
    imageUrl: string;
    link: string;
};

export function PostCard({ post }: { post: Post }) {
    return (
        <div className="card card-compact bg-base-100 w-96 shadow-2xl hover:shadow-md self-center">
            <figure>
                <img src={post.imageUrl} alt={post.title} />
            </figure>
            <a href={post.link}>
                <div className="card-body">
                    <h2 className="card-title">{post.title}</h2>
                    <p>{post.description}</p>
                    <div className="card-actions justify-end">
                        <button className="btn btn-primary">Read More</button>
                    </div>
                </div>
            </a>
        </div>
    );
}
