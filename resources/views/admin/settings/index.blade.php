@extends('layout.admin')

@section('title', 'Cài đặt hệ thống')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <h1 class="font-playfair text-3xl font-bold text-vintage-900">Cài đặt Hệ thống</h1>
        <p class="text-stone-500 text-sm mt-1">Cấu hình thông tin liên hệ và nhận diện thương hiệu</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left: Contact Channels -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-8">
                <div class="flex items-center gap-3 text-amber-700">
                    <i data-lucide="message-circle" class="w-6 h-6"></i>
                    <h2 class="font-playfair text-xl font-bold tracking-wide">Kênh liên lạc trực tuyến</h2>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Số điện thoại Zalo</label>
                        <div class="relative">
                            <i data-lucide="phone" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="text" name="zalo_phone" value="{{ old('zalo_phone', $settings['zalo_phone']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                                placeholder="09xx xxx xxx">
                        </div>
                        <p class="text-[10px] text-stone-400 italic px-1">Link tự động: zalo.me/[số_này]</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Hotline (Gọi trực tiếp)</label>
                        <div class="relative">
                            <i data-lucide="phone-call" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="text" name="hotline" value="{{ old('hotline', $settings['hotline']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                                placeholder="09xx xxx xxx">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Link Facebook Messenger (Tư vấn)</label>
                        <div class="relative">
                            <i data-lucide="facebook" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                                placeholder="https://m.me/yourpage">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Link Facebook Fanpage</label>
                        <div class="relative">
                            <i data-lucide="facebook" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="url" name="facebook_fanpage" value="{{ old('facebook_fanpage', $settings['facebook_fanpage']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                                placeholder="https://facebook.com/yourpage">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Link TikTok</label>
                        <div class="relative">
                            <i data-lucide="video" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                                placeholder="https://tiktok.com/@yourpage">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Link Instagram</label>
                        <div class="relative">
                            <i data-lucide="instagram" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                                placeholder="https://instagram.com/yourpage">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Shop Info -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-8">
                <div class="flex items-center gap-3 text-amber-700">
                    <i data-lucide="store" class="w-6 h-6"></i>
                    <h2 class="font-playfair text-xl font-bold tracking-wide">Thông tin Cửa hàng</h2>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tên cửa hàng</label>
                        <input type="text" name="shop_name" value="{{ old('shop_name', $settings['shop_name']->value ?? '') }}"
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Email liên hệ</label>
                        <div class="relative">
                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <input type="email" name="shop_email" value="{{ old('shop_email', $settings['shop_email']->value ?? '') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Địa chỉ thực tế</label>
                        <div class="relative">
                            <i data-lucide="map-pin" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-5 h-5"></i>
                            <textarea name="shop_address" rows="1"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium resize-none">{{ old('shop_address', $settings['shop_address']->value ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Action -->
        <div class="bg-vintage-900 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl shadow-stone-950">
            <div class="text-stone-400 text-sm italic">
                * Mọi thay đổi sẽ được áp dụng ngay lập tức lên giao diện website khách hàng.
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <button type="reset" class="flex-grow md:flex-none px-8 py-4 text-stone-500 font-bold hover:text-stone-300 transition-all uppercase tracking-widest text-[10px]">Hoàn tác</button>
                <button type="submit" class="flex-grow md:flex-none bg-amber-700 hover:bg-amber-600 text-white px-12 py-4 rounded-xl font-bold shadow-lg shadow-amber-900/20 transition-all flex items-center justify-center gap-3">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Lưu cấu hình
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
