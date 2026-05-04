import React, { useState, useEffect } from "react";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";
import axios from "axios";
import Navbar from "./components/Navbar";
import Footer from "./components/Footer";
import Home from "./pages/Home";
import ProductList from "./pages/ProductList";
import ProductDetail from "./pages/ProductDetail";
import AdminDashboard from "./pages/admin/Dashboard";
import AdminProductManager from "./pages/admin/ProductManager";

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
                        <Route path="/" element={<Home />} />
                        <Route path="/home" element={<Home />} />
                        <Route path="/products" element={<ProductList />} />
                        <Route path="/products/:id" element={<ProductDetail settings={settings} />} />
                        
                        {/* Admin Routes */}
                        <Route path="/admin" element={<AdminDashboard />} />
                        <Route path="/admin/products" element={<AdminProductManager />} />
                    </Routes>
                </main>

                <Footer settings={settings} />
            </div>
        </Router>
    );
}

export default App;
