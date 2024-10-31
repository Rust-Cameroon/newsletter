import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import './App.css'

import { createBrowserRouter, RouterProvider } from 'react-router-dom'
import OtpForm from './components/pinform.tsx'
import App from './App.tsx'

const router = createBrowserRouter([
  {
    path: "/email_verification",
    element: <OtpForm />
  },
  {
    path: "/",
    element: <  App/>
  }
]);

createRoot(document.getElementById('root')!).render(
  <StrictMode>
<RouterProvider router={router} />
    {/* <body className='scroll-smooth'>
      <Navbar />
      <main className='flex-grow main '>
        <Body />
      </main>
    </body>
    <Footer /> */}
  </StrictMode>,
)
