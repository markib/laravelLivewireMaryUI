<?php

namespace App\Livewire;

use App\Livewire\Forms\PostForm;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class PostIndex extends Component
{
    use Toast;
    use WithPagination;
    public PostForm $form;

    public bool $postModal = false;

    public bool $editMode = false;

    public $search = '';
    public array $sortBy = ['column' => 'title', 'direction' => 'asc'];
    public int $perPage = 10;

    public function showModal()
    {
        $this->form->reset();
        $this->postModal = true;
        $this->editMode = false;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->form->update();
            $this->editMode = false;
            $this->success('Updated Successfully');
        } else {
            $this->form->store();
            $this->success('Save Successfully');
        }
        $this->postModal = false;
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $this->form->setPost($post);
        $this->editMode = true;
        $this->postModal = true;

    }

    public function delete($id)
    {
        Post::find($id)->delete();
        $this->warning('Deleted Successfully');
        // session()->flash('flash.banner', 'Post Deleted Successfully');
        //   $this->form->reset();
    }

    public function render()
    {

        $headers = [
            ['key' => 'title', 'label' => 'Title', 'class' => ''],
            ['key' => 'slug', 'label' => 'Slug'],
            ['key' => 'content', 'label' => 'Content'],
        ];

        return view('livewire.post-index', [
            'posts' => Post::where('title', 'LIKE', '%' . $this->search . '%')->orderBy(...array_values($this->sortBy))->paginate($this->perPage),
            'headers' => $headers,
        ]);
    }
}
