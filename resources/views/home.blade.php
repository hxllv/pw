@extends('layouts.app')

@section('content')
    <section id="landing">
        <div class="container">
            <h1 class="pirata title">
                Pragwald Woodworks
            </h1>
            <h1 class="pirata subtitle">
                <span>Unikatni</span> leseni izdelki
            </h1>
        </div>
        <div class="spacer wave-start"></div>
    </section>
    <section id="onas-section" class="white">
        <div id="onas" class="invis-for-nav"></div>
        <div class="container">
            <h1 class="title pirata section-header">O nas</h1>
            <div class="dual-col">
                <div>
                    <h1 class="bigger-subtitle pirata">Lorem</h1>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Cupiditate officiis laboriosam aspernatur iusto, ratione
                        suscipit consectetur ea. Blanditiis ipsa dolorum et cum hic
                        ab id corporis qui, vel quos veritatis repellat nobis a
                        voluptatem provident rem quibusdam omnis ut ad eveniet!
                        Excepturi, architecto. Voluptatem, voluptate provident
                        reiciendis asperiores vero nobis!
                    </p>
                    <h1 class="bigger-subtitle pirata">Ipsum</h1>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                        Cupiditate officiis laboriosam aspernatur iusto, ratione
                        suscipit consectetur ea. Blanditiis ipsa dolorum et cum hic
                        ab id corporis qui, vel quos veritatis repellat nobis a
                        voluptatem provident rem quibusdam omnis ut ad eveniet!
                        Excepturi, architecto. Voluptatem, voluptate provident
                        reiciendis asperiores vero nobis!
                    </p>
                </div>
                <div class="blob-container">
                    <img loading="lazy" class="blob-image" src="{{ asset('images/blobcomp.svg') }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <div class="spacer wave"></div>
    <section id="izdelki-section" class="black">
        <div id="izdelki" class="invis-for-nav"></div>
        <div class="container">
            <h1 class="title pirata section-header">Izdelki</h1>
            <div class="items-subsection">
                @if (!$items->where('available', '=', true)->count())
                    <h3 class="text-center">
                        Žal trenutno ni nobenih izdelkov!
                    </h3>
                @endif
                @foreach ($types as $type)
                    @if ($type->hasManyItems->where('available', '=', true)->count())
                        <div class="type">
                            <h1 class="subtitle divider pirata">{{ $type->name }}</h1>
                            <div class="items">
                                @foreach ($type->hasManyItems->where('available', '=', true) as $item)
                                    <div class="item" tabindex="0"
                                        onmouseenter="itemMouseEnter(this, {{ $imgs->where('item_id', '=', $item->id)->map->only(['image'])->values()->toJson() }})"
                                        onmouseleave="itemMouseLeave(this)"
                                        onfocus="itemMouseEnter(this, {{ $imgs->where('item_id', '=', $item->id)->map->only(['image'])->values()->toJson() }})"
                                        onfocusout="itemMouseLeave(this)">
                                        <div class="item-img" style="z-index: 1;">
                                            <picture class="cleary-prep">
                                                <source media="(min-width:2100px)"
                                                    srcset="/storage/{{ $item->main_image }}">
                                                <source media="(min-width:1200px)"
                                                    srcset="/storage/{{ str_replace('/', '/1000_', $item->main_image) }}">
                                                <img loading="lazy"
                                                    src="/storage/{{ str_replace('/', '/500_', $item->main_image) }}"
                                                    alt="{{ $item->title }}">
                                            </picture>
                                            <add-to-cart item-id="{{ $item->id }}" item-img="{{ $item->main_image }}"
                                                item-title="{{ $item->title }}" item-price="{{ $item->price }}">
                                            </add-to-cart>
                                        </div>
                                        <div class="details">
                                            <h1>
                                                {{ $item->title }} |
                                                {{ floor($item->price) == $item->price ? str_replace('.00', '.- ', (string) $item->price) : $item->price }}
                                                <span class="euro">
                                                    &euro;
                                                </span>
                                            </h1>
                                            <p>{{ $item->description }}</p>
                                            @foreach ($imgs->where('item_id', '=', $item->id) as $img)
                                                <picture>
                                                    <source media="(min-width:2100px)" srcset="">
                                                    <source media="(min-width:1200px)" srcset="">
                                                    <img src="" alt="{{ $item->title }} extra">
                                                </picture>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="items-subsection">
                <h1 class="subtitle divider pirata">Galerija že prodanih izdelkov</h1>
                <div>
                    <div class="items">
                        @foreach ($items as $item)
                            @if (!$item->available)
                                <div class="item" tabindex="0"
                                    onmouseenter="itemMouseEnter(this, {{ $imgs->where('item_id', '=', $item->id)->map->only(['image'])->values()->toJson() }})"
                                    onmouseleave="itemMouseLeave(this)"
                                    onfocus="itemMouseEnter(this, {{ $imgs->where('item_id', '=', $item->id)->map->only(['image'])->values()->toJson() }})"
                                    onfocusout="itemMouseLeave(this)">
                                    <div class="item-img" style="z-index: 1;">
                                        <picture class="cleary-prep">
                                            <source media="(min-width:2100px)" srcset="/storage/{{ $item->main_image }}">
                                            <source media="(min-width:1200px)"
                                                srcset="/storage/{{ str_replace('/', '/1000_', $item->main_image) }}">
                                            <img loading="lazy"
                                                src="/storage/{{ str_replace('/', '/500_', $item->main_image) }}"
                                                alt="{{ $item->title }}">
                                        </picture>
                                    </div>
                                    <div class="details">
                                        <h1>{{ $item->title }}</h1>
                                        <p>{{ $item->description }}</p>
                                        @foreach ($imgs->where('item_id', '=', $item->id) as $img)
                                            <picture>
                                                <source media="(min-width:2100px)" srcset="">
                                                <source media="(min-width:1200px)" srcset="">
                                                <img src="" alt="{{ $item->title }} extra">
                                            </picture>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="items-subsection" style="z-index: 2">
                <div class="dual-col">
                    <div class="blob-container" style="transform: rotateZ(-20deg);">
                        <img loading="lazy" class="blob-image" src="{{ asset('images/blobcomp.svg') }}" alt="">
                    </div>
                    <div>
                        <h1 class="bigger-subtitle pirata">Nega lesa</h1>
                        <p>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            Cupiditate officiis laboriosam aspernatur iusto, ratione
                            suscipit consectetur ea. Blanditiis ipsa dolorum et cum hic
                            ab id corporis qui, vel quos veritatis repellat nobis a
                            voluptatem provident rem quibusdam omnis ut ad eveniet!
                            Excepturi, architecto. Voluptatem, voluptate provident
                            reiciendis asperiores vero nobis!
                        </p>
                    </div>
                </div>    
            </div>
        </div>
    </section>
    <div class="spacer wave-prep wave flip"></div>
    <section id="kontakt-section" class="white">
        <div id="kontakt" class="invis-for-nav"></div>
        <div class="container">
            <h1 class="title pirata section-header">Kontakt</h1>
            <p class="p text-center">
                Vas zanima kakšen izdelek zgoraj, ali pa imate svoje posebne želje za svoj unikaten izdelek?
                Pišite nam s kontaktnem obrazcem spodaj ali pa na <a class="email"
                    href="mailto:zan.vozlic@gmail.com">zan.vozlic@gmail.com</a>.
            </p>
            <div>
                <send-message></send-message>
            </div>
        </div>
    </section>
@endsection
