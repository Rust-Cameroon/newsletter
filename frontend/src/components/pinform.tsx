
import { useFormik } from 'formik';

import OtpInput from 'formik-otp-input';
import { useState } from 'react';
import { Alert } from './response';
import { useNavigate } from 'react-router-dom';


const formStyle: React.CSSProperties = {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    padding: '20px',
};



const errorTextStyle = {
    marginTop: '15px',
    fontSize: '14px',
    color: '#ff6b6b',
    marginBottom: '10px',
};

const submitButtonStyle = {
    padding: '10px 20px',
    backgroundColor: '#4caf50',
    color: 'white',
    border: 'none',
    borderRadius: '5px',
    cursor: 'pointer',
    marginTop: '20px',
};


const OtpForm = () => {
    const URL = import.meta.env.VITE_BACKEND_URL;
    const navigate = useNavigate();
    const [alertMessage, setAlertMessage] = useState<string | null>(null);
    const formik = useFormik({
        initialValues: {
            otp: '',

        },
        onSubmit: (values) => {

            fetch(`${URL}/verify_otp`, {
                method: 'POST',
                headers: {

                    'Content-Type': 'application/json',

                    "Access-Control-Allow-Origin": "*",
                },
                body: JSON.stringify({
                    code: values.otp

                })
            })
                .then(async (response) => {
                    if (!response.ok) {
                        const message = await response.text();
                        setAlertMessage(message);
                        throw new Error(message);
                    }
                    return response;
                })
                .then(() => navigate('/'))
                .catch((error) => {
                    setAlertMessage(error.message);
                });
        },
    });

    return (
        <>
            {alertMessage && (
                <Alert
                    message={alertMessage}
                    onClose={() => setAlertMessage(null)}
                />
            )}
            <form style={formStyle} onSubmit={formik.handleSubmit}>
                <OtpInput
                    length={6}
                    value={formik.values.otp}
                    inputType={"numeric"}
                    autoFocus={true}
                    autoSubmit={true}
                    onBlur={formik.handleBlur}
                    onChange={formik.handleChange}
                    onFullFill={formik.handleSubmit}
                    setFieldError={formik.setFieldError}
                    setFieldTouched={formik.setFieldTouched}

                    highlightColor={'#4caf50'}

                    backgroundColor='gray'

                />
                {formik.errors.otp && formik.touched.otp && (
                    <div style={errorTextStyle}>{formik.errors.otp}</div>
                )}
                <button type="submit" style={submitButtonStyle} >Submit</button>
            </form>
        </>
    );
};

export default OtpForm;