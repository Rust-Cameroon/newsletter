import { SignupForm } from "./subscription";

export function Navbar() {
    return (
        <>
            <nav className="navi scroll-smooth bg-neutral-800 dark:bg-black-700 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
                <div className="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 ">
                    <a href="/" className="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="../src/assets/rustcm.svg" className="h-20" alt="Rust Cameroon Logo" />
                        <span className="self-center text-2l font-semibold whitespace-nowrap dark:text-white font-mono">Rust Cameroon</span>
                    </a>
                    <div className="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                        <button type="button" className="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-base px-7 py-2.5 text-center bg-customPink-500">Subscribe To Rust Cameroon</button>

                    </div>
                    <div className="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                        <ul className="flex flex-col p-4 md:p-0 mt-4 font-medium border md:space-x-9 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-neutral-800 flex">

                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-customPink-500 md:p-0 md:dark:hover:text-customPink-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold font-mono">Articles</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-customPink-500 md:p-0 md:dark:hover:text-customPink-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold font-mono">Events</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-customPink-500 md:p-0 md:dark:hover:text-customPink-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold font-mono">Archives</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-customPink-500 md:p-0 md:dark:hover:text-customPink-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold font-mono">Jobs</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-customPink-500 md:p-0 md:dark:hover:text-customPink-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold font-mono">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div className="relative flex py-5 items-center">
                    <div className="flex-grow border-t border-gray-400"></div>

                    <div className="flex-grow border-t border-gray-400"></div>
                </div>
                <div className="flex justify-center">
                    <div className="flex justify-center items-center text-white text-xl max-w-prose">
                        <div className="card-body">
                            <h2 className="card-title">Welcome to Rust Cameroon!</h2>
                            <p>We're building a vibrant, inclusive, and passionate Rust community right here in Cameroon. Whether you're a seasoned Rustacean or just starting your journey, you're in the right place. Our mission is to promote the use of Rust, foster collaboration, and empower developers through learning and sharing. Join us as we explore the possibilities Rust offers, from systems programming to web development, embedded systems, and beyond. Through meetups, workshops, and events, we aim to connect Rust enthusiasts, share knowledge, and build amazing projects together.
                            </p>
                            <div className="mt-12">
                                <SignupForm />
                            </div>
                        </div>
                    </div>
                </div>

            </nav>



        </>
    )
}