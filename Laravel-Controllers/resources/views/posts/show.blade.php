<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('show post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>{{ $post->name }}</h1>
                    <p>{{ $post->body }}</p>

                    <form method="POST" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Delete') }}
                            </x-primary-button>
                        </div>
                    </form>
                    <div>
                        {{$post->comments}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
