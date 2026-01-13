<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        class="relative"
        x-data="adressePicker({
            state: $wire.entangle('{{ $getStatePath() }}').live,
            showedKey: @js($field->getShowedKey()),
        })"
    >
        <div class="flex gap-2">
            <div class="fi-input-wrp w-full">
                <x-filament::input
                    x-model="query"
                    placeholder="Rechercher une adresse…"
                    @input.debounce.300ms="search()"
                    @focus="open = true"
                />
            </div>

            <x-filament::button
                color="gray"
                type="button"
                @click="clear()"
            >
                Effacer
            </x-filament::button>
        </div>

        <!-- Aperçu sélection -->
        <template x-if="state && get(state, showedKey)">
            <div class="mt-3 rounded-lg border border-gray-200 dark:border-gray-700 p-3">
                <div class="font-semibold truncate" x-text="get(state, showedKey)"></div>

                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    <template x-if="state?.properties?.postcode || state?.properties?.city">
                        <span x-text="formatCity(state)"></span>
                    </template>

                    <template x-if="state?.properties?.context">
                        <span> • </span>
                        <span x-text="state.properties.context"></span>
                    </template>
                </div>

                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <template x-if="coords(state)">
                        <span>
                            GPS :
                            <span x-text="coords(state)[1].toFixed(6)"></span>,
                            <span x-text="coords(state)[0].toFixed(6)"></span>
                        </span>
                    </template>
                </div>
            </div>
        </template>

        <!-- Dropdown -->
        <div
            x-show="open"
            x-transition
            class="absolute z-50 mt-2 w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow"
            @click.outside="open = false"
        >
            <div class="p-2 text-sm text-gray-500" x-show="loading">
                Recherche…
            </div>

            <div class="p-2 text-sm text-gray-500" x-show="!loading && results.length === 0">
                Aucun résultat.
            </div>

            <template x-for="(item, idx) in results" :key="item.properties.id ?? idx">
                <button
                    type="button"
                    class="w-full text-left p-2 hover:bg-gray-50 dark:hover:bg-gray-800"
                    @click="select(item)"
                >
                    <div class="font-medium truncate" x-text="item.properties.label"></div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        <span x-text="item.properties.context ?? ''"></span>
                    </div>
                </button>
            </template>
        </div>

        <script>
            function adressePicker({ state, showedKey }) {
                return {
                    state,
                    showedKey,
                    query: '',
                    open: false,
                    loading: false,
                    results: [],
                    controller: null,

                    get(obj, path) {
                        return path
                            ?.split('.')
                            .reduce((acc, k) => acc?.[k], obj);
                    },

                    coords(obj) {
                        return obj?.geometry?.coordinates ?? null;
                    },

                    formatCity(obj) {
                        const pc = obj?.properties?.postcode ?? '';
                        const city = obj?.properties?.city ?? '';
                        return `${pc} ${city}`.trim();
                    },

                    async search() {
                        const q = this.query.trim();

                        if (q.length < 3) {
                            this.results = [];
                            this.open = false;
                            return;
                        }

                        this.loading = true;
                        this.open = true;

                        if (this.controller) this.controller.abort();
                        this.controller = new AbortController();

                        try {
                            const res = await fetch(
                                `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(q)}&limit=8`,
                                { signal: this.controller.signal }
                            );

                            const json = await res.json();
                            this.results = json.features ?? [];
                        } catch (e) {
                            if (e.name !== 'AbortError') this.results = [];
                        } finally {
                            this.loading = false;
                        }
                    },

                    select(feature) {
                        this.state = {
                            type: feature.type,
                            properties: feature.properties,
                            geometry: feature.geometry,
                        };

                        this.query =
                            this.get(this.state, this.showedKey)
                            || feature.properties.label
                            || '';

                        this.open = false;

                        this.$nextTick(() =>
                            window.dispatchEvent(new Event('route:update'))
                        );
                    },

                    clear() {
                        this.state = null;
                        this.query = '';
                        this.results = [];
                        this.open = false;

                        this.$nextTick(() =>
                            window.dispatchEvent(new Event('route:update'))
                        );
                    },

                    init() {
                        const label = this.get(this.state, this.showedKey);
                        if (label) this.query = label;
                    },
                };
            }
        </script>
    </div>
</x-dynamic-component>
