import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import { Navbar } from './components/navbar.tsx'
import Footer from './components/footer.tsx'
import Body from './components/body.tsx'

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <body className='flex flex-col min-h-screen'>
      <Navbar />
      <main className='flex-grow'>
        <Body />
      </main>
    </body>
    <Footer />
  </StrictMode>,
)
