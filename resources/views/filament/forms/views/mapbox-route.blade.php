<div
    class="w-full rounded-xl overflow-hidden border border-gray-300 dark:border-gray-700 bg-black relative"
    style="height: 500px"
    wire:ignore
    x-data="routeMap({
        token: @js(config('services.mapbox.token')),
        from: $wire.entangle(@js($fromStatePath)).live,
        to: $wire.entangle(@js($toStatePath)).live,
    })"
    x-init="boot()"
>
    <div
        x-ref="mapContainer"
        style="height: 600px"
        class="absolute inset-0"
    ></div>

    <template x-if="distance">
        <div class="absolute top-4 left-4 z-10 bg-black/80 p-3 rounded-lg text-white border border-white/10">
            <div class="text-[10px] uppercase text-amber-300 font-bold mb-1">
                Récapitulatif trajet
            </div>
            <div class="font-bold text-sm">
                <span x-text="distance"></span>
                —
                <span x-text="duration"></span>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('routeMap', (cfg) => ({
                token: cfg.token,
                from: cfg.from,
                to: cfg.to,

                map: null,
                distance: '',
                duration: '',
                routeId: 'route',
                markers: [],
                controller: null,

                coords(payload) {
                    return payload?.geometry?.coordinates ?? null;
                },

                async boot() {
                    await this.ensureMapboxLoaded();

                    mapboxgl.accessToken = this.token;

                    this.map = new mapboxgl.Map({
                        container: this.$refs.mapContainer,
                        style: 'mapbox://styles/mapbox/satellite-streets-v12',
                        center: [2.3522, 48.8566],
                        zoom: 11,
                        attributionControl: false,
                    });

                    this.map.on('load', () => {
                        this.redraw();
                        this.map.resize();
                    });

                    this.$watch('from', () => this.redraw());
                    this.$watch('to', () => this.redraw());

                    window.addEventListener('route:update', () => this.redraw());

                    setTimeout(() => this.map?.resize(), 300);
                },

                ensureMapboxLoaded() {
                    if (window.mapboxgl) return Promise.resolve();

                    return new Promise((resolve) => {
                        if (!document.getElementById('mapbox-gl-css')) {
                            const css = document.createElement('link');
                            css.id = 'mapbox-gl-css';
                            css.rel = 'stylesheet';
                            css.href = 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css';
                            document.head.appendChild(css);
                        }

                        const script = document.createElement('script');
                        script.src = 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js';
                        script.onload = resolve;
                        document.head.appendChild(script);
                    });
                },

                clearArtifacts() {
                    this.distance = '';
                    this.duration = '';

                    this.markers.forEach(m => m.remove());
                    this.markers = [];

                    if (!this.map) return;
                    if (this.map.getLayer(this.routeId)) this.map.removeLayer(this.routeId);
                    if (this.map.getSource(this.routeId)) this.map.removeSource(this.routeId);
                },

                async redraw() {
                    if (!this.map || !this.map.isStyleLoaded()) return;

                    const a = this.coords(this.from);
                    const b = this.coords(this.to);

                    if (!a || !b) {
                        this.clearArtifacts();
                        return;
                    }

                    if (this.controller) this.controller.abort();
                    this.controller = new AbortController();

                    try {
                        const res = await fetch(
                            `https://api.mapbox.com/directions/v5/mapbox/driving/` +
                            `${a[0]},${a[1]};${b[0]},${b[1]}` +
                            `?geometries=geojson&overview=full&access_token=${this.token}`,
                            { signal: this.controller.signal }
                        );

                        const data = await res.json();
                        const route = data?.routes?.[0];
                        if (!route?.geometry) return this.clearArtifacts();

                        this.clearArtifacts();

                        this.distance = (route.distance / 1000).toFixed(1) + ' km';
                        this.duration = Math.round(route.duration / 60) + ' min';

                        this.map.addSource(this.routeId, {
                            type: 'geojson',
                            data: {
                                type: 'Feature',
                                geometry: route.geometry,
                            },
                        });

                        this.map.addLayer({
                            id: this.routeId,
                            type: 'line',
                            source: this.routeId,
                            layout: {
                                'line-join': 'round',
                                'line-cap': 'round',
                            },
                            paint: {
                                'line-width': 5,
                            },
                        });

                        this.markers.push(
                            new mapboxgl.Marker().setLngLat(a).addTo(this.map),
                            new mapboxgl.Marker().setLngLat(b).addTo(this.map),
                        );

                        const bounds = new mapboxgl.LngLatBounds(a, a).extend(b);
                        this.map.fitBounds(bounds, { padding: 80 });
                    } catch (e) {
                        if (e.name !== 'AbortError') this.clearArtifacts();
                    }
                },
            }));
        });
    </script>
</div>
