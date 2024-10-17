import Body from "./body";
import Footer from "./footer";
import { SignupForm } from "./subscription";

export function Navbar() {
    return (
        <>
            <nav className="bg-neutral-700 dark:bg-black-700 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
                <div className="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 ">
                    <a href="/" className="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="../src/assets/rustcm.png" className="h-20" alt="Rust Cameroon Logo" />
                        <span className="self-center text-2l font-semibold whitespace-nowrap dark:text-white">Rust Cameroon</span>
                    </a>
                    <div className="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                        <button type="button" className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-7 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-secondary-700 dark:focus:ring-blue-800">Subscribe To Rust Cameroon</button>

                    </div>
                    <div className="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                        <ul className="flex flex-col p-4 md:p-0 mt-4 font-medium border md:space-x-9 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-neutral-700 flex">

                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold">Articles</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold">Events</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold">Archives</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold">Jobs</a>
                            </li>
                            <li>
                                <a href="#" className="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 text-xl font-semibold hover:font-bold">Contact</a>
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
                            <h2 className="card-title">Card title!</h2>
                            <p>If a dog chews shoes whose shoes does he choose?Lorem ipsum dolor sit amet. sit!</p>
                            <div className="mt-10">
                              <SignupForm/>
                            </div>
                        </div>
                    </div>
                </div>
                
            </nav>
         


        </>
    )
}