import React from 'react';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import OtpInput from 'formik-otp-input';

const YOUR_OTP_LENGTH = 6; // Replace this with the length of your OTP


// CSS Styles, adjust according to your needs
const formStyle = {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    padding: '20px',
};

const fieldStyle = {
    margin: '10px 0',
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

// Form component
const OtpForm = () => {
    const formik = useFormik({
        initialValues: {
            otp: '',
            // ... other form fields if you wish
        },
        onSubmit: (values) => {
            console.log('Form data:', values);
            window.alert(`Submitted otp value = ${values.otp}`);
            // Perform submission actions
        },
    });

    return (
        <form style={formStyle} onSubmit={formik.handleSubmit}>
            <OtpInput
                length={6}
                value={formik.values.otp}
                inputType={"numeric"}    // Default is numeric. Options are numeric, alphabetic or alphanumeric
                autoFocus={true}    // Default is true. Will auto-focus first digit if true
                autoSubmit={true}    // Default is true. Will auto-submit form onFullFill
                onBlur={formik.handleBlur}   // Formik handler, used to handle onBlur events
                onChange={formik.handleChange}   // Formik handler, used to handle change events
                onFullFill={formik.handleSubmit}     // Formik handler, used to handle autoSubmit
                setFieldError={formik.setFieldError}     // Formik handler, used to handle error rendering
                setFieldTouched={formik.setFieldTouched}
                // ... other props you can pass
                highlightColor={'#4caf50'}
                // textColor={'#FFFFFF'}
                 backgroundColor='gray'
                // borderColor={'#FFFFFF'}
                // ... override any pre-existing styles if required
                // style={{
                //     'backgroundColor': '#ffc300'
                // }}
            />
            {formik.errors.otp && formik.touched.otp && (
                <div style={errorTextStyle}>{formik.errors.otp}</div>
            )}
            <button type="submit" style={submitButtonStyle} >Submit</button>
        </form>
    );
};

export default OtpForm;