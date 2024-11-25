<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form method="POST" action="{{ route('link.store') }}">
                    @csrf

                    <x-auth-session-status :status="session('status')" />

                    <x-text-input type="hidden" name="position" :value="$position" />

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="url" :value="__('Link')" />
                        <x-text-input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required autofocus />
                        <x-input-error :messages="$errors->get('url')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        @if ($colors)
                                <x-input-label for="color" :value="__('Color')" />
                                <select id="color" name="color_id" class="rounded-md w-full p-2 cursor-pointer">
                                    <option value="">{{ __('Choose an option') }}</option>
                                    @foreach ($colors as $color)
                                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('color_id')" class="mt-2" />
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
