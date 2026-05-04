import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { 
    BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer,
    LineChart, Line, PieChart, Pie, Cell
} from "recharts";
import { 
    LayoutDashboard, Package, MessageSquare, Plus, 
    TrendingUp, Users, ArrowRight 
} from "lucide-react";

const COLORS = ["#d97706", "#059669", "#2563eb", "#7c3aed", "#db2777"];

function AdminDashboard() {
    const [stats, setStats] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch("/api/admin/stats")
            .then(res => res.json())
            .then(data => {
                setStats(data);
                setLoading(false);
            })
            .catch(err => {
                console.error("Error fetching stats:", err);
                setLoading(false);
            });
    }, []);

    if (loading) return (
        <div className="flex items-center justify-center min-h-screen">
            <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-amber-600"></div>
        </div>
    );

    return (
        <div className="bg-stone-50 min-h-screen p-8 pt-24">
            <div className="max-w-7xl mx-auto">
                <div className="flex justify-between items-center mb-10">
                    <div>
                        <h1 className="text-3xl font-bold text-stone-900" style={{ fontFamily: "'Playfair Display', serif" }}>Hệ Thống Quản Trị</h1>
                        <p className="text-stone-500">Tổng quan tình hình kinh doanh đồ cổ</p>
                    </div>
                    <Link 
                        to="/admin/products" 
                        className="bg-amber-700 text-white px-6 py-3 rounded-xl font-bold flex items-center gap-2 hover:bg-amber-800 transition-all shadow-lg shadow-amber-900/20"
                    >
                        <Package className="w-5 h-5" /> Quản lý sản phẩm
                    </Link>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                    <div className="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm">
                        <div className="flex justify-between items-start mb-4">
                            <div className="bg-amber-100 p-3 rounded-xl">
                                <Package className="w-6 h-6 text-amber-700" />
                            </div>
                            <span className="text-green-500 text-sm font-bold flex items-center gap-1">
                                <TrendingUp className="w-4 h-4" /> +12%
                            </span>
                        </div>
                        <h3 className="text-stone-500 text-sm font-medium uppercase tracking-wider">Tổng sản phẩm</h3>
                        <p className="text-3xl font-bold text-stone-900">{stats?.totals?.products || 0}</p>
                    </div>

                    <div className="bg-white p-6 rounded-2xl border border-stone-100 shadow-sm">
                        <div className="flex justify-between items-start mb-4">
                            <div className="bg-blue-100 p-3 rounded-xl">
                                <MessageSquare className="w-6 h-6 text-blue-700" />
                            </div>
                            <span className="text-green-500 text-sm font-bold flex items-center gap-1">
                                <TrendingUp className="w-4 h-4" /> +25%
                            </span>
                        </div>
                        <h3 className="text-stone-500 text-sm font-medium uppercase tracking-wider">Lượt liên hệ tư vấn</h3>
                        <p className="text-3xl font-bold text-stone-900">{stats?.totals?.clicks || 0}</p>
                    </div>

                    <div className="bg-stone-900 p-6 rounded-2xl border border-stone-800 shadow-xl text-white">
                        <div className="flex justify-between items-start mb-4">
                            <div className="bg-white/10 p-3 rounded-xl">
                                <Users className="w-6 h-6 text-white" />
                            </div>
                        </div>
                        <h3 className="text-stone-400 text-sm font-medium uppercase tracking-wider">Khách hàng quan tâm</h3>
                        <p className="text-3xl font-bold">{Math.round((stats?.totals?.clicks || 0) * 0.8)}</p>
                    </div>
                </div>

                {/* Charts Section */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {/* Category Chart */}
                    <div className="bg-white p-8 rounded-2xl border border-stone-100 shadow-sm">
                        <h3 className="text-lg font-bold text-stone-800 mb-6 flex items-center gap-2">
                            Thống kê theo danh mục
                        </h3>
                        <div className="h-80">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart data={stats?.category_stats}>
                                    <CartesianGrid strokeDasharray="3 3" vertical={false} />
                                    <XAxis dataKey="name" />
                                    <YAxis />
                                    <Tooltip 
                                        contentStyle={{ borderRadius: '12px', border: 'none', boxShadow: '0 10px 15px -3px rgb(0 0 0 / 0.1)' }}
                                    />
                                    <Bar dataKey="count" fill="#d97706" radius={[4, 4, 0, 0]} barSize={40} />
                                </BarChart>
                            </ResponsiveContainer>
                        </div>
                    </div>

                    {/* Clicks Timeline */}
                    <div className="bg-white p-8 rounded-2xl border border-stone-100 shadow-sm">
                        <h3 className="text-lg font-bold text-stone-800 mb-6 flex items-center gap-2">
                            Lượt liên hệ theo ngày
                        </h3>
                        <div className="h-80">
                            <ResponsiveContainer width="100%" height="100%">
                                <LineChart data={stats?.click_stats}>
                                    <CartesianGrid strokeDasharray="3 3" vertical={false} />
                                    <XAxis dataKey="date" />
                                    <YAxis />
                                    <Tooltip 
                                        contentStyle={{ borderRadius: '12px', border: 'none', boxShadow: '0 10px 15px -3px rgb(0 0 0 / 0.1)' }}
                                    />
                                    <Line 
                                        type="monotone" 
                                        dataKey="count" 
                                        stroke="#d97706" 
                                        strokeWidth={3} 
                                        dot={{ r: 4, fill: '#d97706' }} 
                                        activeDot={{ r: 6 }} 
                                    />
                                </LineChart>
                            </ResponsiveContainer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default AdminDashboard;
