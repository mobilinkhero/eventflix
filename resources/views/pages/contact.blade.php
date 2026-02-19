@extends('layouts.app')
@section('title', 'Contact — EventsWally')

@section('body')
    <div class="ph">
        <div class="wrap">
            <div class="crumb"><a href="{{ route('home') }}">Home</a> <span>›</span> Contact</div>
            <h1>Let's Talk</h1>
            <p>Whether you're a couple or a vendor, we're here to help</p>
        </div>
    </div>
    <section class="sec">
        <div class="wrap">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;max-width:860px">
                <div>
                    <h2 class="serif" style="font-size:1.25rem;font-weight:500;margin-bottom:1.25rem">Send a message</h2>
                    <form onsubmit="event.preventDefault();document.getElementById('ok').style.display='flex'">
                        <div class="fg"><label>Name</label><input type="text" class="fi" placeholder="Your name" required>
                        </div>
                        <div class="fg"><label>Email</label><input type="email" class="fi" placeholder="your@email.com"
                                required></div>
                        <div class="fg">
                            <label>I am a...</label>
                            <select class="fi">
                                <option value="">Select</option>
                                <option>Couple / Individual</option>
                                <option>Vendor</option>
                                <option>Event Planner</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="fg"><label>Message</label><textarea class="fi" placeholder="Tell us how we can help..."
                                required></textarea></div>
                        <button type="submit" class="btn btn-p btn-l" style="width:100%;justify-content:center">Send
                            Message</button>
                    </form>
                    <div id="ok"
                        style="display:none;align-items:center;gap:.4rem;margin-top:.85rem;padding:.75rem;background:var(--sage-light);border:1px solid #c3dcc3;border-radius:7px;color:#2d7a2d;font-size:.82rem">
                        <span class="material-icons-round" style="font-size:18px">check_circle</span> Message sent! We'll
                        get back to you shortly.
                    </div>
                </div>
                <div>
                    <h2 class="serif" style="font-size:1.25rem;font-weight:500;margin-bottom:1.25rem">Reach us directly</h2>
                    <div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
                        @foreach([
                                ['email', 'Email', 'hello@eventswally.com'],
                                ['phone', 'Phone', '+92 300 1234567'],
                                ['chat', 'WhatsApp', '+92 300 1234567'],
                                ['location_on', 'Office', 'Lahore, Pakistan'],
                            ] as [$ic, $lb, $vl])


                                                    <div style="display:flex;gap:.75rem;padding:.75rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--brd2);' : '' }}">
                                <div style="width:36px;height:36px;border-radius:50%;background:var(--rose-pale);border:1px solid var(--rose-light);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                    <span class="material-icons-round" style="font-size:16px;color:var(--rose-deep)">{{ $ic }}</span>
                                </div>

                                <div><div style="font-size:.7rem;color:var(--t3)">{{ $lb }}</div><div style="font-size:.86rem;font-weight:500">{{ $vl }}
                            </div></div>
                            </div>
                        @endforeach
                    </div>

                    <h3 style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--t3);margin:2rem 0 .85rem">Common questions</h3>
                    @foreach([
                            ['How do I list my business?', 'Contact us via WhatsApp or this form — we\'ll set you up within 24 hours.'],
                            ['Is browsing free?', 'Yes! Searching vendors and reading reviews is completely free for everyone.'],
                            ['How are vendors verified?', 'We check business credentials, review portfolios, and verify references before approval.'],
                        ] as [$q, $a])
                        <div style="padding:.75rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--brd2);' : '' }}">
                            <h4 style="font-size:.84rem;font-weight:600;margin-bottom:.2rem">{{ $q }}</h4>
                            <p style="font-size:.8rem;color:var(--t2);line-height:1.5">{{ $a }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
