
import { useFormik } from 'formik';
import { FormEvent, MouseEventHandler } from 'react';

export const SignupForm = () => {
    // Pass the useFormik() hook initial form values and a submit function that will
    // be called when the form is submitted
    const formik = useFormik({
        initialValues: {
            email: '',
        },
        onSubmit: value => {
            fetch('http://localhost:8000/subscribe', {
                method: 'POST',
                headers: {

                    'Content-Type': 'application/json',

                    "Access-Control-Allow-Origin": "*",
                },
                body: JSON.stringify({
                    email: value.email

                })
            })
                .then(response => alert(response.text()))
                .then(data => console.log(data));
        },
    })
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
                <button onClick={(e) => {
                    e.preventDefault();
                    formik.handleSubmit();
                }} className="btn bg-customPink-500 hover:bg-customPink-700 w-full border-white">SUBSCRIBE NOW</button>

            </div>
        </div>
    );
};

