<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-mary-header title="Posts" subtitle="Lastest posts">
        <x-slot:middle class="!justify-end">
            <x-mary-input icon="o-bolt" wire:model.live="search" placeholder="Search..." />
        </x-slot:middle>
        <x-slot:actions>
            {{-- <x-mary-button icon="o-funnel" /> --}}
            <x-mary-button icon="o-plus" class="btn-primary" @click="$wire.showModal()" />
        </x-slot:actions>
    </x-mary-header>

    <x-mary-table :headers="$headers" :rows="$posts" :sort-by="$sortBy" with-pagination per-page="perPage" striped @row-click="$wire.edit($event.detail.id)">
        {{-- Overrides 'name' header --}}
        @scope('header_title', $header)
        <h2 class="text-xl font-bold text-orange-500">
            {{ $header['label'] }}
        </h2>
        @endscope

        @scope('header_slug', $header)
        <h2 class="text-xl font-bold text-orange-500">
            {{ $header['label'] }}
        </h2>
        @endscope

        @scope('header_content', $header)
        <h2 class="text-xl font-bold text-orange-500">
            {{ $header['label'] }}
        </h2>
        @endscope

        @scope('actions', $post)
        <x-mary-button icon="o-trash" wire:click="delete({{ $post->id }})" spinner class="btn-sm btn-error" onclick="event.stopPropagation();" />
        @endscope
    </x-mary-table>
    <x-mary-modal wire:model="postModal" class="backdrop-blur">
        <x-mary-form wire:submit="save">
            <x-mary-input label="Title" wire:model="form.title" />
            <x-mary-input label="Slug" wire:model="form.slug" />
            {{-- <x-mary-textarea label="Content" wire:model="form.content" placeholder="Your content ..." hint="Max 1000 chars" rows="5" inline /> --}}
            <template x-if="$wire.postModal">
                <x-mary-markdown wire:model="form.content" label="Content" />
            </template>
            <x-slot:actions>
                <x-mary-button label="Cancel" />
                <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
            </x-form>
    </x-mary-modal>
</div>