import React, { useState } from "react";
import { Link } from "react-router-dom";
import { Info, MessageCircle } from "lucide-react";
import ConsultationModal from "./ConsultationModal";

function ProductCard({ product, settings }) {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const images = Array.isArray(product.images) ? product.images : [];
    const mainImage = images.find((img) => img.is_main === 1) || images[0];
    const imageUrl = mainImage
        ? (mainImage.image_path && mainImage.image_path.startsWith("http") 
            ? mainImage.image_path 
            : `/storage/${mainImage.image_path}`)
        : "/product/default.jpg";

    const availabilityConfig = {
        in_stock: { label: "Còn hàng",  cls: "bg-emerald-500" },
        sold:     { label: "Đã bán",    cls: "bg-red-500"     },
        display:  { label: "Trưng bày", cls: "bg-amber-500"   },
    };
    const avail = availabilityConfig[product.availability_status] || availabilityConfig.in_stock;

    return (
        <>
            <div className="group bg-white rounded-xl shadow-sm border border-stone-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                {/* Image & Overlay */}
                <div className="relative overflow-hidden bg-stone-100 aspect-[4/5]">
                    <img
                        src={imageUrl}
                        alt={product.name}
                        className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        onError={(e) => { e.target.src = "/product/default.jpg"; }}
                    />

                    {/* Availability badge */}
                    <div className={`absolute top-3 left-3 ${avail.cls} text-white text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded shadow-sm z-10`}>
                        {avail.label}
                    </div>

                    {/* Dual Option Hover Overlay */}
                    <div className="absolute inset-0 bg-stone-900/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-3 p-4">
                        <Link
                            to={`/products/${product.slug || product.id}`}
                            className="w-full max-w-[160px] bg-white text-stone-800 text-sm font-bold py-2.5 rounded-full hover:bg-amber-50 transition transform hover:-translate-y-1 flex items-center justify-center gap-2 shadow-lg"
                        >
                            <Info className="w-4 h-4" />
                            Xem chi tiết
                        </Link>
                        <button
                            onClick={() => setIsModalOpen(true)}
                            className="w-full max-w-[160px] bg-amber-600 text-white text-sm font-bold py-2.5 rounded-full hover:bg-amber-700 transition transform hover:-translate-y-1 flex items-center justify-center gap-2 shadow-lg"
                        >
                            <MessageCircle className="w-4 h-4" />
                            Nhận tư vấn
                        </button>
                    </div>
                </div>

                {/* Info */}
                <div className="p-4 border-t border-stone-50">
                    <div className="text-[10px] text-amber-700 font-bold uppercase tracking-widest mb-1">
                        {product.category?.name || "Đồ cổ"}
                    </div>
                    <Link to={`/products/${product.slug || product.id}`}>
                        <h3
                            className="text-lg font-bold text-stone-800 mb-2 line-clamp-2 hover:text-amber-800 transition-colors duration-200"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            {product.name}
                        </h3>
                    </Link>

                    <div className="flex items-center justify-between">
                        <span className="text-sm italic text-stone-500">{product.period}</span>
                        <span className="text-amber-800 font-bold">Giá: {product.price}</span>
                    </div>
                </div>
            </div>

            <ConsultationModal 
                isOpen={isModalOpen} 
                onClose={() => setIsModalOpen(false)} 
                product={product} 
                settings={settings}
            />
        </>
    );
}

export default ProductCard;
