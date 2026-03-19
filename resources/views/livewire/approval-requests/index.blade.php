<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                Approval requests
            </h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                Review, filter and process incoming requests.
            </p>
        </div>

        <a
            href="{{ route('requests.create') }}"
            wire:navigate
            class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500"
        >
            New request
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/40 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="md:col-span-2">
                <label for="search" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">
                    Search
                </label>

                <input
                    id="search"
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by title..."
                    class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 placeholder:text-zinc-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white dark:placeholder:text-zinc-500"
                >
            </div>

            <div>
                <label for="status" class="mb-2 block text-sm font-medium text-zinc-800 dark:text-zinc-200">
                    Status
                </label>

                <select
                    id="status"
                    wire:model.live="status"
                    class="block w-full rounded-2xl border border-zinc-300 bg-white px-4 py-3 text-sm text-zinc-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white"
                >
                    <option value="">All statuses</option>

                    @foreach ($statuses as $statusOption)
                        <option value="{{ $statusOption }}">
                            {{ str($statusOption)->headline() }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-800">
                <thead class="bg-zinc-50 dark:bg-zinc-950/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Request
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Status
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Created by
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Created
                    </th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                        Actions
                    </th>
                </tr>
                </thead>

                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($requests as $request)
                    <tr class="align-top">
                        <td class="px-6 py-4">
                            <div class="max-w-xl">
                                <p class="font-medium text-zinc-900 dark:text-white">
                                    <a
                                        href="{{ route('requests.index') }}"
                                        wire:navigate
                                        class="font-medium text-zinc-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400"
                                    >
                                        {{ $request->title }}
                                    </a>
                                </p>

                                @if ($request->description)
                                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ Str::limit($request->description, 120) }}
                                    </p>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $badgeClasses = match ($request->status) {
                                    'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300',
                                    'rejected' => 'bg-red-100 text-red-700 dark:bg-red-950/50 dark:text-red-300',
                                    default => 'bg-amber-100 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300',
                                };
                            @endphp

                            @if ($request->isApproved() && $request->approver)
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    Approved by {{ $request->approver->name }}
                                </p>
                            @elseif ($request->isRejected() && $request->rejector)
                                <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    Rejected by {{ $request->rejector->name }}
                                </p>
                            @endif

                            @if ($request->isApproved() && $request->approved_at)
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $request->approved_at->format('d M Y, H:i') }}
                                </p>
                            @elseif ($request->isRejected() && $request->rejected_at)
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $request->rejected_at->format('d M Y, H:i') }}
                                </p>
                            @endif

                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeClasses }}">
                                    {{ str($request->status)->headline() }}
                                </span>
                        </td>

                        <td class="px-6 py-4 text-sm text-zinc-700 dark:text-zinc-300">
                            {{ $request->creator?->name ?? 'System' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $request->created_at->format('d M Y, H:i') }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                @if ($request->isPending())
                                    <button
                                        type="button"
                                        wire:click="approve({{ $request->id }})"
                                        wire:confirm="Approve this request?"
                                        class="inline-flex items-center rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-500"
                                    >
                                        Approve
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="reject({{ $request->id }})"
                                        wire:confirm="Reject this request?"
                                        class="inline-flex items-center rounded-xl bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-500"
                                    >
                                        Reject
                                    </button>
                                @else
                                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                                            Completed
                                        </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-zinc-500 dark:text-zinc-400">
                            No requests found for the current filters.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($requests->hasPages())
            <div class="border-t border-zinc-200 px-6 py-4 dark:border-zinc-800">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
