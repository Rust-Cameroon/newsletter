import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import './App.css'
import { Navbar } from './components/navbar.tsx'
import Footer from './components/footer.tsx'
import Body from './components/body.tsx'

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <body className='scroll-smooth'>
      <Navbar />
      <main className='flex-grow main '>
        <Body />
      </main>
    </body>
    <Footer />
  </StrictMode>,
)
