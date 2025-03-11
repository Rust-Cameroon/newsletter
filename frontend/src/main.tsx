import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import './App.css'

import { createBrowserRouter, RouterProvider } from 'react-router-dom'
import OtpForm from './components/pinform.tsx'
import App from './App.tsx'
import Articles from './components/articles.tsx'
import AdminPanel from './components/admin.tsx'

const router = createBrowserRouter([
  {
    path: "/email_verification",
    element: <OtpForm />
  },
  {
    path: "/",
    element: <  App />
  }, {
    path: "/articles",
    element: <Articles />
  },
  {
    path: "/admin",
    element: <AdminPanel />

  }
]);

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <RouterProvider router={router} />

  </StrictMode>,
)
