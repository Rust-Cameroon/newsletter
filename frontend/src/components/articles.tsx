export default function Articles() {
    return (
        <>
            <h2><button className="btn bg-accentcolor mb-5 hover:bg-accentcolor font-mono font-semibold text-2xl">Articles</button></h2>

            <div className="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-12 justify-content-center ">
                {[
                    "https://medium.com/@yemelechristian2/didcomm-messaging-vs-email-messaging-b98a3e116c82"
                ].map((a) => (
                    <div className="card card-compact bg-base-100 w-96 shadow-2xl hover:shadow-md self-center">
                        <figure>
                            <img
                                src={a}
                    ></img>
                        </figure>
                        <a href={a}>
                            <div className="card-body" >

                                <div className="card-actions justify-end">
                                    <button className="btn btn-primary">View</button>
                                </div>
                            </div>
                        </a>
                    </div>

                ))}
            </div>
        </>
    );
}

