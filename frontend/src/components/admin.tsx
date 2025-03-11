import { useState, useEffect } from "react";

export default function Newsletter() {
    const [posts, setPosts] = useState<any[]>([]);
    const [title, setTitle] = useState("");
    const [content, setContent] = useState("");
    const [imageUrl, setImageUrl] = useState("");
    const [link, setLink] = useState("");
    const [message, setMessage] = useState("");

    useEffect(() => {
        fetch("http://localhost:8000/posts")
            .then((res) => res.json())
            .then((data) => setPosts(data))
            .catch((err) => console.error("Error fetching posts:", err));
    }, []);

    const handleSubmit = async (e: { preventDefault: () => void; }) => {
        e.preventDefault();

        const newPost = {
            title,
            content,
            image_url: imageUrl || null, // Store as null if empty
            link: link || null,
        };

        try {
            const res = await fetch("http://localhost:8000/posts", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(newPost),
            });

            if (res.ok) {
                const savedPost = await res.json();
                setPosts([savedPost, ...posts]);
                setTitle("");
                setContent("");
                setImageUrl("");
                setLink("");
                setMessage("Post added successfully!");
            } else {
                setMessage("Failed to add post.");
            }
        } catch (error) {
            console.error("Error adding post:", error);
            setMessage("Error adding post.");
        }
    };

    return (
        <div style={{ maxWidth: "600px", margin: "auto", padding: "20px" }}>
            <h2>Newsletter</h2>

            <form onSubmit={handleSubmit} style={{ marginBottom: "20px" }}>
                <input
                    type="text"
                    placeholder="Title"
                    value={title}
                    onChange={(e) => setTitle(e.target.value)}
                    required
                    style={{ display: "block", width: "100%", marginBottom: "10px", padding: "8px" }}
                />
                <textarea
                    placeholder="Content"
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    required
                    style={{
                        display: "block",
                        width: "100%",
                        marginBottom: "10px",
                        padding: "8px",
                        height: "100px",
                    }}
                />
                <input
                    type="text"
                    placeholder="Image URL (optional)"
                    value={imageUrl}
                    onChange={(e) => setImageUrl(e.target.value)}
                    style={{ display: "block", width: "100%", marginBottom: "10px", padding: "8px" }}
                />
                <input
                    type="text"
                    placeholder="External Link (optional)"
                    value={link}
                    onChange={(e) => setLink(e.target.value)}
                    style={{ display: "block", width: "100%", marginBottom: "10px", padding: "8px" }}
                />
                <button type="submit" style={{ padding: "10px", width: "100%" }}>
                    Add Post
                </button>
            </form>
            {message && <p>{message}</p>}

            <h3>Latest Posts</h3>
            {posts.length === 0 ? (
                <p>No posts available.</p>
            ) : (
                posts.map((post) => (
                    <div
                        key={post.id}
                        style={{
                            borderBottom: "1px solid #ddd",
                            paddingBottom: "10px",
                            marginBottom: "10px",
                        }}
                    >
                        <h4>{post.title}</h4>
                        <p>{post.content}</p>
                        {post.image_url && <img src={post.image_url} alt="Post Image" style={{ width: "100%" }} />}
                        {post.link && (
                            <p>
                                <a href={post.link} target="_blank" rel="noopener noreferrer">
                                    Read more
                                </a>
                            </p>
                        )}
                    </div>
                ))
            )}
        </div>
    );
}
