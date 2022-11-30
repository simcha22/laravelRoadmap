<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @foreach ($comments as $comment)
                        <p>This is comment {{ $comment->id }}</p>

                        <p>{{ $comment->body }}</p>
                        <div>
{{--                            <x-nav-link :href="route('comments.edit', ['comment' => $comment->id])">Edit</x-nav-link>--}}
{{--                            <x-nav-link :href="route('comments.show', ['comment' => $comment->id])">Show</x-nav-link>--}}
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
