
import { useFormik } from 'formik';

import OtpInput from 'formik-otp-input';



// CSS Styles, adjust according to your needs
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

// Form component
const OtpForm = () => {
    const formik = useFormik({
        initialValues: {
            otp: '',
            // ... other form fields if you wish
        },
        onSubmit: (values) => {
          
            fetch('http://localhost:8000/verify_otp', {
                method: 'POST',
                headers: {

                    'Content-Type': 'application/json',

                    "Access-Control-Allow-Origin": "*",
                },
                body: JSON.stringify({
                    code: values.otp

                })
            })
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