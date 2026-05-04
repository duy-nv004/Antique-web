import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import axios from "axios";
import Hero from "../components/Hero";
import ProductCard from "../components/ProductCard";

function Home() {
    const [latestProducts, setLatestProducts] = useState([]);
    const [categories, setCategories] = useState([]);
    const [settings, setSettings] = useState({});
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.all([
            axios.get("/api/products?limit=4"),
            axios.get("/api/categories"),
            axios.get("/api/settings"),
        ])
            .then(axios.spread((productsRes, categoriesRes, settingsRes) => {
                const productsData = productsRes.data;
                const categoriesData = categoriesRes.data;
                
                // Đảm bảo dữ liệu luôn là mảng để không bị lỗi .map()
                const productsArray = Array.isArray(productsData) ? productsData : (productsData?.data || []);
                const categoriesArray = Array.isArray(categoriesData) ? categoriesData : (categoriesData?.data || []);
                
                setLatestProducts(productsArray);
                setCategories(categoriesArray);
                setSettings(settingsRes.data || {});
                setLoading(false);
            }))
            .catch((err) => {
                console.error("Error fetching data:", err);
                setLoading(false);
            });
    }, []);

    return (
        <div>
            <Hero categories={categories} />

            {/* Featured Section */}
            <section className="py-20 bg-white">
                <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
                    <div className="flex flex-col md:flex-row md:items-end justify-between mb-12">
                        <div>
                            <p className="text-amber-600 text-sm font-semibold tracking-widest uppercase mb-2">
                                Khám phá ngay
                            </p>
                            <h2 className="text-3xl md:text-4xl font-bold text-stone-800"
                                style={{ fontFamily: "'Playfair Display', serif" }}>
                                Tuyệt Phẩm Mới Về
                            </h2>
                        </div>
                        <Link 
                            to="/products" 
                            className="mt-4 md:mt-0 text-amber-700 font-semibold flex items-center gap-2 hover:text-amber-800 transition-colors"
                        >
                            Xem tất cả bộ sưu tập
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </Link>
                    </div>

                    {loading ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            {[1, 2, 3, 4].map((i) => (
                                <div key={i} className="animate-pulse">
                                    <div className="bg-stone-200 aspect-[4/5] rounded-xl mb-4"></div>
                                    <div className="h-4 bg-stone-200 rounded w-3/4 mb-2"></div>
                                    <div className="h-4 bg-stone-200 rounded w-1/2"></div>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            {latestProducts.map((product) => (
                                <ProductCard key={product.id} product={product} settings={settings} />
                            ))}
                        </div>
                    )}
                </div>
            </section>

            {/* Collections Banner */}
            <section className="py-16 bg-stone-100">
                <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div className="relative group overflow-hidden rounded-2xl h-80 shadow-xl">
                            <img 
                                src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=1000" 
                                alt="Gốm sứ"
                                className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-stone-900/80 to-transparent"></div>
                            <div className="absolute bottom-0 left-0 p-8">
                                <h3 className="text-2xl font-bold text-white mb-2" style={{ fontFamily: "'Playfair Display', serif" }}>Gốm Sứ Triều Nguyễn</h3>
                                <p className="text-stone-300 mb-4">Vẻ đẹp vĩnh cửu từ những nghệ nhân xưa</p>
                                <Link to="/products?category=gc" className="inline-block px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">Khám phá</Link>
                            </div>
                        </div>
                        <div className="relative group overflow-hidden rounded-2xl h-80 shadow-xl">
                            <img 
                                src="https://images.unsplash.com/photo-1590483734724-383b9f449e32?auto=format&fit=crop&q=80&w=1000" 
                                alt="Đồ gỗ"
                                className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-stone-900/80 to-transparent"></div>
                            <div className="absolute bottom-0 left-0 p-8">
                                <h3 className="text-2xl font-bold text-white mb-2" style={{ fontFamily: "'Playfair Display', serif" }}>Nội Thất Gỗ Quý</h3>
                                <p className="text-stone-300 mb-4">Sự sang trọng và đẳng cấp của thời gian</p>
                                <Link to="/products?category=go" className="inline-block px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">Khám phá</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}

export default Home;
