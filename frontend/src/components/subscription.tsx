import axios from 'axios';
import { useFormik } from 'formik';

export const SignupForm = () => {
    // Pass the useFormik() hook initial form values and a submit function that will
    // be called when the form is submitted
    const formik = useFormik({
        initialValues: {
            email: '',
        },
        onSubmit: value => {
            axios.post("http://localhost:8000/subscribe", {
                email: value
            })
        },
    });
    return (
        <div className='grid grid-cols-1 lg:grid-cols-2 justify-center justify-stretch rounded-full'>
            <div>
                <form onSubmit={formik.handleSubmit}>
                    <input
                        id="email"
                        name="email"
                        className='input border-white btn w-full'
                        placeholder='example@gmail.com'
                        type="email"
                        onChange={formik.handleChange}
                        value={formik.values.email}
                    />
                </form>
            </div>
            <div>
                <button className="btn bg-customPink-500 hover:bg-customPink-700 w-full border-white">SUBSCRIBE NOW</button>
            </div>
        </div>
    );
};