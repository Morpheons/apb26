<div class="w-full rounded-xl overflow-hidden border border-gray-300 dark:border-gray-700 bg-black"
     style="height: 500px; min-height: 500px; position: relative;"
     x-data="{
        map: null,
        token: '{{ config('services.mapbox.token') }}',
        distance: '',
        duration: '',
        // Récupération directe depuis le modèle Eloquent
{{--        startAddr: '{{ $getRecord()->start_address ?? '28 Za de Kerbiquet 29260 Plouider' }}',--}}
{{--        destAddr: '{{ $getRecord()->address }}',--}}
        startAddr: @js($getRecord()->start_address ?? '28 Za de Kerbiquet 29260 Plouider'),
        destAddr: @js($getRecord()->address),
        init() {
            this.loadMapbox();
        },

        loadMapbox() {
            if (typeof mapboxgl !== 'undefined') {
                this.setupMap();
            } else if (!document.getElementById('mapbox-gl-js')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet'; link.href = 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css';
                document.head.appendChild(link);
                const script = document.createElement('script');
                script.id = 'mapbox-gl-js'; script.src = 'https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js';
                script.onload = () => this.setupMap();
                document.head.appendChild(script);
            }
        },

        setupMap() {
            mapboxgl.accessToken = this.token;
            this.map = new mapboxgl.Map({
                container: this.$refs.mapContainer,
                style: 'mapbox://styles/mapbox/satellite-streets-v12',
                center: [2.3522, 48.8566],
                zoom: 11,
                attributionControl: false
            });

            this.map.on('load', () => {
                this.calculateRoute();
                this.map.resize();
            });
            setTimeout(() => this.map.resize(), 500);
        },

        async calculateRoute() {
            if (!this.destAddr) return;
            const startCoords = await this.geocode(this.startAddr);
            const destCoords = await this.geocode(this.destAddr);
            if (!startCoords || !destCoords) return;

            const res = await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${startCoords[0]},${startCoords[1]};${destCoords[0]},${destCoords[1]}?geometries=geojson&access_token=${this.token}`);
            const data = await res.json();
            if (!data.routes?.length) return;

            const route = data.routes[0];
            this.distance = (route.distance / 1000).toFixed(1) + ' km';
            this.duration = Math.round(route.duration / 60) + ' min';

            this.map.addSource('route', { 'type': 'geojson', 'data': { 'type': 'Feature', 'geometry': route.geometry } });
            this.map.addLayer({
                'id': 'route', 'type': 'line', 'source': 'route',
                'layout': { 'line-join': 'round', 'line-cap': 'round' },
                'paint': { 'line-color': '#facc15', 'line-width': 5 }
            });

            new mapboxgl.Marker({ color: '#3b82f6' }).setLngLat(startCoords).addTo(this.map);
            new mapboxgl.Marker({ color: '#facc15' }).setLngLat(destCoords).addTo(this.map);

            const bounds = new mapboxgl.LngLatBounds(startCoords, startCoords).extend(destCoords);
            this.map.fitBounds(bounds, { padding: 80 });
        },

        async geocode(query) {
            try {
                const res = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${this.token}`);
                const data = await res.json();
                return data.features?.[0]?.center;
            } catch (e) { return null; }
        }
     }">

    <div x-ref="mapContainer" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>

    <template x-if="distance">
        <div style="position: absolute; top: 15px; left: 15px; z-index: 10; background: rgba(0,0,0,0.85); padding: 12px; border-radius: 8px; color: white; border: 1px solid rgba(255,255,255,0.1); font-family: sans-serif;">
            <div style="font-size: 10px; text-transform: uppercase; color: #facc15; font-weight: bold; margin-bottom: 4px;">Récapitulatif Trajet</div>
            <div style="font-weight: bold; font-size: 14px;">
                <span x-text="distance"></span> — <span x-text="duration"></span>
            </div>
        </div>
    </template>
</div>
