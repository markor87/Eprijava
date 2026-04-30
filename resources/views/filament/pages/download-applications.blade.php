<x-filament-panels::page>
    <div
        x-data="{
            isGenerating: false,
            current: 0,
            total: 0,
            source: null,
            startTime: null,
            eta: '',
            cancelKey: null,
            competitionId: null,
            downloadTriggered: false,

            formatTime(s) {
                if (!isFinite(s) || s < 0) return '';
                const h = Math.floor(s / 3600);
                const m = Math.floor((s % 3600) / 60);
                const sec = Math.floor(s % 60);
                if (h > 0) return h + 'h ' + m + 'm ' + sec + 's';
                if (m > 0) return m + 'm ' + sec + 's';
                return sec + 's';
            },

            percent() {
                return this.total > 0 ? Math.round(this.current / this.total * 100) : 0;
            },

            competitionId: null,

            startFetch(competitionId) {
                this.isGenerating = true;
                this.competitionId = competitionId;
                this.current = 0;
                this.total = 0;
                this.eta = '';
                this.cancelKey = null;
                this.downloadTriggered = false;
                this.startTime = Date.now();

                this.source = new EventSource('/generate-competition-zip/' + competitionId);

                this.source.onmessage = (event) => {
                    const data = JSON.parse(event.data);
                    if (data.done) {
                        this.source.close();
                        this.source = null;
                        this.triggerDownload(data.token, data.filename);
                    } else if (data.cancelled) {
                        this.source.close();
                        this.source = null;
                        this.isGenerating = false;
                        this.$wire.call('finishDownload');
                    } else {
                        if (data.cancelKey) this.cancelKey = data.cancelKey;
                        this.current = data.current;
                        this.total   = data.total;
                        if (this.current > 0) {
                            const elapsed = (Date.now() - this.startTime) / 1000;
                            const rate = this.current / elapsed;
                            this.eta = this.formatTime(Math.round((this.total - this.current) / rate));
                        }
                        if (this.current === this.total && this.total > 0) {
                            setTimeout(() => { if (this.isGenerating) this.pollForZip(); }, 2000);
                        }
                    }
                };

                this.source.onerror = () => {
                    if (this.source) { this.source.close(); this.source = null; }
                    this.pollForZip();
                };
            },

            pollForZip() {
                this.$wire.call('checkZipReady', this.competitionId).then(() => {
                    if (this.isGenerating) {
                        setTimeout(() => this.pollForZip(), 10000);
                    }
                });
            },

            stop() {
                if (this.source) { this.source.close(); this.source = null; }
                this.isGenerating = false;
                this.$wire.call('finishDownload');
                if (this.cancelKey) {
                    fetch('/cancel-competition-zip/' + this.cancelKey, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        }
                    });
                    this.cancelKey = null;
                }
            },

            triggerDownload(token, filename) {
                if (this.downloadTriggered) return;
                this.downloadTriggered = true;
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
        x-on:zip-ready.window="triggerDownload($event.detail.token, $event.detail.filename)"
    >
        {{-- Modal --}}
        <template x-teleport="body">
            <div
                x-show="isGenerating"
                x-cloak
                style="position:fixed;inset:0;z-index:9999;"
            >
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;padding:1rem;">
                {{-- Backdrop --}}
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.65);"></div>

                {{-- Dialog --}}
                <div style="position:relative;width:100%;max-width:420px;border-radius:16px;background:#1f2937;padding:2rem;box-shadow:0 25px 60px rgba(0,0,0,0.5);">

                    {{-- Circular progress --}}
                    <div style="display:flex;justify-content:center;margin-bottom:1.5rem;">
                        <div style="position:relative;width:96px;height:96px;display:flex;align-items:center;justify-content:center;">
                            <svg width="96" height="96" viewBox="0 0 96 96" style="position:absolute;top:0;left:0;transform:rotate(-90deg);">
                                <circle cx="48" cy="48" r="40" fill="none" stroke="#374151" stroke-width="7"/>
                                <circle cx="48" cy="48" r="40" fill="none" stroke="#6366f1" stroke-width="7"
                                    stroke-linecap="round"
                                    stroke-dasharray="251.3"
                                    :stroke-dashoffset="251.3 - (251.3 * percent() / 100)"
                                    style="transition:stroke-dashoffset 0.3s ease-out;"/>
                            </svg>
                            <span style="position:relative;font-size:1rem;font-weight:700;color:#f9fafb;font-variant-numeric:tabular-nums;"
                                x-text="percent() + '%'"></span>
                        </div>
                    </div>

                    {{-- Title --}}
                    <p style="text-align:center;font-size:1.125rem;font-weight:600;color:#f9fafb;margin:0 0 0.25rem;">Генерисање пријава</p>
                    <p style="text-align:center;font-size:0.875rem;color:#9ca3af;margin:0 0 1.5rem;">Молимо сачекајте, не затварајте страницу.</p>

                    {{-- Linear progress bar --}}
                    <div style="width:100%;background:#374151;border-radius:999px;height:8px;overflow:hidden;margin-bottom:0.75rem;">
                        <div style="height:8px;border-radius:999px;background:#6366f1;transition:width 0.3s ease-out;"
                            :style="'width:' + percent() + '%'"></div>
                    </div>

                    {{-- Stats --}}
                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;font-variant-numeric:tabular-nums;margin-bottom:1.5rem;">
                        <span style="color:#9ca3af;">
                            <span style="color:#f9fafb;font-weight:600;" x-text="current"></span>
                            &nbsp;/&nbsp;<span x-text="total"></span> пријава
                        </span>
                        <span style="color:#9ca3af;" x-show="eta">
                            преостало:&nbsp;<span style="color:#f9fafb;font-weight:600;" x-text="eta"></span>
                        </span>
                    </div>

                    {{-- Stop button --}}
                    <button
                        @click="stop()"
                        type="button"
                        style="width:100%;padding:0.625rem 1rem;border-radius:8px;border:1px solid #ef4444;background:transparent;color:#ef4444;font-size:0.875rem;font-weight:500;cursor:pointer;"
                        onmouseover="this.style.background='rgba(239,68,68,0.1)'"
                        onmouseout="this.style.background='transparent'"
                    >
                        Заустави преузимање
                    </button>
                </div>
                </div>
            </div>
        </template>

        {{ $this->table }}
    </div>
</x-filament-panels::page>
