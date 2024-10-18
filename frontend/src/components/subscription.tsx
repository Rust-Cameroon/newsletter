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
        <form onSubmit={formik.handleSubmit}>
            <input
                id="email"
                name="email"
                className='input input-bordered input-accentcolor w-full max-w-xs btn rounded-none px-16 ml-10'
                placeholder='example@gmail.com'
                type="email"
                onChange={formik.handleChange}
                value={formik.values.email}
            />
            <button className="btn bg-customPink-500 hover:bg-customPink-700 rounded-none px-9 border-accentcolor">SUBSCRIBE NOW</button>
        </form>
    );
};