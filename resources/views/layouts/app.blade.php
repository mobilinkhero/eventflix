<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EventsWally — Find Wedding Vendors in Pakistan')</title>
    <meta name="description" content="@yield('meta_desc', 'Find and book the best wedding vendors across Pakistan.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Nunito+Sans:opsz,wght@6..12,300;6..12,400;6..12,500;6..12,600;6..12,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{
            --rose:#d4a5a5;--rose-deep:#c48b8b;--rose-light:#f0dede;--rose-pale:#faf4f4;
            --gold:#c9a961;--gold-dark:#b5944b;--gold-light:#e8d9b0;
            --sage:#8faa8f;--sage-light:#e8f0e8;
            --cream:#fdfbf7;--ivory:#f8f5f0;--linen:#f3efe8;
            --wh:#ffffff;
            --t1:#3d2f2f;--t2:#6b5c5c;--t3:#a09090;--t4:#c4b8b8;
            --brd:#e8e0dc;--brd2:#f0ebe7;
        }
        html{scroll-behavior:smooth}
        body{font-family:'Nunito Sans',sans-serif;background:var(--cream);color:var(--t1);-webkit-font-smoothing:antialiased;overflow-x:hidden}
        ::selection{background:var(--rose);color:#fff}
        a{color:inherit;text-decoration:none}
        img{max-width:100%;display:block}
        .serif{font-family:'Cormorant Garamond',Georgia,serif}

        /* ══════ NAV ══════ */
        .nav{position:sticky;top:0;z-index:99;height:62px;display:flex;align-items:center;padding:0 clamp(1.25rem,4vw,3rem);background:rgba(253,251,247,.92);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid var(--brd2)}
        .nav-in{max-width:1120px;margin:0 auto;width:100%;display:flex;align-items:center;justify-content:space-between}
        .logo{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:600;color:var(--t1);letter-spacing:-.5px}
        .logo i{font-style:normal;color:var(--rose-deep)}
        .nav-links{display:flex;gap:2rem;list-style:none}
        .nav-links a{font-size:.82rem;font-weight:600;color:var(--t2);transition:color .2s;letter-spacing:.3px}
        .nav-links a:hover,.nav-links a.on{color:var(--rose-deep)}
        .nav-cta{font-size:.78rem;font-weight:700;background:var(--t1);color:var(--cream);padding:.5rem 1.15rem;border-radius:50px;letter-spacing:.3px;transition:all .2s}
        .nav-cta:hover{background:var(--rose-deep);color:#fff}

        /* ══════ WRAP ══════ */
        .wrap{max-width:1120px;margin:0 auto;padding:0 clamp(1.25rem,4vw,2rem)}
        .wrap-sm{max-width:760px;margin:0 auto;padding:0 clamp(1.25rem,4vw,2rem)}

        /* ══════ BTN ══════ */
        .btn{display:inline-flex;align-items:center;gap:.4rem;font-size:.82rem;font-weight:700;padding:.6rem 1.3rem;border-radius:50px;border:none;cursor:pointer;transition:all .2s;font-family:inherit;letter-spacing:.2px}
        .btn-p{background:var(--t1);color:var(--cream)}.btn-p:hover{background:var(--rose-deep);color:#fff}
        .btn-r{background:var(--rose);color:#fff}.btn-r:hover{background:var(--rose-deep)}
        .btn-o{background:transparent;color:var(--t2);border:1.5px solid var(--brd)}.btn-o:hover{border-color:var(--rose);color:var(--rose-deep)}
        .btn-w{background:#fff;color:var(--t1)}.btn-w:hover{background:var(--rose-light);color:var(--rose-deep)}
        .btn-l{padding:.75rem 1.75rem;font-size:.88rem}

        /* ══════ ORNAMENT ══════ */
        .orn{display:flex;align-items:center;justify-content:center;gap:.75rem;color:var(--t4);font-size:.7rem;letter-spacing:3px;text-transform:uppercase;margin-bottom:.5rem}
        .orn::before,.orn::after{content:'';width:30px;height:1px;background:var(--rose-light)}
        .orn-lg::before,.orn-lg::after{width:50px}

        /* ══════ PAGE HEADER ══════ */
        .ph{padding:2.5rem 0 2rem;background:var(--wh);border-bottom:1px solid var(--brd2)}
        .ph .crumb{display:flex;align-items:center;gap:.4rem;font-size:.76rem;color:var(--t3);margin-bottom:.65rem}
        .ph .crumb a{color:var(--t2)}.ph .crumb a:hover{color:var(--rose-deep)}
        .ph h1{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:500;margin-bottom:.35rem}
        .ph p{font-size:.9rem;color:var(--t2);max-width:460px;line-height:1.55}

        /* ══════ SECTION ══════ */
        .sec{padding:3.5rem 0}
        .sec-h{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:1.75rem;gap:1rem;flex-wrap:wrap}
        .sec-h h2{font-family:'Cormorant Garamond',serif;font-size:1.65rem;font-weight:500}
        .sec-h p{font-size:.85rem;color:var(--t2);margin-top:.15rem}

        /* ══════ CARDS ══════ */
        .card{background:var(--wh);border:1px solid var(--brd2);border-radius:12px;transition:box-shadow .3s,transform .3s;overflow:hidden}
        .card:hover{box-shadow:0 8px 32px rgba(61,47,47,.06);transform:translateY(-2px)}

        /* ══════ VENDOR CARD ══════ */
        .vc{display:block}
        .vc-img{height:190px;position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden}
        .vc-img .mi{font-size:36px;color:rgba(255,255,255,.8)}
        .vc-badge{position:absolute;top:10px;left:10px;font-size:.62rem;font-weight:700;letter-spacing:.7px;text-transform:uppercase;padding:.25rem .65rem;border-radius:50px;background:var(--rose);color:#fff}
        .vc-b{padding:1.1rem 1.2rem 1.3rem}
        .vc-cat{font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--rose-deep);margin-bottom:.3rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .vc-n{font-family:'Cormorant Garamond',serif;font-size:1.15rem;font-weight:600;margin-bottom:.25rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .vc-loc{font-size:.78rem;color:var(--t3);display:flex;align-items:center;gap:.2rem;margin-bottom:.85rem}
        .vc-loc .mi{font-size:14px}
        .vc-f{display:flex;align-items:center;justify-content:space-between;padding-top:.75rem;border-top:1px solid var(--brd2)}
        .vc-r{display:flex;align-items:center;gap:.25rem;font-size:.82rem;font-weight:600}
        .vc-r .mi{font-size:14px;color:var(--gold)}
        .vc-r span{font-weight:400;color:var(--t3);font-size:.74rem}
        .vc-p{font-size:.76rem;color:var(--t2)}

        /* ══════ CATEGORY CARD ══════ */
        .cc{display:flex;align-items:center;gap:.85rem;padding:1rem 1.15rem;background:var(--wh);border:1px solid var(--brd2);border-radius:10px;transition:all .2s}
        .cc:hover{border-color:var(--rose);box-shadow:0 4px 16px rgba(212,165,165,.1)}
        .cc-ic{width:42px;height:42px;border-radius:50%;background:var(--rose-pale);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .cc-ic .mi{font-size:20px;color:var(--rose-deep)}
        .cc-t{min-width:0}
        .cc-t h3{font-size:.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .cc-t span{font-size:.74rem;color:var(--t3)}

        /* ══════ CITY CARD ══════ */
        .cy{text-align:center;padding:1.75rem 1rem;background:var(--wh);border:1px solid var(--brd2);border-radius:12px;transition:all .25s}
        .cy:hover{border-color:var(--rose);transform:translateY(-2px);box-shadow:0 4px 16px rgba(212,165,165,.08)}
        .cy h3{font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-weight:500;margin-bottom:.15rem}
        .cy p{font-size:.72rem;color:var(--t3)}

        /* ══════ GRIDS ══════ */
        .g2{display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem}
        .g3{display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem}
        .g4{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem}
        .g5{display:grid;grid-template-columns:repeat(5,1fr);gap:.85rem}

        /* ══════ SIDEBAR LAYOUT ══════ */
        .pg-flex{display:flex;gap:2rem}
        .sidebar{width:240px;flex-shrink:0}
        .sb-card{background:var(--wh);border:1px solid var(--brd2);border-radius:12px;padding:1.25rem;margin-bottom:.85rem}
        .sb-card h3{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--t3);margin-bottom:.85rem}
        .sb-list{list-style:none}
        .sb-list li{margin-bottom:.3rem}
        .sb-list a{display:flex;align-items:center;justify-content:space-between;font-size:.82rem;color:var(--t2);padding:.3rem 0;transition:color .15s}
        .sb-list a:hover{color:var(--rose-deep)}
        .sb-list a.on{color:var(--rose-deep);font-weight:600}
        .sb-list .cnt{font-size:.7rem;color:var(--t3);background:var(--ivory);padding:.1rem .45rem;border-radius:8px}
        .main{flex:1;min-width:0}

        /* ══════ FORM ══════ */
        .fg{margin-bottom:1.1rem}
        .fg label{display:block;font-size:.78rem;font-weight:600;margin-bottom:.35rem;color:var(--t2)}
        .fi{width:100%;padding:.65rem .9rem;border:1px solid var(--brd);border-radius:8px;font-size:.86rem;font-family:inherit;background:var(--wh);transition:border-color .2s}
        .fi:focus{outline:none;border-color:var(--rose)}
        textarea.fi{resize:vertical;min-height:110px}

        /* ══════ DETAIL PAGE ══════ */
        .det-hero{background:var(--wh);border-bottom:1px solid var(--brd2);padding:2rem 0}
        .det-top{display:flex;gap:1.5rem;align-items:flex-start}
        .det-av{width:96px;height:96px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:3px solid var(--rose-light)}
        .det-av .mi{font-size:36px;color:rgba(255,255,255,.85)}
        .det-inf h1{font-family:'Cormorant Garamond',serif;font-size:1.75rem;font-weight:500;margin-bottom:.3rem}
        .det-inf .loc{font-size:.85rem;color:var(--t2);display:flex;align-items:center;gap:.25rem;margin-bottom:.65rem}
        .det-inf .loc .mi{font-size:16px;color:var(--t3)}
        .det-tags{display:flex;gap:.5rem;flex-wrap:wrap}
        .det-tag{font-size:.72rem;font-weight:600;padding:.3rem .7rem;border-radius:50px;background:var(--rose-pale);border:1px solid var(--rose-light);display:flex;align-items:center;gap:.25rem;color:var(--t2)}
        .det-tag .mi{font-size:14px}
        .det-body{display:flex;gap:2.5rem}
        .det-main{flex:1;min-width:0}
        .det-aside{width:320px;flex-shrink:0}
        .aside-c{background:var(--wh);border:1px solid var(--brd2);border-radius:12px;padding:1.5rem;margin-bottom:1rem;position:sticky;top:76px}
        .aside-c h3{font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--t3);margin-bottom:1rem}
        .info-r{display:flex;gap:.65rem;padding:.55rem 0;border-bottom:1px solid var(--brd2)}
        .info-r:last-child{border-bottom:none}
        .info-r .mi{font-size:17px;color:var(--rose-deep);margin-top:2px}
        .info-r .lb{font-size:.68rem;color:var(--t3)}
        .info-r .vl{font-size:.84rem;font-weight:500}

        /* ══════ REVIEW ══════ */
        .rv{background:var(--wh);border:1px solid var(--brd2);border-radius:10px;padding:1.25rem;margin-bottom:.75rem}
        .rv-h{display:flex;align-items:center;gap:.65rem;margin-bottom:.6rem}
        .rv-av{width:36px;height:36px;border-radius:50%;background:var(--rose-pale);border:1px solid var(--rose-light);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.76rem;color:var(--rose-deep)}
        .rv-m h4{font-size:.84rem;font-weight:600}
        .rv-m .d{font-size:.7rem;color:var(--t3)}
        .stars{display:flex;gap:1px;margin-left:auto}
        .stars .mi{font-size:14px;color:var(--gold)}
        .stars .off{color:var(--brd)}
        .rv p{font-size:.86rem;color:var(--t2);line-height:1.55}

        /* ══════ SERVICES TABLE ══════ */
        .svt{width:100%;border-collapse:collapse}
        .svt th{text-align:left;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;padding:.65rem .85rem;background:var(--ivory);color:var(--t3);border-bottom:1px solid var(--brd)}
        .svt td{padding:.85rem;border-bottom:1px solid var(--brd2);font-size:.86rem}
        .svt tr:last-child td{border-bottom:none}

        /* ══════ PAGINATION ══════ */
        .pag{display:flex;align-items:center;justify-content:center;gap:.3rem;margin-top:2rem}
        .pag a,.pag span{display:flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;font-size:.8rem;font-weight:500;border:1px solid var(--brd);color:var(--t2);transition:all .15s}
        .pag a:hover{border-color:var(--rose);color:var(--rose-deep)}
        .pag .cur{background:var(--t1);color:var(--cream);border-color:var(--t1)}
        .pag .dis{opacity:.35;pointer-events:none}

        /* ══════ EMPTY ══════ */
        .empty{text-align:center;padding:3rem 1.5rem}
        .empty .mi{font-size:40px;color:var(--brd);margin-bottom:.75rem}
        .empty h3{font-size:1rem;font-weight:600;margin-bottom:.3rem}
        .empty p{font-size:.84rem;color:var(--t3)}

        /* ══════ FOOTER ══════ */
        .ft{border-top:1px solid var(--brd2);background:var(--wh);padding:3rem 0 1.5rem}
        .ft-g{display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr;gap:2.5rem;margin-bottom:2.5rem}
        .ft-brand p{font-size:.82rem;color:var(--t2);line-height:1.6;margin-top:.75rem;max-width:240px}
        .ft-col h4{font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:600;color:var(--t1);margin-bottom:.85rem}
        .ft-col ul{list-style:none}
        .ft-col li{margin-bottom:.45rem}
        .ft-col a{font-size:.82rem;color:var(--t2);transition:color .15s}
        .ft-col a:hover{color:var(--rose-deep)}
        .ft-bot{display:flex;align-items:center;justify-content:space-between;padding-top:1.5rem;border-top:1px solid var(--brd2);font-size:.76rem;color:var(--t3)}

        /* ══════ FADE ══════ */
        .fi-a{opacity:0;transform:translateY(12px);transition:all .45s ease}
        .fi-a.vis{opacity:1;transform:none}

        /* ══════ RESPONSIVE ══════ */
        @media(max-width:1024px){.g4{grid-template-columns:repeat(3,1fr)}.g5{grid-template-columns:repeat(3,1fr)}.det-aside{width:280px}}
        @media(max-width:768px){
            .nav-links{display:none}.g2,.g3{grid-template-columns:1fr}.g4{grid-template-columns:repeat(2,1fr)}.g5{grid-template-columns:repeat(2,1fr)}
            .pg-flex{flex-direction:column}.sidebar{width:100%}.det-body{flex-direction:column}.det-aside{width:100%}.det-top{flex-direction:column;align-items:flex-start}
            .ft-g{grid-template-columns:1fr 1fr;gap:1.5rem}.ph h1{font-size:1.5rem}.sec-h{flex-direction:column;align-items:flex-start}
        }
        @media(max-width:480px){.g4,.g5{grid-template-columns:1fr}.ft-g{grid-template-columns:1fr}}
        @yield('css')
    </style>
</head>
<body>
    <nav class="nav">
        <div class="nav-in">
            <a href="/" class="logo">Events<i>Wally</i></a>
            <ul class="nav-links">
                <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'on' : '' }}">Categories</a></li>
                <li><a href="{{ route('vendors.index') }}" class="{{ request()->routeIs('vendors.*') ? 'on' : '' }}">Vendors</a></li>
                <li><a href="{{ route('cities.index') }}" class="{{ request()->routeIs('cities.*') ? 'on' : '' }}">Cities</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a></li>
            </ul>
            <a href="{{ route('vendors.index') }}" class="nav-cta">Find Vendors</a>
        </div>
    </nav>

    @yield('body')

    <footer class="ft">
        <div class="wrap">
            <div class="ft-g">
                <div class="ft-brand">
                    <a href="/" class="logo">Events<i>Wally</i></a>
                    <p>Helping couples find their dream wedding team across Pakistan since 2024.</p>
                </div>
                <div class="ft-col">
                    <h4>Explore</h4>
                    <ul>
                        <li><a href="{{ route('categories.index') }}">Categories</a></li>
                        <li><a href="{{ route('vendors.index') }}">Vendors</a></li>
                        <li><a href="{{ route('cities.index') }}">Cities</a></li>
                    </ul>
                </div>
                <div class="ft-col">
                    <h4>For Vendors</h4>
                    <ul>
                        <li><a href="#">List Your Business</a></li>
                        <li><a href="#">Vendor Dashboard</a></li>
                        <li><a href="#">Plans & Pricing</a></li>
                    </ul>
                </div>
                <div class="ft-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms</a></li>
                    </ul>
                </div>
            </div>
            <div class="ft-bot">
                <span>&copy; {{ date('Y') }} EventsWally. All rights reserved.</span>
                <span>Made with ♡ in Pakistan</span>
            </div>
        </div>
    </footer>
    <script>
    const io=new IntersectionObserver(e=>{e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('vis');io.unobserve(x.target)}})},{threshold:.08});
    document.querySelectorAll('.fi-a').forEach(x=>io.observe(x));
    </script>
    @yield('js')
</body>
</html>