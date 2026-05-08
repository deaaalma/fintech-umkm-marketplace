<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Digitalisasi UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Vadodara:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
</head>
<body class="bg-neutral-cream font-sans antialiased overflow-x-hidden">

    <!-- Navbar (Simple) -->
    <nav class="flex items-center justify-between px-6 py-4 md:px-12 fixed w-full top-0 z-50 bg-neutral-cream/90 backdrop-blur-sm transition-all duration-300 shadow-sm">
        <div class="text-2xl font-serif font-bold text-primary">UMKM Digital</div>
        <div class="hidden md:flex space-x-8 text-primary font-medium">
            <a href="#home" class="hover:text-primary-light transition">Home</a>
            <a href="#services" class="hover:text-primary-light transition">Services</a>
            <a href="#about" class="hover:text-primary-light transition">About Us</a>
            <a href="#contact" class="hover:text-primary-light transition">Contact Us</a>
        </div>
        <div class="flex space-x-4">
             <a href="#" class="w-10 h-10 rounded-full border border-primary flex items-center justify-center text-primary hover:bg-primary hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
             </a>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <header class="relative pt-32 pb-20 px-6 md:px-12 lg:px-24 overflow-hidden min-h-screen flex items-center bg-neutral-cream" id="home">
        <!-- Top Right Background Decoration (Pale Yellow/Cream Organic Shape) -->
        <div class="absolute top-0 right-0 w-[50vw] h-[80vh] bg-[#f8f1d8] rounded-[30%_70%_70%_30%/30%_30%_70%_70%] -z-10 blur-3xl opacity-50 translate-x-1/4 -translate-y-1/4"></div>

        <div class="grid lg:grid-cols-2 gap-16 items-center w-full max-w-7xl mx-auto">
            <!-- Left Side: Text -->
            <div class="relative z-10 text-left">
                <!-- Navigation Links (Desktop) - Recreating the header look from reference -->
                <div class="hidden lg:flex gap-8 mb-16 text-sm font-semibold tracking-wide text-gray-600">
                    <a href="#home" class="text-primary border-b-2 border-accent">Home</a>
                    <a href="#about" class="hover:text-primary transition">About Us</a>
                    <a href="#services" class="hover:text-primary transition">Services</a>
                    <a href="#contact" class="hover:text-primary transition">Contact Us</a>
                </div>

                <h1 class="text-5xl md:text-7xl lg:text-[5.5rem] font-serif font-bold text-primary mb-8 leading-[1.1] tracking-tight">
                    We Help you <br>
                    to grow your <br>
                    <span class="relative inline-block z-10">
                        Business
                        <!-- Yellow block underline effect -->
                        <span class="absolute bottom-2 left-0 w-full h-4 bg-accent/80 -z-10"></span>
                    </span>
                </h1>
                
                <p class="text-gray-600 mb-10 max-w-lg text-lg leading-relaxed">
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </p>
                
                <button class="bg-primary text-white py-4 px-12 rounded-lg shadow-lg hover:bg-primary-light hover:shadow-xl hover:-translate-y-1 transition duration-300 font-bold tracking-wide text-sm">
                    GET STARTED
                </button>
            </div>
            
            <!-- Right Side: Image with Organic Blob Mask -->
            <div class="relative flex justify-center lg:justify-end">
                <div class="relative w-full max-w-[500px] aspect-square">
                    
                    <!-- Dotted Line Decoration (SVG) -->
                    <svg class="absolute -top-12 -left-12 w-[120%] h-[120%] z-0 text-gray-800 opacity-80" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M44.7,-76.4C58.9,-69.2,71.8,-59.1,81.6,-46.7C91.4,-34.3,98.1,-19.6,95.8,-5.4C93.5,8.8,82.2,22.5,71.2,34.4C60.2,46.3,49.5,56.4,37.3,64.2C25.1,72,11.4,77.5,-2.2,81.3C-15.8,85.1,-29.3,87.2,-41.2,80.7C-53.1,74.2,-63.4,59.1,-71.4,43.7C-79.4,28.3,-85.1,12.6,-83.4,-2.2C-81.7,-17,-72.6,-30.9,-61.9,-41.8C-51.2,-52.7,-38.9,-60.6,-26.3,-68.8C-13.7,-77,-0.8,-85.5,13.2,-87.3C27.2,-89.1,55.1,-84.2,44.7,-76.4Z" transform="translate(100 100)" stroke="currentColor" stroke-width="0.5" stroke-dasharray="2 2" />
                    </svg>

                    <!-- The Yellow Blob Background -->
                    <!-- Using SVG for precise control or border-radius for CSS blobs -->
                    <div class="absolute inset-0 bg-accent rounded-[40%_60%_70%_30%/40%_50%_60%_50%] transform rotate-12 scale-110 z-0"></div>
                    
                    <!-- The MASKED Image Container -->
                    <!-- This div clips the image into a blob shape -->
                    <div class="absolute inset-0 z-10 overflow-hidden rounded-[30%_70%_70%_30%/30%_30%_70%_70%] border-4 border-transparent">
                        <img src="{{ asset('images/placeholder.png') }}" alt="Team Growth" class="w-full h-full object-cover transform scale-105 hover:scale-110 transition duration-700 ease-in-out">
                    </div>

                    <!-- Additional Bottom Blob Decoration -->
                     <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-accent rounded-full z-20 mix-blend-multiply opacity-80 animate-pulse"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section class="py-24 px-6 md:px-12 relative bg-white rounded-t-[5rem] -mt-10 shadow-inner z-20" id="services">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-4">What We Do</h2>
            <p class="text-xl text-gray-500">For Your <span class="relative">Business<span class="absolute bottom-1 left-0 w-full h-2 bg-accent/40 -z-10"></span></span></p>
        </div>

        <div class="grid md:grid-cols-3 gap-10 max-w-7xl mx-auto">
            <!-- Service 1 -->
            <div class="group bg-white p-10 rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-red-100"></div>
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-8 text-red-500 relative z-10 group-hover:scale-110 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9M2.05 15.65h0m19.9 0h0"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Website Toko Sendiri</h3>
                <p class="text-gray-500 leading-relaxed">
                    Buat website toko online Anda sendiri dengan mudah dan cepat. Tampilkan produk terbaik Anda ke seluruh dunia.
                </p>
            </div>
            
            <!-- Service 2 -->
            <div class="group bg-white p-10 rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300 border border-gray-100 relative overflow-hidden">
                 <div class="absolute top-0 right-0 w-24 h-24 bg-accent/20 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-accent/30"></div>
                 <div class="w-16 h-16 bg-accent/20 rounded-2xl flex items-center justify-center mb-8 text-yellow-700 relative z-10 group-hover:scale-110 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 01 18 0z"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Sistem Pembayaran</h3>
                <p class="text-gray-500 leading-relaxed">
                    Terima pembayaran dari berbagai metode dengan aman. QRIS, Transfer Bank, dan E-Wallet terintegrasi.
                </p>
            </div>

            <!-- Service 3 -->
             <div class="group bg-white p-10 rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition duration-300 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-blue-100"></div>
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-8 text-blue-500 relative z-10 group-hover:scale-110 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Manajemen Produk</h3>
                <p class="text-gray-500 leading-relaxed">
                    Kelola stok, varian harga, dan katalog produk Anda dalam satu dashboard yang mudah digunakan.
                </p>
            </div>
        </div>
    </section>

    <!-- About Us -->
    <section class="py-24 px-6 md:px-12 flex flex-col md:flex-row items-center gap-16 bg-neutral-cream/20" id="about">
        <div class="w-full md:w-1/2 relative md:pl-12">
             <!-- Circular Background -->
             <div class="absolute top-1/2 left-0 w-96 h-96 bg-accent rounded-full opacity-20 -z-10 transform -translate-y-1/2 -translate-x-10"></div>
             
             <!-- Image with Blob Mask -->
             <div class="relative z-10 transform rotate-2 hover:rotate-0 transition duration-500">
                <div class="rounded-[2rem] rounded-tr-[5rem] rounded-bl-[5rem] overflow-hidden border-8 border-white shadow-2xl">
                    <img src="{{ asset('images/placeholder.png') }}" class="w-full object-cover h-[500px]">
                </div>
             </div>
        </div>
        <div class="w-full md:w-1/2 md:pr-12">
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-6">About Us <br> <span class="text-gray-500 text-3xl font-light italic">Digitalizing Local Heroes</span></h2>
            <div class="w-20 h-1 bg-accent mb-8"></div>
            <p class="text-gray-600 mb-6 leading-loose text-lg">
                Kami berdedikasi untuk memberdayakan bisnis lokal (UMKM) melalui teknologi yang mudah diakses dan terjangkau. Misi kami adalah jembatan antara semangat wirausaha tradisional dengan peluang tak terbatas di dunia digital.
            </p>
            <p class="text-gray-600 mb-8 leading-loose text-lg">
                Sejak 2024, kami telah membantu ratusan UMKM beralih ke platform digital, meningkatkan omzet, dan memperluas jangkauan pasar mereka hingga ke seluruh pelosok negeri.
            </p>
            <button class="bg-primary hover:bg-primary-light text-white py-4 px-10 rounded-full shadow-lg transition duration-300 font-medium tracking-wide">
                FIND OUT MORE
            </button>
        </div>
    </section>
    
    <!-- How It Works / Steps -->
    <section class="py-24 bg-white relative overflow-hidden">
        <!-- Decor Dots -->
        <div class="absolute top-20 right-20 grid grid-cols-3 gap-2 opacity-20">
            <div class="w-3 h-3 bg-primary rounded-full"></div>
            <div class="w-3 h-3 bg-primary rounded-full"></div>
            <div class="w-3 h-3 bg-primary rounded-full"></div>
            <div class="w-3 h-3 bg-primary rounded-full"></div>
            <div class="w-3 h-3 bg-primary rounded-full"></div>
            <div class="w-3 h-3 bg-primary rounded-full"></div>
        </div>
        
         <div class="text-center mb-20 relative z-10">
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-primary mb-4">How it Works</h2>
            <p class="text-xl text-gray-500">Bergabung dalam <span class="text-accent font-bold px-2 py-1 bg-accent/20 rounded">3 Langkah Mudah</span></p>
        </div>
        
        <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-12 px-6">
            <!-- Step 1 -->
            <div class="relative text-center group">
                <div class="w-24 h-24 mx-auto bg-white rounded-full shadow-xl flex items-center justify-center text-3xl font-bold text-secondary-muted mb-8 border-4 border-neutral-cream group-hover:border-accent transition duration-300 z-10 relative">1</div>
                <h3 class="text-2xl font-bold mb-3 text-primary">Register</h3>
                <p class="text-gray-600">Daftarkan usaha Anda dengan data diri dan informasi bisnis yang valid.</p>
            </div>
             <!-- Step 2 -->
             <div class="relative text-center group">
                 <!-- Arrow connector -->
                 <div class="hidden md:block absolute top-12 -left-1/2 w-full border-t-2 border-dashed border-gray-300 -z-10"></div>
                
                <div class="w-24 h-24 mx-auto bg-white rounded-full shadow-xl flex items-center justify-center text-3xl font-bold text-secondary-muted mb-8 border-4 border-neutral-cream group-hover:border-accent transition duration-300 z-10 relative">2</div>
                <h3 class="text-2xl font-bold mb-3 text-primary">Choose Service</h3>
                <p class="text-gray-600">Pilih layanan yang sesuai dengan kebutuhan: Website, POS, atau Manajemen.</p>
            </div>
             <!-- Step 3 -->
             <div class="relative text-center group">
                 <div class="hidden md:block absolute top-12 -left-1/2 w-full border-t-2 border-dashed border-gray-300 -z-10"></div>
                 
                <div class="w-24 h-24 mx-auto bg-white rounded-full shadow-xl flex items-center justify-center text-3xl font-bold text-secondary-muted mb-8 border-4 border-neutral-cream group-hover:border-accent transition duration-300 z-10 relative">3</div>
                <h3 class="text-2xl font-bold mb-3 text-primary">Grow Business</h3>
                <p class="text-gray-600">Nikmati kemudahan mengelola bisnis dan pantau pertumbuhan omzet Anda.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#052e06] text-white py-20 px-6 relative overflow-hidden rounded-t-[3rem]">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-16 relative z-10">
            <div>
                <h2 class="text-4xl font-serif font-bold mb-6">UMKM Digital</h2>
                <div class="w-16 h-1 bg-accent mb-8"></div>
                <p class="text-gray-300 mb-8 max-w-sm leading-relaxed text-lg">
                    Platform digitalisasi UMKM terdepan di Indonesia. Tumbuh bersama, maju bersama.
                </p>
                <div class="flex gap-4 mb-8">
                    <a href="#" class="w-10 h-10 border border-gray-500 rounded-full flex items-center justify-center hover:bg-white hover:text-primary transition">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                     <a href="#" class="w-10 h-10 border border-gray-500 rounded-full flex items-center justify-center hover:bg-white hover:text-primary transition">
                         <span class="sr-only">Instagram</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
                <button class="bg-white text-primary px-10 py-4 rounded-full font-bold hover:bg-accent hover:text-white transition shadow-lg">
                    Contact Us
                </button>
            </div>
            <div class="relative">
                <div class="bg-gray-800 p-3 rounded-2xl max-w-sm ml-auto border border-gray-700 shadow-2xl">
                    <!-- Map Placeholder -->
                    <div class="bg-gray-700 w-full h-56 rounded-xl flex items-center justify-center text-gray-400 text-sm">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 7m0 13V7"></path></svg>
                            <span>Jakarta, Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Decor -->
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-accent rounded-full blur-[100px] opacity-20"></div>
    </footer>

    <style>
        .animate-bounce-slow {
            animation: bounce 3s infinite;
        }
    </style>
</body>
</html>