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
            <h1 class="title pirata section-header">O meni</h1>
            <div class="dual-col">
                <div>
                    <p class="pb-15">
                        Živijo, moje ime je Žan in uživam v ustvarjanju ter izdelovanju lesenih izdelkov. Odraščal sem v
                        Preboldu, v majhnem kraju v Savinjski dolini, ki je obdan s čudovitim gozdom. Ta kraj in njegova
                        okolica sta mi vzbudila strast do narave in njenih virov. Čeprav sem po izobrazbi strojni tehnik, me
                        kovina nikoli ni navduševala tako kot les, saj je vsako drevo in vsak list na njem nekaj unikatnega
                        tako kot snežinka ali prstni odtis.
                    </p>
                    <p class="pb-15">
                        Že kot otrok sem se potikal po mizarski delavnici starega očeta Rudija in čutil, da bo les velik del
                        mojega življenja. Všeč mi je vonj lesa, tekstura, sijaj in občutek žagovine v rokah. Najbolj pa me
                        fascinira dejstvo, kaj vse se da iz njega narediti, če ga v roke dobi pravi mojster. Zato sem si v
                        začetku leta 2021 s pomočjo družine in prijateljev začel ustvarjati svoj prostor za ustvarjanje, ter
                        svojo znamko poimenoval Pragwald Woodworks.
                    </p>
                    <p class="pb-15">
                        Vedno sem verjel v prave, ročno izdelane lesene izdelke, brez CNC-ja ter natančnosti na računalniški
                        ravni. Moji izdelki nikoli ne bodo imeli te računalniške stopnje popolnosti, niti si je ne bi želel.
                        Če ne morete povedati, da je nekaj ročno izdelano, zakaj bi potem kupili ročno izdelano kreacijo?
                        Trudim se, da iz običajnega kosa lesa ustvarim nekaj novega, nekaj lepega ter da iz njega izvlečem
                        maksimalno, kar mi ponuja. Izdelki, ki pridejo iz moje delavnice, so večni in vedno najvišje
                        kakovosti, vendar z znaki, da ga je naredil človek in ne stroj.
                    </p>
                </div>
                <div class="blob-container">
                    <img loading="lazy" class="blob-image blob-image-end" src="{{ asset('images/blobcomp.svg') }}"
                        alt="">
                </div>
            </div>
        </div>
    </section>
    <div class="spacer wave"></div>
    <section id="izdelki-section" class="black">
        <div id="izdelki" class="invis-for-nav"></div>
        <div class="container">
            <h1 class="title pirata section-header">Izdelki</h1>
            <avail-items types="{{ $types->toJson() }}" items="{{ $items->toJson() }}"></avail-items>
            <div class="items-subsection" style="z-index: 2">
                <div class="triple-col">
                    <div class="blob-container">
                        <img loading="lazy" class="blob-image blob-image-abs-sr" src="{{ asset('images/blobcomp1.svg') }}"
                            alt="">
                    </div>
                    <div>
                        <h1 class="bigger-subtitle pirata">Nega lesa</h1>
                        <p class="pb-15">
                            S pravilno oskrbo kuhinjskih in servisnih desk ter ostalih lesnih izdelkov boste preprečili
                            pokanje ter zvijanje lesa, s tem pa bodo zdržali več let, če ne celo generacij. V lesu namreč
                            delujejo nam nevidne sile, ki pridejo na dan ob nepravilni negi ter hrambi izdelkov. Tukaj
                            izveste, kako za njih pravilno poskrbeti.
                        </p>
                        <h1 class="subtitle pirata">Kako očistiti kuhinjsko/servisno desko?</h1>
                        <ul class="pb-15">
                            <li class="pb-05">
                                Desko vedno operite na roke; če je v stiku z vlažno, lepljivo ali pekočo hrano jo sperite,
                                če pa na njej režete samo kruh, jo preprosto obrišite.
                            </li>
                            <li class="pb-05">
                                Za pranje deske uporabite blaga čistilna sredstva, najbolj optimalna pa je seveda samo voda.
                            </li>
                            <li class="pb-05">
                                Čisto desko temeljito obrišite in postavite na stran v pokončni položaj, saj ji s tem
                                omogočite, da se enakomerno posuši, in tako preprečite zvijanje in morebitno pokanje deske.
                            </li>
                            <li class="pb-05">
                                Deske nikakor ne namakajte ali pa potapljajte v vodo, saj lahko pride do deformacij.
                            </li>
                            <li class="pb-05">
                                Lesenih izdelkov tudi ne smete dati v pomivalni stroj. Prekomerna toplota in močne
                                kemikalije detergenta za posodo bodo povzročile, da se les izsuši, ukrivi in/ali poči.
                            </li>
                            <li>
                                Na deski ne uporabljajte ostrih, koncentriranih čistil.
                            </li>
                        </ul>
                        <h1 class="subtitle pirata">Zakaj moramo naoljiti kuhinjske/servisne deske?</h1>
                        <p class="pb-15">
                            Desko je potrebno ustrezno zaščititi z oljem, da ostane sijoča, nekoliko vodoodporna in ne vpija
                            vlage in vonjav iz hrane.
                            Z oljem desko tudi zaščitimo pred nastajanjem bakterij, ki se lahko razvijejo v razpokah, ter
                            pred zvijanjem in pokanjem.
                        </p>
                        <p class="pb-15">
                            Najboljše olje za to je mineralno olje, katerega tudi sam uporabljam pri svojih izdelkih.
                        </p>
                        <p class="pb-15">
                            Zakaj bi namesto tistega, ki ga že imate v kuhinji, morali uporabljati posebno olje? Deska ni
                            ponev in za oljenje desk ne smete uporabljati jedilnega olja. Razlog? Žarkost. Tudi zelo
                            stabilno olje, kot je kokosovo olje, bo sčasoma postalo žarko. Največja težava pri tem je vonj
                            ter nastajanje bakterij. Držite se mineralnega olja in/ali mešanice čebeljega voska in
                            mineralnega olja. Čebelji vosek bo naredil leseno desko bolj sijočo in vodoodporno kot naravno
                            mineralno olje. Ker deske ni enostavno drgniti s kosom trdega voska, je bolje uporabiti mešanico
                            mineralnega olja in čebeljega voska, kar bo poskrbelo, da bo deska v dobrem stanju.
                        </p>
                        <h1 class="subtitle pirata">Kdaj je potrebno kuhinjsko/servisno desko naoljiti?</h1>
                        <p class="pb-15">
                            Ni čarobne formule za to, kako pogosto morate naoljiti svojo desko. Poglejte jo in vedeli boste,
                            kdaj je čas. Videti bo suha in brez leska. Za vse, ki ste v dvomih, vam lahko povem okvirno
                            formulo, vendar se ta seveda razlikuje od stanja posamezne deske. Desko torej naoljite vsaj
                            dvakrat na letni čas, se pravi osemkrat na leto. Če desko uporabljate velikokrat, je
                            priporočljivo vsaj enkrat na mesec (večkrat, ko jo umijete, večkrat jo je potrebno naoljiti).
                        </p>
                        <p class="pb-15">
                            Tudi podnebje je pomemben dejavnik. Pozimi na primer moram svoje deske pogosteje namazati z
                            oljem, saj je zrak suh in temperature v hiši nihajo.
                        </p>
                        <p class="pb-15">
                            Če se deska kjer koli močno razcepi, je čas, da kupite drugo. V te dele lahko pride hrana in
                            vlaga, kar povzroči nastanek bakterij.
                        </p>
                        <h1 class="subtitle pirata">Kako naoljiti kuhinjsko/servisno desko?</h1>
                        <p>Potrebovali boste:</p>
                        <ul>
                            <li class="pb-05">čisto in suho desko</li>
                            <li class="pb-05">mineralno olje in/ali vosek</li>
                            <li class="pb-05">čisto krpo (najbolje so čisti kosi starih majic ali volnenih
                                nogavic)</li>
                        </ul>

                        <ol style="padding-inline-start: 20px;">
                            <li class="pb-10">Na sredino deske nalijte nekaj mineralnega olja, premera
                                približno četrtine deske. To se morda zdi veliko, vendar boste videli, koliko tekočine lahko
                                deska absorbira.</li>
                            <li class="pb-10">
                                <p class="pb-05">S krpo z majhnimi krožnimi potezami v desko vtrite olje. To
                                    naredite po celotni površini, vključno z obema stranema in konci. Prepričajte se, da
                                    olje prodre v vse razpoke. Po potrebi olje še dodajte. Desko postavite na stran v
                                    pokončen položaj in pustite čez noč, da se olje vpije.</p>
                                <p>Če uporabljate vosek za deske, ponovno uporabite čisto krpo, ki ne pušča vlaken. Potopite
                                    jo v vosek in ga nato s krožnimi gibi vtrite v celotno površino. Nato uporabite drugo
                                    krpo za poliranje deske do sijaja.</p>
                            </li>
                            <li class="pb-10">Po želji lahko z že prepojeno krpo, katero ste uporabili za
                                desko, naoljite še ostale lesene kuhinjske predmete ali pa spolirate leseno pohištvo. Po
                                uporabi krpo zavrzite.</li>
                        </ol>
                        <h1 class="subtitle pirata">Še par trikov za čisto kuhinjsko/servisno desko</h1>
                        <ul>
                            <li class="pb-05">
                                Po uporabi desko čim prej obrišite, saj tako sokovom preprečite, da bi prodrli v les, hrana
                                pa naslednjič ne bo imela okusa po prejšnji ki ste jo rezali na deski.
                            </li>
                            <li class="pb-05">Po pripravi surovega mesa desko razkužite. Uporabite bodisi
                                alkohol ali beli kis.</li>
                            <li class="pb-05">Če deska zaudarja, ji lahko svežino povrnete tako, da po
                                površini deske podrgnete napol prerezano limono, počakate par minut, nato pa površino deske
                                temeljito obrišete.</li>
                            <li class="pb-05">Ob pojavu trdovratnih madežev na njih potresite sodo bikarbono
                                in površino zdrgnite z vlažno toplo krpo. Na koncu odvečno sodo bikarbono temeljito obrišite
                                iz površine.</li>
                        </ul>
                    </div>
                    <div class="blob-container">
                        <img loading="lazy" class="blob-image blob-image-abs-sl blob-image-end"
                            src="{{ asset('images/blobcomp1.svg') }}" alt="">
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
                So ti izdelki, ki niso več na voljo, všeč in bi si želel/a kaj podobnega? Potem mi pišite preko kontaktnega
                obrazca spodaj, na email naslov <a class="email"
                    href="mailto:pragwaldwoodworks@gmail.com">pragwaldwoodworks@gmail.com</a>, ali pa pokličite na
                <a class="email" href="">051 318 599</a>. Nobena želja ni prevelika!
            </p>
            <div>
                <send-message></send-message>
            </div>
        </div>
    </section>
@endsection
