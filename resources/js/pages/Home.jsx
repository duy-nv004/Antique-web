import React, { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import ProductCard from "../components/ProductCard";

const slides = [
    {
        image: "https://lh3.googleusercontent.com/aida-public/AB6AXuByOqS1QReN_nPbDl-2qmXoJ43c9W8VJAIAKaUsyxAgpMIAdwX9eQh47LAwna5MS6lo01aJSJcr4mzWrC1JqejxkrHpTlHY6lntgC9v--CxeaxlcwmWkDm86jAYbFcAjfBXqVzW8oAiPlomPP5n5_sOHZ1mANXRY1rrNGhoPsjuSQLs_FHv7Z_aX-9_H0BJKsoPR_sm4YX1MHLm-k6Sn41l-aKC1PxMjCl8Rhb1DaL1XbbbYVQSgM42Ts8Jg1GiHCellNRZCcZ4dYYs",
        title: "Gìn Giữ Di Sản Việt",
        subtitle: "Established 1924"
    },
    {
        image: "https://lh3.googleusercontent.com/aida-public/AB6AXuBR7poYmUz7ZcWd853pKjdHybZq2ggNMlACz7HWVWM4wrrLPNAyeGJ600uoW3-wHJpegOVxlcKIl_ePESqUGd7zbVMUidB-MaFlg-0heDk1AnN5JcySLE---dP247UQYG79oEgfnT5MqWnxceHxjOdgYnQaG4uENhZO6uzAe-rSfkT5fBuLouO_Ru8YoJQ4yosmaqwRG1bjRNh5vRSefh87lIRN74ubhJOjW9QZQmiI0CuYCBq_F1ptaOmfjkSt7epGXAcTYyK2tiGr",
        title: "Không Gian Hoài Niệm",
        subtitle: "Discovered Elegance"
    },
    {
        image: "https://lh3.googleusercontent.com/aida-public/AB6AXuAVF1ZMMoGzbSN9svnf5PouYpRB4xLER02KWdtZlSD7wkQawUGQyxp9G0NvioRT1WpxeDqku1kgAsTDpqRONby4JrsjQBla4fsHmz5crnxmzV1u7v4eP29WzfP34l7T_ElyqQKuzXwIMxDKAyEsi_ZWJ8EJYty1DqH8tLqA7Otf8h4T4H9N-qiP1KeEf60xmDuBaNJSKVKIDX2CqFqWf7OXdIXBlTO04kB-dMhOzjeNabtFLT3aRefKpW8_RtdG6339g1FNOAtVi5LD",
        title: "Tinh Hoa Mỹ Thuật",
        subtitle: "Imperial Archives"
    }
];

function Home({ settings }) {
    const navigate = useNavigate();
    const [latestProducts, setLatestProducts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [currentSlide, setCurrentSlide] = useState(0);

    useEffect(() => {
        axios.get("/api/products?limit=4")
            .then((res) => {
                const productsData = res.data;
                const productsArray = Array.isArray(productsData) ? productsData : (productsData?.data || []);

                setLatestProducts(productsArray);
                setLoading(false);
            })
            .catch((err) => {
                console.error("Error fetching products:", err);
                setLoading(false);
            });
    }, []);

    // Automatic slide transitions
    useEffect(() => {
        const timer = setInterval(() => {
            setCurrentSlide((prev) => (prev + 1) % slides.length);
        }, 6000);
        return () => clearInterval(timer);
    }, []);


    const activeProducts = latestProducts;

    return (
        <div className="bg-white min-h-screen text-stone-800">
            {/* Hero Section */}
            <section className="relative h-[550px] md:h-[700px] w-full overflow-hidden">
                {slides.map((slide, idx) => (
                    <div
                        key={idx}
                        className={`absolute inset-0 transition-opacity duration-1000 ease-in-out ${idx === currentSlide ? "opacity-100 z-10" : "opacity-0 z-0"
                            }`}
                    >
                        <img
                            className="w-full h-full object-cover"
                            src={slide.image}
                            alt={slide.title}
                        />
                        <div className="absolute inset-0 hero-gradient"></div>
                        <div className="relative z-10 h-full flex flex-col justify-center items-center text-center px-6">
                            <span className="font-sans text-xs font-bold text-amber-300 uppercase tracking-[0.25em] mb-4">
                                {slide.subtitle}
                            </span>
                            <h2
                                className="text-white text-4xl md:text-6xl mb-8 max-w-4xl tracking-tight leading-tight"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                {slide.title}
                            </h2>
                            <button
                                onClick={() => navigate("/products")}
                                className="bg-amber-700 hover:bg-amber-600 px-8 py-3.5 text-white font-sans text-sm font-bold uppercase tracking-wider transition-all duration-300 rounded-xl shadow-lg hover:shadow-amber-900/40 hover:-translate-y-0.5"
                            >
                                Khám phá bộ sưu tập
                            </button>
                        </div>
                    </div>
                ))}

                {/* Slider Dot Indicators */}
                <div className="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex gap-4">
                    {slides.map((_, idx) => (
                        <button
                            key={idx}
                            onClick={() => setCurrentSlide(idx)}
                            className={`transition-all duration-300 ${idx === currentSlide
                                    ? "active-dot w-2.5 h-2.5"
                                    : "w-2 h-2 border border-white rotate-45 opacity-60 hover:opacity-100"
                                }`}
                            aria-label={`Go to slide ${idx + 1}`}
                        />
                    ))}
                </div>
            </section>

            {/* Latest Arrivals Section (Staggered Bento Grid) */}
            <section className="px-6 md:px-12 lg:px-20 py-20 md:py-24 max-w-[1440px] mx-auto font-sans">
                <div className="flex flex-col md:flex-row md:items-end justify-between mb-16">
                    <div>
                        <span className="text-amber-700 text-sm font-semibold tracking-wider uppercase mb-2 block">
                            Khám phá ngay
                        </span>
                        <h3
                            className="text-2xl md:text-3.5xl text-stone-850 font-bold"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            Tuyệt Phẩm Mới Về
                        </h3>
                    </div>
                    <Link
                        to="/products"
                        className="mt-4 md:mt-0 font-sans text-xs font-bold uppercase tracking-wider text-amber-750 border-b-2 border-amber-750 pb-1 hover:text-amber-600 hover:border-amber-600 transition-colors"
                    >
                        Xem tất cả sản phẩm
                    </Link>
                </div>

                {loading ? (
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div className="flex flex-col gap-6">
                            <div className="animate-pulse bg-stone-100 h-[320px] md:h-[480px] rounded-2xl w-full"></div>
                            <div className="animate-pulse bg-stone-100 h-[280px] md:h-[360px] rounded-2xl w-full"></div>
                        </div>
                        <div className="flex flex-col gap-6">
                            <div className="animate-pulse bg-stone-100 h-[260px] md:h-[340px] rounded-2xl w-full"></div>
                            <div className="animate-pulse bg-stone-100 h-[300px] md:h-[460px] rounded-2xl w-full"></div>
                        </div>
                    </div>
                ) : (() => {
                    const renderProductCard = (product, idx) => {
                        const heightClasses = [
                            "h-[320px] md:h-[480px]", // idx 0
                            "h-[260px] md:h-[340px]", // idx 1
                            "h-[280px] md:h-[360px]", // idx 2
                            "h-[300px] md:h-[460px]"  // idx 3
                        ];
                        const cardHeight = heightClasses[idx] || "h-[360px]";

                        // Image resolution
                        const images = Array.isArray(product.images) ? product.images : [];
                        const mainImage = images.find((img) => img.is_main === 1) || images[0];
                        const imageUrl = mainImage
                            ? (mainImage.image_path && mainImage.image_path.startsWith("http") 
                                ? mainImage.image_path 
                                : `/storage/${mainImage.image_path}`)
                            : "/product/default.jpg";

                        // Availability config
                        const availabilityConfig = {
                            in_stock: { label: "Còn hàng",  cls: "bg-emerald-600/90" },
                            sold:     { label: "Đã bán",    cls: "bg-red-600/90"     },
                            display:  { label: "Trưng bày", cls: "bg-amber-600/90"   },
                        };
                        const avail = availabilityConfig[product.availability_status] || availabilityConfig.in_stock;

                        return (
                            <Link
                                key={product.id}
                                to={`/products/${product.slug || product.id}`}
                                className={`relative group overflow-hidden cursor-pointer rounded-2xl shadow-md border border-stone-100 w-full ${cardHeight}`}
                            >
                                {/* Background Image */}
                                <img
                                    className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    src={imageUrl}
                                    alt={product.name}
                                    onError={(e) => { e.target.src = "/product/default.jpg"; }}
                                />
                                
                                {/* Gradient Overlay */}
                                <div className="absolute inset-0 bg-gradient-to-t from-stone-950 via-stone-900/45 to-transparent opacity-85 group-hover:opacity-90 transition-opacity duration-300"></div>
                                
                                {/* Top Badges */}
                                <div className="absolute top-6 left-6 right-6 flex justify-between items-center z-10">
                                    <span className="bg-amber-800 text-white px-3 py-1 font-sans text-[10px] font-bold uppercase tracking-wider rounded">
                                        {product.category?.name || "Cổ vật"}
                                    </span>
                                    <span className={`${avail.cls} text-white text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded shadow-sm`}>
                                        {avail.label}
                                    </span>
                                </div>
                                
                                {/* Bottom Content Info */}
                                <div className="absolute bottom-6 left-6 right-6 text-white z-10 flex flex-col justify-end">
                                    <span className="text-stone-300 text-[10px] md:text-xs font-semibold tracking-wider uppercase mb-1">
                                        {product.period} {product.origin && `• ${product.origin}`}
                                    </span>
                                    <h4
                                        className="text-lg md:text-2xl font-bold mb-1 md:mb-2 group-hover:text-amber-200 transition-colors duration-300 line-clamp-2"
                                        style={{ fontFamily: "'Playfair Display', serif" }}
                                    >
                                        {product.name}
                                    </h4>
                                    <span className="text-amber-400 font-bold text-sm md:text-base mb-2 md:mb-3 block">
                                        Giá: {product.price}
                                    </span>
                                    
                                    {/* Hover CTA */}
                                    <div className="flex items-center gap-1.5 text-amber-300 font-sans text-[10px] md:text-xs font-bold uppercase tracking-wider opacity-0 transform translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 ease-out">
                                        Chi tiết sản phẩm <span className="transition-transform group-hover:translate-x-1 duration-200">→</span>
                                    </div>
                                </div>
                            </Link>
                        );
                    };

                    return (
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                            {/* Column 1 (indexes 0, 2) */}
                            <div className="flex flex-col gap-6">
                                {activeProducts[0] && renderProductCard(activeProducts[0], 0)}
                                {activeProducts[2] && renderProductCard(activeProducts[2], 2)}
                            </div>
                            {/* Column 2 (indexes 1, 3) */}
                            <div className="flex flex-col gap-6">
                                {activeProducts[1] && renderProductCard(activeProducts[1], 1)}
                                {activeProducts[3] && renderProductCard(activeProducts[3], 3)}
                            </div>
                        </div>
                    );
                })()}
            </section>

        </div>
    );
}

export default Home;
