import Body from "./components/body";
import Footer from "./components/footer";
import { Navbar } from "./components/navbar";

export default function App() {
  return (
    <>
    <body className='scroll-smooth'>
    <Navbar />
    <main className='flex-grow main '>
      <Body />
    </main>
  </body>
  <Footer />
  </>
  )
}