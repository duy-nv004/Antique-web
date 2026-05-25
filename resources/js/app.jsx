import React, { useState, useEffect } from "react";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import axios from "axios";
import Navbar from "./components/Navbar";
import Footer from "./components/Footer";
import Home from "./pages/Home";
import ProductList from "./pages/ProductList";
import ProductDetail from "./pages/ProductDetail";
import Contact from "./pages/Contact";

function App() {
    const [settings, setSettings] = useState({});

    useEffect(() => {
        axios.get("/api/settings")
            .then((res) => setSettings(res.data))
            .catch((err) => console.error("Error fetching settings:", err));
    }, []);

    return (
        <Router>
            <div className="min-h-screen bg-stone-50 flex flex-col">
                <Navbar settings={settings} />
                
                <main className="flex-grow">
                    <Routes>
                        <Route path="/" element={<Home settings={settings} />} />
                        <Route path="/home" element={<Home settings={settings} />} />
                        <Route path="/products" element={<ProductList settings={settings} />} />
                        <Route path="/products/:slug" element={<ProductDetail settings={settings} />} />
                        <Route path="/contact" element={<Contact settings={settings} />} />
                    </Routes>
                </main>

                <Footer settings={settings} />
            </div>
        </Router>
    );
}

export default App;
