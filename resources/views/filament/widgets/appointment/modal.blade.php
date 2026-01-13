<div class="space-y-6">
    @if (!$record)
        <div class="text-sm text-gray-500">Rendez-vous introuvable.</div>
    @else
        <div class="space-y-1">
            <div class="text-lg font-bold">{{ $record->title }}</div>

            <div class="text-sm text-gray-600 dark:text-gray-300">
                Début :
                <span class="font-medium">{{ optional($record->starts_at)->format('d/m/Y H:i') }}</span>
                @if($record->ends_at)
                    — Fin :
                    <span class="font-medium">{{ optional($record->ends_at)->format('d/m/Y H:i') }}</span>
                @endif
            </div>

            @if($record->description)
                <div class="text-sm text-gray-600 dark:text-gray-300 whitespace-pre-wrap">
                    {{ $record->description }}
                </div>
            @endif
        </div>

        <div
            class="w-full rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-black relative"
            style="height: 420px;"
            x-data="{
        token: @js(config('services.mapbox.token')),
        start: @js($record->locations_from),
        end: @js($record->locations_to),

        map: null,
        distance: '',
        duration: '',
        warning: '',
        routeId: 'route',
        markers: [],
        controller: null,

        normalizeGeo(geo) {
            if (!geo) return null;
            if (typeof geo === 'string') {
                try { return JSON.parse(geo); } catch (_) { return null; }
            }
            return geo;
        },

        coords(geo) {
            const g = this.normalizeGeo(geo);
            const c = g?.geometry?.coordinates ?? g?.coordinates ?? null;

            if (!Array.isArray(c) || c.length < 2) return null;

            const lng = Number(c[0]);
            const lat = Number(c[1]);

            if (!Number.isFinite(lng) || !Number.isFinite(lat)) return null;

            return [lng, lat];
        },

        async boot() {
            await this.ensureMapboxLoaded();

            const a = this.coords(this.start);
            const b = this.coords(this.end);

            mapboxgl.accessToken = this.token;

            let center = [2.3522, 48.8566];
            if (a) center = a;
            if (!a && b) center = b;

            this.map = new mapboxgl.Map({
                container: this.$refs.mapContainer,
                style: 'mapbox://styles/mapbox/satellite-streets-v12',
                center,
                zoom: 12,
                attributionControl: false,
            });

            this.map.on('load', async () => {
                await this.redraw();
                this.map.resize();
            });

            // modal sizing fix
            setTimeout(() => this.map?.resize(), 250);
            setTimeout(() => this.map?.resize(), 800);
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

                const existing = document.getElementById('mapbox-gl-js');
                if (existing) {
                    if (window.mapboxgl) return resolve();
                    existing.addEventListener('load', resolve, { once: true });
                    return;
                }

                const script = document.createElement('script');
                script.id = 'mapbox-gl-js';
                script.src = 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js';
                script.onload = resolve;
                document.head.appendChild(script);
            });
        },

        clearArtifacts() {
            this.distance = '';
            this.duration = '';
            this.warning = '';

            this.markers.forEach(m => m.remove());
            this.markers = [];

            if (!this.map) return;
            if (this.map.getLayer(this.routeId)) this.map.removeLayer(this.routeId);
            if (this.map.getSource(this.routeId)) this.map.removeSource(this.routeId);
        },

        async redraw() {
            if (!this.map || !this.map.isStyleLoaded()) return;

            const a = this.coords(this.start);
            const b = this.coords(this.end);

            if (!a && !b) {
                this.warning = 'Aucune coordonnée à afficher.';
                return;
            }

            if ((a && !b) || (!a && b)) {
                const p = a || b;

                this.clearArtifacts();
                this.markers.push(new mapboxgl.Marker().setLngLat(p).addTo(this.map));
                this.map.flyTo({ center: p, zoom: 14 });
                this.warning = 'Itinéraire indisponible : une seule position est renseignée.';
                return;
            }

            if (this.controller) this.controller.abort();
            this.controller = new AbortController();

            const url =
                `https://api.mapbox.com/directions/v5/mapbox/driving/` +
                `${a[0]},${a[1]};${b[0]},${b[1]}` +
                `?geometries=geojson&overview=full&access_token=${encodeURIComponent(this.token)}`;

            let data;
            try {
                const res = await fetch(url, { signal: this.controller.signal });
                data = await res.json();
            } catch (e) {
                if (e.name !== 'AbortError') this.warning = 'Erreur lors du chargement de l’itinéraire.';
                return;
            }

            const route = data?.routes?.[0];
            if (!route?.geometry) {
                this.warning = 'Aucun itinéraire trouvé.';
                return;
            }

            this.clearArtifacts();

            this.distance = (route.distance / 1000).toFixed(1) + ' km';
            this.duration = Math.round(route.duration / 60) + ' min';

            this.map.addSource(this.routeId, {
                type: 'geojson',
                data: { type: 'Feature', properties: {}, geometry: route.geometry },
            });

            this.map.addLayer({
                id: this.routeId,
                type: 'line',
                source: this.routeId,
                layout: { 'line-join': 'round', 'line-cap': 'round' },
                paint: { 'line-width': 5 },
            });

            this.markers.push(
                new mapboxgl.Marker().setLngLat(a).addTo(this.map),
                new mapboxgl.Marker().setLngLat(b).addTo(this.map),
            );

            const bounds = new mapboxgl.LngLatBounds(a, a).extend(b);
            this.map.fitBounds(bounds, { padding: 70 });
        },
    }"
            x-init="boot()"
        >
            <div x-ref="mapContainer" style="height: 600px;" class="absolute inset-0"></div>

            <template x-if="distance">
                <div class="absolute top-3 left-3 z-10 bg-black/70 p-2 rounded-lg text-white border border-white/10">
                    <div class="text-[10px] uppercase text-amber-300 font-bold mb-1">Trajet</div>
                    <div class="font-bold text-sm">
                        <span x-text="distance"></span> — <span x-text="duration"></span>
                    </div>
                </div>
            </template>

            <template x-if="warning">
                <div class="absolute top-3 left-3 z-10 bg-black/70 p-2 rounded-lg text-white border border-white/10">
                    <span x-text="warning"></span>
                </div>
            </template>
        </div>


    @endif
</div>
