import React, { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";
import { MessageCircle, Phone, History, ShieldCheck, MapPin, ArrowLeft } from "lucide-react";
import axios from "axios";

function ProductDetail({ settings }) {
    const { id } = useParams();
    const [product, setProduct] = useState(null);
    const [loading, setLoading] = useState(true);
    const [mainImage, setMainImage] = useState("");

    useEffect(() => {
        setLoading(true);
        axios.get(`/api/products/${id}`)
            .then((res) => {
                const data = res.data;
                setProduct(data);
                const images = Array.isArray(data.images) ? data.images : [];
                const mainImg = images.find(img => img.is_main)?.image_path || images[0]?.image_path;
                setMainImage(mainImg ? `/storage/${mainImg}` : "/product/default.jpg");
                setLoading(false);
            })
            .catch((err) => {
                console.error("Error fetching product detail:", err);
                setLoading(false);
            });
    }, [id]);

    const handleContactClick = async (type) => {
        // Record click in database
        try {
            await axios.post("/api/contact-click", { product_id: product.id });
        } catch (err) {
            console.error("Error recording click:", err);
        }

        // Redirect based on type
        if (type === "zalo" && settings?.zalo_phone) {
            window.open(`https://zalo.me/${settings.zalo_phone}`, "_blank");
        } else if (type === "messenger" && settings?.facebook_url) {
            window.open(settings.facebook_url, "_blank");
        } else if (type === "phone" && settings?.hotline) {
            window.location.href = `tel:${settings.hotline}`;
        }
    };

    if (loading) {
        return (
            <div className="min-h-screen flex items-center justify-center bg-stone-50">
                <div className="flex flex-col items-center">
                    <div className="w-16 h-16 border-4 border-amber-200 border-t-amber-800 rounded-full animate-spin mb-4"></div>
                    <p className="text-stone-500 font-serif italic">Đang tìm lại ký ức...</p>
                </div>
            </div>
        );
    }

    if (!product) {
        return (
            <div className="min-h-screen flex flex-col items-center justify-center bg-stone-50">
                <h2 className="text-3xl font-serif text-stone-800 mb-6">Món đồ này chưa được tìm thấy</h2>
                <Link to="/products" className="text-amber-800 flex items-center gap-2 font-bold hover:gap-4 transition-all">
                    <ArrowLeft className="w-5 h-5" /> Quay lại bộ sưu tập
                </Link>
            </div>
        );
    }

    return (
        <div className="bg-stone-50 min-h-screen pt-24 pb-20">
            <div className="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-10">
                {/* Breadcrumbs */}
                <nav className="mb-10 flex items-center gap-2 text-[10px] uppercase tracking-widest font-bold text-stone-400">
                    <Link to="/" className="hover:text-amber-800 transition-colors">Trang chủ</Link>
                    <span className="text-stone-300">/</span>
                    <Link to="/products" className="hover:text-amber-800 transition-colors">Bộ sưu tập</Link>
                    <span className="text-stone-300">/</span>
                    <span className="text-amber-900 truncate">{product.name}</span>
                </nav>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
                    {/* Image Gallery */}
                    <div className="space-y-6">
                        <div className="aspect-[4/5] overflow-hidden rounded-2xl shadow-2xl bg-white border border-stone-200 group">
                            <img 
                                src={mainImage} 
                                alt={product.name}
                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000"
                            />
                        </div>
                        <div className="grid grid-cols-4 gap-4">
                            {Array.isArray(product.images) && product.images.map((img, idx) => (
                                <button 
                                    key={idx}
                                    onClick={() => setMainImage(`/storage/${img.image_path}`)}
                                    className={`aspect-square rounded-xl overflow-hidden transition-all shadow-md transform hover:-translate-y-1 ${
                                        mainImage === `/storage/${img.image_path}` 
                                            ? "ring-4 ring-amber-700 opacity-100" 
                                            : "opacity-60 hover:opacity-100"
                                    }`}
                                >
                                    <img src={`/storage/${img.image_path}`} alt="" className="w-full h-full object-cover" />
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Product Info */}
                    <div className="flex flex-col">
                        <div className="mb-8 border-b border-stone-200 pb-8">
                            <span className="inline-block text-[10px] text-amber-700 font-bold uppercase tracking-[0.2em] mb-4">
                                {product.category?.name || "Tuyệt Phẩm Đồ Cổ"}
                            </span>
                            <h1 className="text-4xl md:text-5xl font-bold text-stone-900 mb-6 leading-tight" style={{ fontFamily: "'Playfair Display', serif" }}>
                                {product.name}
                            </h1>
                            
                            <div className="flex flex-wrap gap-y-4 gap-x-8">
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                                        <History className="w-5 h-5 text-amber-700" />
                                    </div>
                                    <div>
                                        <p className="text-[10px] text-stone-400 uppercase font-bold tracking-wider">Niên đại</p>
                                        <p className="text-sm font-bold text-stone-800">{product.period || "Thế kỷ 19"}</p>
                                    </div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                                        <MapPin className="w-5 h-5 text-amber-700" />
                                    </div>
                                    <div>
                                        <p className="text-[10px] text-stone-400 uppercase font-bold tracking-wider">Xuất xứ</p>
                                        <p className="text-sm font-bold text-stone-800">{product.origin || "Việt Nam"}</p>
                                    </div>
                                </div>
                                <div className="flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center">
                                        <ShieldCheck className="w-5 h-5 text-amber-700" />
                                    </div>
                                    <div>
                                        <p className="text-[10px] text-stone-400 uppercase font-bold tracking-wider">Tình trạng</p>
                                        <p className="text-sm font-bold text-stone-800">{product.condition || "Nguyên bản"}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="bg-white p-8 rounded-3xl shadow-xl shadow-stone-200 border border-stone-100 mb-10 relative overflow-hidden">
                            <div className="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-full -mr-16 -mt-16 opacity-50"></div>
                            
                            <div className="relative">
                                <p className="text-stone-400 text-xs uppercase font-bold tracking-widest mb-2">Giá trị sưu tầm</p>
                                <h3 className="text-3xl font-bold text-amber-800 mb-6">Liên hệ trực tiếp</h3>
                                
                                <div className="space-y-4">
                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <button 
                                            onClick={() => handleContactClick("zalo")}
                                            className="flex items-center justify-center gap-3 px-8 py-4 bg-stone-800 text-white font-bold rounded-2xl hover:bg-amber-800 transition-all shadow-lg hover:-translate-y-1"
                                        >
                                            <MessageCircle className="w-6 h-6" /> Nhận tư vấn Zalo
                                        </button>
                                        <a 
                                            href={`tel:${settings?.hotline || "0985408685"}`}
                                            className="flex items-center justify-center gap-3 px-8 py-4 bg-amber-700 text-white font-bold rounded-2xl hover:bg-amber-800 transition-all shadow-lg hover:-translate-y-1"
                                        >
                                            <Phone className="w-6 h-6" /> Gọi ngay Hotline
                                        </a>
                                    </div>
                                    <p className="text-center text-xs text-stone-400 italic">
                                        * Chúng tôi cam kết bảo mật thông tin và tư vấn tận tâm nhất.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* Description Section */}
                        <div className="space-y-10">
                            <div className="relative">
                                <h3 className="text-2xl font-bold text-stone-800 mb-6 flex items-center gap-3" style={{ fontFamily: "'Playfair Display', serif" }}>
                                    <span className="w-12 h-[2px] bg-amber-700"></span>
                                    Câu Chuyện Lịch Sử
                                </h3>
                                <div 
                                    className="text-stone-600 leading-relaxed text-lg italic font-serif space-y-4"
                                    dangerouslySetInnerHTML={{ __html: product.content || "Món đồ này mang trong mình những giá trị văn hóa và lịch sử vô giá đang chờ bạn khám phá..." }}
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-12 pt-10 border-t border-stone-200">
                                <div>
                                    <h4 className="text-stone-400 text-[10px] uppercase font-bold tracking-widest mb-3">Chất liệu chế tác</h4>
                                    <p className="text-lg font-bold text-stone-800">{product.material || "Chưa xác định"}</p>
                                </div>
                                <div>
                                    <h4 className="text-stone-400 text-[10px] uppercase font-bold tracking-widest mb-3">Kích thước / Trọng lượng</h4>
                                    <p className="text-lg font-bold text-stone-800">Liên hệ tư vấn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default ProductDetail;
