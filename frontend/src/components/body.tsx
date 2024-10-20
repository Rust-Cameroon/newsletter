function Body() {
    return (
        <>
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

                ].map((variant) => (
                    <div className="card card-compact bg-base-100 w-96 shadow-2xl hover:shadow-md self-center">
                        <figure>
                            <img
                                src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                                alt="Shoes" />
                        </figure>
                        <a href="https://medium.com/@yemelechristian2/didcomm-messaging-vs-email-messaging-b98a3e116c82">
                            <div className="card-body" >
                                <h2 className="card-title">Shoes!</h2>
                                <p>If a dog chews shoes whose shoes does he choose?</p>
                                <div className="card-actions justify-end">
                                    <button className="btn btn-primary">Buy Now</button>
                                </div>
                            </div>
                        </a>
                    </div>

                ))}
            </div>
        </>
    );
}

export default Body;