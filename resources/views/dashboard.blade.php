<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="feedback" class="hidden text-xl md:text-4xl text-center mt-6"></div>
                <div class="p-6 text-gray-900 grid grid-cols-2 sm:grid-cols-3">
                    @foreach ($links as $position => $link)
                        <div class="relative w-1/9 m-4 p-2 hover:bg-gray-50 border border-gray-400 rounded-md flex flex-col lg:flex-row items-center justify-center">
                            @if ($link)
                                <a href="{{ $link->url }}" target="_blank" rel="nofollow" class="font-bold text-xl hover:underline" style="color: #{{ $link->color->hex_value }};">{{ $link->title }}</a>
                            @else
                                <x-add-link link="{{ route('link.create', ['position' => $position]) }}" />
                            @endif

                            @if ($link)
                            <div class="lg:hidden text-sm md:text-2xl">
                                <a href="{{ route('link.edit', ['id' => $link->id]) }}" class="text-blue-600">{{ __('Edit') }}</a>
                                <span class="mx-1">|</span>
                                <a href="javascript:void(0)" class="text-red-600 delete" data-link-id="{{ $link->id }}">{{ __('Delete') }}</a>
                            </div>

                            <div class="hidden lg:block absolute right-2 top-2">
                                <div class="flex">
                                    <a href="{{ $link ? route('link.edit', ['id' => $link->id]) : route('link.create', ['position' => $position]) }}" title="{{ __('Edit') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mr-2 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    <a href="javascript:void(0)" title="{{ __('Delete') }}" class="delete" data-link-id="{{ $link->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-red-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        const deleteURL = '{{ route('link.destroy') }}';
        const handlers = document.querySelectorAll('.delete');

        Array.from(handlers).map(handler => {
            handler.addEventListener('click', async (e) => {
                e.preventDefault();
                const confirmation = confirm('Are you sure you want to delete this link?');

                if (confirmation) {
                    try {
                        const response = await fetch(deleteURL, {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                id: e.currentTarget.getAttribute('data-link-id'),
                            }),
                        });

                        if (!response.ok) {
                            feedback('{{ __('Something went wrong, please try again later.') }}');
                            return;
                        }

                      const result = await response.json()
                      feedback(result['message'], result['success']);
                      setTimeout(() => window.location.reload(), 2000)
                    } catch (e) {
                        feedback('{{ __('Something went wrong, please try again later.') }}');
                        console.error(e)
                    }
                }
            });
        });

        function feedback(msg, success) {
            const feedback = document.getElementById('feedback');
            feedback.textContent = msg;
            feedback.classList.remove('hidden');
            const color = success ? 'text-green-600' : 'text-red-600';
            feedback.classList.add(color)
        }
    </script>
</x-app-layout>
