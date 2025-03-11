import { useFormik } from 'formik';
import { useNavigate } from 'react-router-dom';
import { useState } from 'react';
import { Alert } from './response';

export const SignupForm = () => {
  const navigate = useNavigate();
  const [alertMessage, setAlertMessage] = useState<string | null>(null);

  const URL = import.meta.env.VITE_BACKEND_URL && "localhost:8000";


  const formik = useFormik({
    initialValues: {
      email: '',
    },

    onSubmit: (values) => {
      fetch(`${URL}/subscribe`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*',
        },
        body: JSON.stringify({ email: values.email }),
      })
        .then(async (response) => {
          if (!response.ok) {
            const message = await response.text();
            setAlertMessage(message);
            throw new Error(message);
          }
          return response;
        })
        .then(() => navigate('/email_verification'))
        .catch((error) => {
          setAlertMessage(error.message);
        });
    },
  });

  return (
    <div className="relative">
      {alertMessage && (
        <Alert
          message={alertMessage}
          onClose={() => setAlertMessage(null)} // Dismiss alert when the close button is clicked
        />
      )}
      <div className="grid grid-cols-1 lg:grid-cols-2 justify-center justify-stretch rounded-full">
        <div>
          <form onSubmit={formik.handleSubmit}>
            <input
              id="email"
              name="email"
              className="input border-white btn w-full"
              placeholder="example@gmail.com"
              type="email"
              onChange={formik.handleChange}
              value={formik.values.email}
            />
          </form>
        </div>
        <div>
          <button
            onClick={(e) => {
              e.preventDefault();
              formik.handleSubmit();
            }}
            className="btn bg-customPink-500 hover:bg-customPink-700 w-full border-white"
          >
            SUBSCRIBE NOW
          </button>
        </div>
      </div>
    </div>
  );
};
