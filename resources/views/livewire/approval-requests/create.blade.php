<div class="space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                New approval request
            </h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                Create a new request and send it into the approval workflow.
            </p>
        </div>

        <a
            href="{{ route('dashboard') }}"
            wire:navigate
            class="inline-flex items-center rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
        >
            Back
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <form wire:submit="save" class="space-y-6">
            <div class="space-y-2">
                <label for="title" class="block text-sm font-medium text-zinc-800 dark:text-zinc-200">
                    Title
                </label>

                <input
                    id="title"
                    type="text"
                    wire:model.blur="title"
                    placeholder="Example: Approve new supplier contract"
                    autofocus
                    class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500"
                >

                @error('title')
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-medium text-zinc-800 dark:text-zinc-200">
                    Description
                </label>

                <textarea
                    id="description"
                    wire:model.blur="description"
                    rows="6"
                    placeholder="Add context, budget impact, people involved, deadlines, or anything the reviewer should know..."
                    class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500"
                ></textarea>

                @error('description')
                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button
                    type="button"
                    wire:click="$set('title', ''); $set('description', '')"
                    class="inline-flex items-center rounded-2xl border border-zinc-200 bg-white px-5 py-3 text-sm font-semibold text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800"
                >
                    Clear
                </button>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span wire:loading.remove wire:target="save">Create request</span>
                    <span wire:loading wire:target="save">Creating...</span>
                </button>
            </div>
        </form>
    </div>
</div>
