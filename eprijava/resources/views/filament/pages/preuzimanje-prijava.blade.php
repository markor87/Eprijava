<x-filament-panels::page>
    <div
        x-data="{
            isGenerating: false,
            current: 0,
            total: 0,
            source: null,

            startFetch(competitionId) {
                this.isGenerating = true;
                this.current = 0;
                this.total = 0;

                this.source = new EventSource('/generate-competition-zip/' + competitionId);

                this.source.onmessage = (event) => {
                    const data = JSON.parse(event.data);
                    if (data.done) {
                        this.source.close();
                        this.source = null;
                        this.triggerDownload(data.token, data.filename);
                    } else {
                        this.current = data.current;
                        this.total   = data.total;
                    }
                };

                this.source.onerror = () => {
                    if (this.source) { this.source.close(); this.source = null; }
                    this.isGenerating = false;
                    this.$wire.call('finishDownload');
                };
            },

            triggerDownload(token, filename) {
                const a = document.createElement('a');
                a.href = '/download-competition-zip/' + token;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                this.isGenerating = false;
                this.$wire.call('finishDownload');
            }
        }"
        @start-zip-generation.window="startFetch($event.detail.competitionId)"
    >
        <div
            x-show="isGenerating"
            x-cloak
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 mb-6"
        >
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Генерисање PDF пријава&hellip;
                </span>
                <span class="text-sm tabular-nums text-gray-500 dark:text-gray-400">
                    <span x-text="current"></span>&nbsp;/&nbsp;<span x-text="total"></span>
                </span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700 overflow-hidden">
                <div
                    class="bg-primary-600 h-3 rounded-full transition-all duration-300 ease-out"
                    :style="'width: ' + (total > 0 ? Math.round(current / total * 100) : 0) + '%'"
                ></div>
            </div>

            <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                Молимо не затварајте ову страницу током преузимања.
            </p>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
