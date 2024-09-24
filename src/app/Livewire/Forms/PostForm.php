<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $post;

    #[Validate('string', 'required')]
    public $title;

    #[Validate('string', 'required')]
    public $slug;

    #[Validate('string', 'required')]
    public $content;

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->fill($post->only(['title', 'slug', 'content']));
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;

    }

    public function store()
    {
        $this->validate();
        Post::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);
    }

    public function update()
    {
        $this->validate();
        $this->post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);
        $this->reset();
    }
}
