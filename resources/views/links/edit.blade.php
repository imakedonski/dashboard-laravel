<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form method="POST" action="{{ route('link.update', ['link' => $link]) }}">
                    @csrf
                    @method('PUT')
                    <x-auth-session-status :status="session('status')" class="mb-4" />

                    <x-text-input type="hidden" name="id" :value="$link->id" />

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$link->title" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="url" :value="__('Link')" />
                        <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="$link->url" required autofocus />
                        <x-input-error :messages="$errors->get('link')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        @if ($colors)
                            <x-input-label for="color" :value="__('Color')" />
                            <select id="color" name="color_id" class="rounded-md w-full p-2 cursor-pointer">
                                <option value="">{{ __('Choose an option') }}</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}"{{ $link->color_id === $color->id ? ' selected' : '' }}>{{ $color->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('color')" class="mt-2" />
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-3">
                            {{ __('Submit') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
